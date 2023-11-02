<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use DataDome\FraudSdkSymfony\Models\ActionType;
use PHPUnit\Framework\TestCase;

class ActionTypeTest extends TestCase
{
    public function testJsonSerialize()
    {
        $loginActionType = ActionType::Login;
        $registrationActionType = ActionType::Registration;
        $paymentActionType = ActionType::Payment;

        $this->assertSame("login", $loginActionType->jsonSerialize());
        $this->assertSame("registration", $registrationActionType->jsonSerialize());
        $this->assertSame("payment", $paymentActionType->jsonSerialize());
    }
}
