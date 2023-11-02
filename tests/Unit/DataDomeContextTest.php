<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use DataDome\FraudSdkSymfony\Config\DataDomeOptions;
use DataDome\FraudSdkSymfony\Context\DataDomeContext;
use DataDome\FraudSdkSymfony\Models\ActionType;
use DataDome\FraudSdkSymfony\Models\DataDomeResponse;
use DataDome\FraudSdkSymfony\Models\DataDomeResponseError;
use DataDome\FraudSdkSymfony\Models\LoginEvent;
use DataDome\FraudSdkSymfony\Models\StatusType;
use DataDome\FraudSdkSymfony\Models\OperationType;
use DataDome\FraudSdkSymfony\Models\RegistrationEvent;
use DataDome\FraudSdkSymfony\Models\ResponseAction;
use DataDome\FraudSdkSymfony\Models\ResponseStatus;
use DataDome\FraudSdkSymfony\Models\Session;
use DataDome\FraudSdkSymfony\Models\User;
use ErrorException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class DataDomeContextTest extends TestCase
{
    public function testRequestDataDomeAPILoginValidate()
    {
        // Arrange
        $dataDomeOptions = new DataDomeOptions("key", null, null);
        $dataDomeContext = new DataDomeContext($dataDomeOptions);

        $operationType = OperationType::Validate;
        $request = new Request();
        $account = "unittest@datadome.us";
        $loginEvent = new LoginEvent($account);

        // Act
        $result = $dataDomeContext->requestDataDomeAPI($operationType, $request, $loginEvent);

        // Assert
        $this->assertInstanceOf(DataDomeResponse::class, $result);
        $this->assertEquals(ResponseStatus::Failure, $result->status);
        $this->assertEquals(ResponseAction::Allow, $result->action);
    }

    public function testRequestDataDomeAPIRegistrationCollect()
    {
        // Arrange
        $dataDomeOptions = new DataDomeOptions("key", null, null);
        $dataDomeContext = new DataDomeContext($dataDomeOptions);

        // Create mock objects for Session and User
        $sessionMock = $this->createMock(Session::class);
        $userMock = $this->createMock(User::class);

        $operationType = OperationType::Collect;
        $request = new Request();
        $account = "unittest@datadome.us";
        $event = new RegistrationEvent($account, StatusType::Succeeded, $sessionMock, $userMock);

        // Act
        $result = $dataDomeContext->requestDataDomeAPI($operationType, $request, $event);

        // Assert
        $this->assertInstanceOf(DataDomeResponse::class, $result);
        $this->assertEquals(ResponseStatus::Failure, $result->status);
    }

    public function testRequestDataDomeAPIInvalidEvent()
    {
        // Arrange
        $dataDomeOptions = new DataDomeOptions("key", null, null);
        $dataDomeContext = new DataDomeContext($dataDomeOptions);

        $operationType = OperationType::Validate;
        $request = new Request();

        $account = "unittest@datadome.us";
        $loginEvent = new LoginEvent($account);
        $loginEvent->actionType = ActionType::Payment;

        // Act & Assert
        $this->expectException(ErrorException::class);
        $dataDomeContext->requestDataDomeAPI($operationType, $request, $loginEvent);
    }

    public function testRequestDataDomeAPIHttpException()
    {
        // Arrange
        $dataDomeOptions = new DataDomeOptions("key", 1500, null);
        $dataDomeContext = new DataDomeContext($dataDomeOptions);

        $operationType = OperationType::Validate;
        $request = new Request();
        $account = "unittest@datadome.us";
        $loginEvent = new LoginEvent($account);

        // Act
        $result = $dataDomeContext->requestDataDomeAPI($operationType, $request, $loginEvent);

        // Assert
        $this->assertInstanceOf(DataDomeResponseError::class, $result);
        $this->assertEquals(ResponseStatus::Failure, $result->status);
    }
}
