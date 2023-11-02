<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use DataDome\FraudSdkSymfony\Models\ActionType;
use DataDome\FraudSdkSymfony\Models\DataDomeEvent;
use DataDome\FraudSdkSymfony\Models\StatusType;
use DataDome\FraudSdkSymfony\Models\RegistrationEvent;
use DataDome\FraudSdkSymfony\Models\Session;
use DataDome\FraudSdkSymfony\Models\User;
use PHPUnit\Framework\TestCase;

class RegistrationEventTest extends TestCase
{
    public function testConstructor()
    {
        $account = "unittest@datadome.us";
        $loginStatus = StatusType::Succeeded;
        $session = new Session();
        $user = new User();

        $registrationEvent = new RegistrationEvent($account, $loginStatus, $session, $user);

        $this->assertInstanceOf(DataDomeEvent::class, $registrationEvent);
        $this->assertInstanceOf(ActionType::class, $registrationEvent->actionType);
        $this->assertInstanceOf(StatusType::class, $registrationEvent->statusType);
        $this->assertInstanceOf(Session::class, $registrationEvent->session);
        $this->assertInstanceOf(User::class, $registrationEvent->user);
        $this->assertSame($account, $registrationEvent->account);
        $this->assertSame(ActionType::Registration, $registrationEvent->actionType);
        $this->assertSame($loginStatus, $registrationEvent->statusType);
    }
}
