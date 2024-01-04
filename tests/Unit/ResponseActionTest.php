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
    public function testFromString()
    {
        $this->assertEquals("allow", ResponseAction::fromString("Allow")->jsonSerialize());
        $this->assertEquals("allow", ResponseAction::fromString("AlloW")->jsonSerialize());
        $this->assertEquals("deny", ResponseAction::fromString("dENy")->jsonSerialize());
        $this->assertEquals("allow", ResponseAction::fromString("unknown")->jsonSerialize());
    }
}
