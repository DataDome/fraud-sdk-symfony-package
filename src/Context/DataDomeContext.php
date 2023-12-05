<?php

namespace DataDome\FraudSdkSymfony\Context;

use DataDome\FraudSdkSymfony\Config\DataDomeOptions;
use DataDome\FraudSdkSymfony\Models\ActionType;
use DataDome\FraudSdkSymfony\Models\DataDomeEvent;
use DataDome\FraudSdkSymfony\Models\DataDomeResponse;
use DataDome\FraudSdkSymfony\Models\DataDomeResponseError;
use DataDome\FraudSdkSymfony\Models\LoginBody;
use DataDome\FraudSdkSymfony\Models\StatusType;
use DataDome\FraudSdkSymfony\Models\OperationType;
use DataDome\FraudSdkSymfony\Models\RegistrationBody;
use DataDome\FraudSdkSymfony\Models\ResponseAction;
use DataDome\FraudSdkSymfony\Models\ResponseStatus;
use Exception;
use ErrorException;
use stdClass;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DataDomeContext
{
    private DataDomeOptions $dataDomeOptions;
    private HttpClientInterface $httpClient;

    public function __construct(DataDomeOptions $dataDomeOptions)
    {
        $this->dataDomeOptions = $dataDomeOptions;

        $timeoutInSeconds = $this->dataDomeOptions->timeout / 1000;

        $this->httpClient = HttpClient::create([
            "headers" => [
                "accept" => "application/json",
                "content-type" => "application/json",
                "x-api-key" => $this->dataDomeOptions->fraudApiKey,
            ],
            "timeout" => $timeoutInSeconds
        ]);
    }

    /**
     * @throws ErrorException
     */
    public function requestDataDomeAPI(OperationType $operationType, Request $request, DataDomeEvent $event)
    {
        $body = null;
        $url = "";

        if ($event->actionType == ActionType::Login) {
            if ($operationType == OperationType::Validate) {
                $url .= "/validate/login";
                $body = new LoginBody($request, $event, StatusType::Succeeded);
            } else if ($operationType == OperationType::Collect) {
                $url .= "/collect/login";
                $body = new LoginBody($request, $event, StatusType::Failed);
            }
        } else if ($event->actionType == ActionType::Registration) {
            $body = new RegistrationBody($request, $event);

            if ($operationType == OperationType::Validate) {
                $url .= "/validate/registration";
            } else if ($operationType == OperationType::Collect) {
                $url .= "/collect/registration";
            }
        }

        if ($body == null) {
            throw new ErrorException("Invalid DataDome event provided");
        }

        return $this->processRequestDataDomeAPI($body, $url);
    }

    private function recursive_filter_empty($data) {
        if (is_array($data)) {
            $filtered_data = [];

            foreach ($data as $key => $value) {
                $filtered_value = $this->recursive_filter_empty($value);

                if ($filtered_value !== null && $filtered_value !== '') {
                    $filtered_data[$key] = $filtered_value;
                }
            }

            return $filtered_data == [] ? null : $filtered_data;
        } elseif (is_object($data)) {
            $filtered_data = new stdClass();

            foreach ($data as $key => $value) {
                $filtered_value = $this->recursive_filter_empty($value);

                if ($filtered_value !== null && $filtered_value !== '') {
                    $filtered_data->$key = $filtered_value;
                }
            }

            return empty(get_object_vars($filtered_data)) ? null : $filtered_data;
        }

        return $data;
    }

    private function json_encode_ignore_empty($object): bool|string
    {
        // Recursively filter out null values and empty strings
        $filtered_object = $this->recursive_filter_empty($object);

        // Encode the filtered object to JSON
        return json_encode($filtered_object, JSON_UNESCAPED_UNICODE);
    }

    private function processRequestDataDomeAPI(LoginBody|RegistrationBody $body, string $url)
    {
        try {
            $content = $this->json_encode_ignore_empty($body);

            $endpoint = trim($this->dataDomeOptions->endpoint, "/");
            $endpointVersion = trim($this->dataDomeOptions->endpointVersion, "/");
            $uri = $endpoint . "/" . $endpointVersion . $url;

            $response = $this->httpClient->request("POST", $uri, [
                "body" => $content,
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = $response->getContent();

            if ($statusCode == 200) {
                return json_decode($responseBody);
            } else if ($statusCode == 201) {
                $result = new DataDomeResponse();
                $result->status = ResponseStatus::OK;
                $result->reasons[] = $responseBody;

                return $result;
            } else {
                $decodedJson = json_decode($responseBody);

                if ($decodedJson == null) {
                    throw new Exception("Forcing a failure response.");
                }

                return $decodedJson;
            }
        } catch (TransportExceptionInterface $e) {
            $result = new DataDomeResponseError();
            $result->status = ResponseStatus::Timeout;
            $result->action = ResponseAction::Allow;
            $result->message = "Request timed out after " . $this->dataDomeOptions->timeout . " milliseconds";

            return $result;
        } catch (ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|Exception $e) {
            $result = new DataDomeResponseError();
            $result->status = ResponseStatus::Failure;
            $result->action = ResponseAction::Allow;
            $result->message = "Error in DataDome API response";

            return $result;
        }
    }
}
