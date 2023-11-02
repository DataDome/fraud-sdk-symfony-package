<?php

namespace DataDome\FraudSdkSymfony;

use DataDome\FraudSdkSymfony\Config\DataDomeOptions;
use DataDome\FraudSdkSymfony\Context\DataDomeContext;
use DataDome\FraudSdkSymfony\Models\DataDomeEvent;
use DataDome\FraudSdkSymfony\Models\DataDomeResponse;
use DataDome\FraudSdkSymfony\Models\DataDomeResponseError;
use DataDome\FraudSdkSymfony\Models\OperationType;
use ErrorException;
use Symfony\Component\HttpFoundation\Request;

class DataDome
{
    private DataDomeContext $dataDomeContext;
    private DataDomeOptions $dataDomeOptions;

    public function __construct(DataDomeOptions $options) {
        $this->dataDomeOptions = new DataDomeOptions($options->fraudApiKey, $options->timeout, $options->endpoint);

        $this->dataDomeContext = new DataDomeContext($this->dataDomeOptions);
    }

    /**
     * Validate if the event should be allowed or denied.
     *
     * @param Request $request Request to retrieve header information.
     * @param DataDomeEvent $event <see ref="DataDomeEvent">Event</see> payload to inform DataDome about a request.
     * @return DataDomeResponse|DataDomeResponseError|mixed
     * @throws ErrorException
     */
    public function validate(Request $request, DataDomeEvent $event): mixed
    {
        return $this->dataDomeContext->requestDataDomeAPI(OperationType::Validate, $request, $event);
    }

    /**
     * Enrich the DataDome engine.
     *
     * @param Request $request Request to retrieve header information.
     * @param DataDomeEvent $event <see ref="DataDomeEvent">Event</see> payload to inform DataDome about a request.
     * @return DataDomeResponse|DataDomeResponseError|mixed
     * @throws ErrorException
     */
    public function collect(Request $request, DataDomeEvent $event): mixed
    {
        return $this->dataDomeContext->requestDataDomeAPI(OperationType::Collect, $request, $event);
    }
}
