<?php

namespace DataDome\FraudSdkSymfony\Models;

use JsonSerializable;

enum ActionType implements JsonSerializable
{
    case Login;
    case Registration;
    case Payment;

    public function jsonSerialize(): string
    {
        return match($this) {
            ActionType::Login => "login",
            ActionType::Registration => "registration",
            ActionType::Payment => "payment",
        };
    }
}
