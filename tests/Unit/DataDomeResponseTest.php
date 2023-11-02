<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use DataDome\FraudSdkSymfony\Models\Address;
use DataDome\FraudSdkSymfony\Models\DataDomeResponse;
use DataDome\FraudSdkSymfony\Models\ResponseAction;
use DataDome\FraudSdkSymfony\Models\ResponseStatus;
use PHPUnit\Framework\TestCase;

class DataDomeResponseTest extends TestCase
{
    public function testConstructorAndDefaultValues()
    {
        $mockIp = "192.167.1.1";

        $dataDomeResponse = new DataDomeResponse();
        $dataDomeResponse->action = ResponseAction::Allow;
        $dataDomeResponse->status = ResponseStatus::OK;
        $dataDomeResponse->ip = $mockIp;

        $this->assertInstanceOf(ResponseAction::class, $dataDomeResponse->action);
        $this->assertInstanceOf(ResponseStatus::class, $dataDomeResponse->status);
        $this->assertIsArray($dataDomeResponse->reasons);
        $this->assertSame([], $dataDomeResponse->reasons);
        $this->assertIsString($dataDomeResponse->ip);
        $this->assertSame($mockIp, $dataDomeResponse->ip);
        $this->assertInstanceOf(Address::class, $dataDomeResponse->location);
    }
}
