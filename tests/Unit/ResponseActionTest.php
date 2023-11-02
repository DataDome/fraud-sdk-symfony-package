<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use DataDome\FraudSdkSymfony\Models\ResponseAction;
use PHPUnit\Framework\TestCase;

class ResponseActionTest extends TestCase
{
    public function testJsonSerialize()
    {
        $allowAction = ResponseAction::Allow;
        $denyAction = ResponseAction::Deny;

        $this->assertSame("allow", $allowAction->jsonSerialize());
        $this->assertSame("deny", $denyAction->jsonSerialize());
    }
}
