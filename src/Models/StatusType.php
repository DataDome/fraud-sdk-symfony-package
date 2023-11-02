<?php

namespace DataDome\FraudSdkSymfony\Models;

use JsonSerializable;

/**
 * Status of the request.
 */
enum StatusType implements JsonSerializable
{
    case Succeeded;
    case Failed;
    case Undefined;

    public function jsonSerialize(): string {
        return match($this) {
            StatusType::Succeeded => "succeeded",
            StatusType::Failed => "failed",
            StatusType::Undefined => "undefined"
        };
    }
}
