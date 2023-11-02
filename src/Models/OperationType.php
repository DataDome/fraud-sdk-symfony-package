<?php

namespace DataDome\FraudSdkSymfony\Models;

use JsonSerializable;

enum OperationType implements JsonSerializable
{
    case Validate;
    case Collect;

    public function jsonSerialize(): string {
        return match($this) {
            OperationType::Validate => "validate",
            OperationType::Collect => "collect",
        };
    }
}
