<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use DataDome\FraudSdkSymfony\Models\ActionType;
use DataDome\FraudSdkSymfony\Models\StatusType;
use DataDome\FraudSdkSymfony\Models\RegistrationBody;
use DataDome\FraudSdkSymfony\Models\RegistrationEvent;
use DataDome\FraudSdkSymfony\Models\Session;
use DataDome\FraudSdkSymfony\Models\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;

class RegistrationBodyTest extends TestCase
{
    public function testConstructor()
    {
        // Create mock objects for Session and User
        $sessionMock = $this->createMock(Session::class);
        $userMock = $this->createMock(User::class);

        // Create a mock RegistrationEvent object
        $registrationEventMock = $this->createMock(RegistrationEvent::class);
        $registrationEventMock->session = $sessionMock;
        $registrationEventMock->user = $userMock;
        $registrationEventMock->account = "unittest@datadome.us";
        $registrationEventMock->actionType = ActionType::Registration;
        $registrationEventMock->statusType = StatusType::Succeeded;

        // Create a mock Request object
        $requestMock = $this->createMock(Request::class);
        $requestMock->headers = $this->createMock(HeaderBag::class);
        $requestMock->cookies = new InputBag();

        // Create a RegistrationBody instance
        $registrationBody = new RegistrationBody($requestMock, $registrationEventMock);

        // Assert properties are correctly set
        $this->assertInstanceOf(Session::class, $registrationBody->session);
        $this->assertInstanceOf(User::class, $registrationBody->user);
    }
}
