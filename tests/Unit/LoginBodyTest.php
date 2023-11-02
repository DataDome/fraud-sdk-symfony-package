<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use DataDome\FraudSdkSymfony\Models\Header;
use DataDome\FraudSdkSymfony\Models\LoginBody;
use DataDome\FraudSdkSymfony\Models\LoginEvent;
use DataDome\FraudSdkSymfony\Models\StatusType;
use DataDome\FraudSdkSymfony\Models\Module;
use DataDome\FraudSdkSymfony\Tests\Unit\Mocks\MockRequest;
use PHPUnit\Framework\TestCase;

class LoginBodyTest extends TestCase
{
    public function testConstructorSetsPropertiesCorrectly()
    {
        // Create mock objects for Request, LoginEvent, and LoginStatus
        $requestMock = MockRequest::getValidMockRequest();

        $account = "unittest@datadome.us";
        $loginEventMock = new LoginEvent($account);

        // Mock enum value
        $loginStatusEnumValue = StatusType::Succeeded;

        // Create a LoginBody object
        $loginBody = new LoginBody($requestMock, $loginEventMock, $loginStatusEnumValue);

        // Assert that the properties are set correctly
        $this->assertSame($loginStatusEnumValue->jsonSerialize(), $loginBody->status);
        $this->assertSame($loginEventMock->account, $loginBody->account);
        $this->assertSame($loginEventMock->actionType->jsonSerialize(), $loginBody->event);
        $this->assertInstanceOf(Header::class, $loginBody->header);
        $this->assertInstanceOf(Module::class, $loginBody->module);
    }
}
