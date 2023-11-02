<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use DataDome\FraudSdkSymfony\Config\DataDomeOptions;
use PHPUnit\Framework\TestCase;

class DataDomeOptionsTest extends TestCase
{
    public function testDefaultConstructor()
    {
        // Arrange & Act
        $dataDomeOptions = new DataDomeOptions("api_key");

        // Assert
        $this->assertEquals(1500, $dataDomeOptions->timeout);
        $this->assertEquals("https://account-api.datadome.co", $dataDomeOptions->endpoint);
        $this->assertEquals("api_key", $dataDomeOptions->fraudApiKey);
        $this->assertEquals("/v1", $dataDomeOptions->endpointVersion);
    }

    public function testCustomTimeout()
    {
        // Arrange & Act
        $dataDomeOptions = new DataDomeOptions("api_key", 2000);

        // Assert
        $this->assertEquals(2000, $dataDomeOptions->timeout);
    }

    public function testCustomEndpoint()
    {
        // Arrange & Act
        $dataDomeOptions = new DataDomeOptions("api_key", null, "https://custom-endpoint.com");

        // Assert
        $this->assertEquals("https://custom-endpoint.com", $dataDomeOptions->endpoint);
    }

    public function testCustomEndpointWithoutProtocol()
    {
        // Arrange & Act
        $dataDomeOptions = new DataDomeOptions("api_key", null, "custom-endpoint.com");

        // Assert
        $this->assertEquals("https://custom-endpoint.com", $dataDomeOptions->endpoint);
    }

    public function testCustomEndpointWithHTTPProtocol()
    {
        // Arrange & Act
        $dataDomeOptions = new DataDomeOptions("api_key", null, "http://custom-endpoint.com");

        // Assert
        $this->assertEquals("http://custom-endpoint.com", $dataDomeOptions->endpoint);
    }

    public function testCustomTimeoutAndEndpoint()
    {
        // Arrange & Act
        $dataDomeOptions = new DataDomeOptions("api_key", 3000, "https://custom-endpoint.com");

        // Assert
        $this->assertEquals(3000, $dataDomeOptions->timeout);
        $this->assertEquals("https://custom-endpoint.com", $dataDomeOptions->endpoint);
    }
}
