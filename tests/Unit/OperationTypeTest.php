<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use DataDome\FraudSdkSymfony\Models\OperationType;
use PHPUnit\Framework\TestCase;

class OperationTypeTest extends TestCase
{
    public function testJsonSerialize()
    {
        $validateOperation = OperationType::Validate;
        $collectOperation = OperationType::Collect;

        $this->assertSame("validate", $validateOperation->jsonSerialize());
        $this->assertSame("collect", $collectOperation->jsonSerialize());
    }
}
