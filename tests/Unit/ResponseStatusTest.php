<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use DataDome\FraudSdkSymfony\Models\ResponseStatus;
use PHPUnit\Framework\TestCase;

class ResponseStatusTest extends TestCase
{
    public function testJsonSerialize()
    {
        $okStatus = ResponseStatus::OK;
        $failureStatus = ResponseStatus::Failure;
        $timeoutStatus = ResponseStatus::Timeout;

        $this->assertSame("ok", $okStatus->jsonSerialize());
        $this->assertSame("failure", $failureStatus->jsonSerialize());
        $this->assertSame("timeout", $timeoutStatus->jsonSerialize());
    }
}
