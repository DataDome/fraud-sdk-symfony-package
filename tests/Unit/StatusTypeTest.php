<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use DataDome\FraudSdkSymfony\Models\StatusType;
use PHPUnit\Framework\TestCase;

class StatusTypeTest extends TestCase
{
    public function testJsonSerialize()
    {
        $succeededStatus = StatusType::Succeeded;
        $failedStatus = StatusType::Failed;

        $this->assertSame("succeeded", $succeededStatus->jsonSerialize());
        $this->assertSame("failed", $failedStatus->jsonSerialize());
    }
}
