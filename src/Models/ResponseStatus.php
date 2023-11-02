<?php

namespace DataDome\FraudSdkSymfony\Models;

use JsonSerializable;

enum ResponseStatus implements JsonSerializable
{
    case OK;
    case Failure;
    case Timeout;

    public function jsonSerialize(): string {
        return match($this) {
            ResponseStatus::OK => "ok",
            ResponseStatus::Failure => "failure",
            ResponseStatus::Timeout => "timeout",
        };
    }
}
