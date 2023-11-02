<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use DataDome\FraudSdkSymfony\Models\Session;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    public function testConstructor()
    {
        $session = new Session();

        $this->assertSame("", $session->id);
        $this->assertIsString($session->createdAt);
        $this->assertNotEmpty($session->createdAt);

        // Asserting that it matches the ISO 8601 format:
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-]\d{2}:\d{2}$/', $session->createdAt);
    }
}
