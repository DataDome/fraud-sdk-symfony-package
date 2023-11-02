<?php

namespace DataDome\FraudSdkSymfony\Config;

class DataDomeOptions
{
    public int $timeout = 1500;
    public string $endpoint = "https://account-api.datadome.co";
    public string $fraudApiKey = "";
    public string $endpointVersion = "/v1";

    public function __construct(string $fraudApiKey, ?int $timeout = null, ?string $endpoint = null) {
        $this->fraudApiKey = $fraudApiKey;

        if ($timeout != null) {
            $this->timeout = $timeout;
        }

        if ($endpoint != null) {
            $endpoint = $this->enforceHttps($endpoint);
            $this->endpoint = $endpoint;
        }
    }

    private function enforceHttps(string $inputEndPointUrl): string
    {
        $configuredEndpoint = $inputEndPointUrl;
        $startString = "https://";
        $len = strlen($startString);

        if (!(substr($inputEndPointUrl, 0, $len) === $startString)) {
            if (!str_contains($inputEndPointUrl, "://")) {
                $configuredEndpoint = "https://" . $inputEndPointUrl;
            }
        }

        return $configuredEndpoint;
    }
}
