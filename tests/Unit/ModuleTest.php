<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DataDome\FraudSdkSymfony\Models\Module;

class ModuleTest extends TestCase
{
    public function testModuleConstructor()
    {
        $packageName = "datadome/fraud-sdk-symfony";

        $module = new Module();

        $this->assertIsFloat($module->requestTimeMicros);
        $this->assertSame($packageName, $module->name);
    }
}
