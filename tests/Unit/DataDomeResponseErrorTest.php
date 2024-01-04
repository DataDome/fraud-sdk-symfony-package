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

        $dataDomeResponseError = new DataDomeResponseError("", ResponseStatus::Timeout);
        $dataDomeResponseError->ip = $mockIp;

        $this->assertInstanceOf(ResponseAction::class, $dataDomeResponseError->action);
        $this->assertInstanceOf(ResponseStatus::class, $dataDomeResponseError->status);
        $this->assertEquals(ResponseAction::Allow, $dataDomeResponseError->action);
        $this->assertEquals(ResponseStatus::Timeout, $dataDomeResponseError->status);
        $this->assertIsString($dataDomeResponseError->ip);
        $this->assertSame($mockIp, $dataDomeResponseError->ip);
        $this->assertIsString($dataDomeResponseError->message);
        $this->assertSame("", $dataDomeResponseError->message);
        $this->assertIsArray($dataDomeResponseError->errors);
        $this->assertSame([], $dataDomeResponseError->errors);
    }
    public function testErrorMessage()
    {
        $mockIp = "192.167.1.1";
        $input = '{"message":"Parsing error","errors":[{"field":"email","error":"must be a valid email address"}]}';
        $dataDomeResponseError = new DataDomeResponseError($input, ResponseStatus::Failure);
        $dataDomeResponseError->action = ResponseAction::Deny;
        $dataDomeResponseError->ip = $mockIp;

        $this->assertInstanceOf(ResponseAction::class, $dataDomeResponseError->action);
        $this->assertInstanceOf(ResponseStatus::class, $dataDomeResponseError->status);
        $this->assertEquals(ResponseAction::Deny, $dataDomeResponseError->action);
        $this->assertEquals(ResponseStatus::Failure, $dataDomeResponseError->status);
        $this->assertIsString($dataDomeResponseError->ip);
        $this->assertSame($mockIp, $dataDomeResponseError->ip);
        $this->assertIsString($dataDomeResponseError->message);
        $this->assertSame("Parsing error", $dataDomeResponseError->message);
        $this->assertIsArray($dataDomeResponseError->errors);
        $this->assertSame(1, sizeof($dataDomeResponseError->errors));
        $this->assertSame("email", $dataDomeResponseError->errors[0]->field);
        $this->assertSame("must be a valid email address", $dataDomeResponseError->errors[0]->error);
    }
    public function testInvalidJsonTypeMessage()
    {
        $mockIp = "192.167.1.1";
        $input = '{"message":"Parsing error","errors":"must be a valid email address"}'; // errors should be an array
        $dataDomeResponseError = new DataDomeResponseError($input, ResponseStatus::Failure);
        $dataDomeResponseError->ip = $mockIp;

        $this->assertInstanceOf(ResponseAction::class, $dataDomeResponseError->action);
        $this->assertInstanceOf(ResponseStatus::class, $dataDomeResponseError->status);
        $this->assertEquals(ResponseAction::Allow, $dataDomeResponseError->action);
        $this->assertEquals(ResponseStatus::Failure, $dataDomeResponseError->status);
        $this->assertIsString($dataDomeResponseError->ip);
        $this->assertSame($mockIp, $dataDomeResponseError->ip);
        $this->assertIsString($dataDomeResponseError->message);
        $this->assertSame("Parsing error", $dataDomeResponseError->message);
        $this->assertIsArray($dataDomeResponseError->errors);
        $this->assertEquals(0, sizeof($dataDomeResponseError->errors));
    }
}
