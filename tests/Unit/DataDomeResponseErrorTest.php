<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use DataDome\FraudSdkSymfony\Models\Address;
use DataDome\FraudSdkSymfony\Models\DataDomeResponseError;
use DataDome\FraudSdkSymfony\Models\ResponseAction;
use DataDome\FraudSdkSymfony\Models\ResponseStatus;
use PHPUnit\Framework\TestCase;

class DataDomeResponseErrorTest extends TestCase
{
    public function testConstructorAndDefaultValues()
    {
        $mockIp = "192.167.1.1";

        $dataDomeResponseError = new DataDomeResponseError();
        $dataDomeResponseError->action = ResponseAction::Deny;
        $dataDomeResponseError->status = ResponseStatus::Failure;
        $dataDomeResponseError->ip = $mockIp;

        $this->assertInstanceOf(ResponseAction::class, $dataDomeResponseError->action);
        $this->assertInstanceOf(ResponseStatus::class, $dataDomeResponseError->status);
        $this->assertIsArray($dataDomeResponseError->reasons);
        $this->assertSame([], $dataDomeResponseError->reasons);
        $this->assertIsString($dataDomeResponseError->ip);
        $this->assertSame($mockIp, $dataDomeResponseError->ip);
        $this->assertInstanceOf(Address::class, $dataDomeResponseError->location);
        $this->assertIsString($dataDomeResponseError->message);
        $this->assertSame("", $dataDomeResponseError->message);
        $this->assertIsArray($dataDomeResponseError->errors);
        $this->assertSame([], $dataDomeResponseError->errors);
    }
}
