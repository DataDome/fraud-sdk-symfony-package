<?php

namespace DataDome\FraudSdkSymfony\Models;

use JsonSerializable;

enum ResponseAction implements JsonSerializable
{
    case Allow;
    case Deny;

    public function jsonSerialize(): string {
        return match($this) {
            ResponseAction::Allow => "allow",
            ResponseAction::Deny => "deny",
        };
    }
}
