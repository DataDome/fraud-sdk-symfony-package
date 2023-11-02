<?php

namespace DataDome\FraudSdkSymfony\Models;

use Composer\InstalledVersions;

/**
 * Names of the form fields in the Module object to be sent to the API.
 */
class Module
{
    /**
     * @var float Timestamp of the request, in microseconds.
     */
    public float $requestTimeMicros;
    /**
     * @var string Module name.
     */
    public string $name;
    /**
     * @var string Module version.
     */
    public string $version;

    public function __construct() {
        $this->requestTimeMicros = floor(microtime(true) * 1000) * 1000;

        $packageName = InstalledVersions::getRootPackage()["name"] ?? null;
        $this->name = $packageName ?? "DataDome.FP.PHP";

        if ($packageName) {
            $version = InstalledVersions::getVersion($packageName);
            $this->version = $version;
        }
        else {
            $this->version = "1.0.0";
        }
    }
}
