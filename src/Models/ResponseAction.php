<?php

namespace DataDome\FraudSdkSymfony\Models;

use JsonSerializable;

enum ResponseAction implements JsonSerializable
{
    case Allow;
    case Deny;

    public static function fromString($input): ResponseAction
    {
        if (strcasecmp($input ?? "", ResponseAction::Deny->jsonSerialize()) == 0) {
            return ResponseAction::Deny;
        }
        return   ResponseAction::Allow;
    }

    public function jsonSerialize(): string {
        return match($this) {
            ResponseAction::Allow => "allow",
            ResponseAction::Deny => "deny",
        };
    }
}
