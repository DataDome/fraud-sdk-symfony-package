<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use DataDome\FraudSdkSymfony\Models\Address;
use DataDome\FraudSdkSymfony\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testConstructor()
    {
        $user = new User();

        $this->assertSame("", $user->id);
        $this->assertSame("", $user->title);
        $this->assertSame("", $user->firstName);
        $this->assertSame("", $user->lastName);

        // Assert createdAt property is a non-empty string with a valid ISO 8601 format
        $this->assertIsString($user->createdAt);
        $this->assertNotEmpty($user->createdAt);
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-]\d{2}:\d{2}$/', $user->createdAt);

        $this->assertSame("", $user->phone);
        $this->assertSame("", $user->email);
        $this->assertInstanceOf(Address::class, $user->address);
    }
}
