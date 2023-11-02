<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use DataDome\FraudSdkSymfony\Models\ActionType;
use DataDome\FraudSdkSymfony\Models\DataDomeEvent;
use DataDome\FraudSdkSymfony\Models\LoginEvent;
use DataDome\FraudSdkSymfony\Models\StatusType;
use PHPUnit\Framework\TestCase;

class LoginEventTest extends TestCase
{
    public function testConstructorWithDefaultLoginStatus()
    {
        $account = "unittest@datadome.us";

        $loginEvent = new LoginEvent($account);

        $this->assertInstanceOf(DataDomeEvent::class, $loginEvent);
        $this->assertInstanceOf(ActionType::class, $loginEvent->actionType);
        $this->assertInstanceOf(StatusType::class, $loginEvent->statusType);
        $this->assertSame($account, $loginEvent->account);
        $this->assertSame(ActionType::Login, $loginEvent->actionType);
        $this->assertSame(StatusType::Succeeded, $loginEvent->statusType);
    }

    public function testConstructorWithCustomLoginStatus()
    {
        $account = "unittest@datadome.us";
        $customLoginStatus = StatusType::Failed;

        $loginEvent = new LoginEvent($account, $customLoginStatus);

        $this->assertInstanceOf(DataDomeEvent::class, $loginEvent);
        $this->assertInstanceOf(ActionType::class, $loginEvent->actionType);
        $this->assertInstanceOf(StatusType::class, $loginEvent->statusType);
        $this->assertSame($account, $loginEvent->account);
        $this->assertSame(ActionType::Login, $loginEvent->actionType);
        $this->assertSame(StatusType::Failed, $loginEvent->statusType);
    }
}
