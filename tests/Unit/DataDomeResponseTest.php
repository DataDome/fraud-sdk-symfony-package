<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use DataDome\FraudSdkSymfony\Models\Address;
use DataDome\FraudSdkSymfony\Models\DataDomeResponse;
use DataDome\FraudSdkSymfony\Models\ResponseAction;
use DataDome\FraudSdkSymfony\Models\ResponseStatus;
use PHPUnit\Framework\TestCase;

class DataDomeResponseTest extends TestCase
{
    public function testConstructorAndDefaultValues()
    {
        $mockIp = "192.167.1.1";

        $dataDomeResponse = new DataDomeResponse();
        $dataDomeResponse->ip = $mockIp;

        $this->assertInstanceOf(ResponseAction::class, $dataDomeResponse->action);
        $this->assertInstanceOf(ResponseStatus::class, $dataDomeResponse->status);
        $this->assertSame(ResponseAction::Allow, $dataDomeResponse->action);
        $this->assertSame(ResponseStatus::Failure, $dataDomeResponse->status);


        $this->assertIsString($dataDomeResponse->ip);
        $this->assertSame($mockIp, $dataDomeResponse->ip);
    }
    public function testValidAllowResponse()
    {
        $mockIp = "192.167.1.1";
        $input = '{"action":"allow","reasons":[],"ip":"92.4.12.58","score":0,"location":{"countryCode":"GB","country":"United Kingdom","city":"Erith"},"eventId":"01977d30-589f-7560-98e4-debd5affad2a"}';

        $dataDomeResponse = new DataDomeResponse($input);
        $dataDomeResponse->ip = $mockIp;

        $this->assertInstanceOf(ResponseAction::class, $dataDomeResponse->action);
        $this->assertInstanceOf(ResponseStatus::class, $dataDomeResponse->status);
        $this->assertSame(ResponseAction::Allow, $dataDomeResponse->action);
        $this->assertSame(ResponseStatus::OK, $dataDomeResponse->status);

        $this->assertIsArray($dataDomeResponse->reasons);
        $this->assertSame([], $dataDomeResponse->reasons);

        $this->assertIsString($dataDomeResponse->ip);
        $this->assertSame($mockIp, $dataDomeResponse->ip);

        $this->assertInstanceOf(Address::class, $dataDomeResponse->location);
        $this->assertSame("GB", $dataDomeResponse->location->countryCode);
        $this->assertSame("United Kingdom", $dataDomeResponse->location->country);
        $this->assertSame("Erith", $dataDomeResponse->location->city);
        $this->assertEquals(0, $dataDomeResponse->score);
        $this->assertSame("01977d30-589f-7560-98e4-debd5affad2a", $dataDomeResponse->eventId);
    }
    public function testValidDenyResponse()
    {
        $mockIp = "192.167.1.1";
        $input = '{"action":"deny","reasons":["brute_force"],"ip":"92.4.12.58","score":10,"location":{"countryCode":"GB","country":"United Kingdom","city":"Erith"},"eventId":"01977d30-589f-7560-98e4-debd5affad2b"}';

        $dataDomeResponse = new DataDomeResponse($input);
        $dataDomeResponse->ip = $mockIp;

        $this->assertInstanceOf(ResponseAction::class, $dataDomeResponse->action);
        $this->assertInstanceOf(ResponseStatus::class, $dataDomeResponse->status);
        $this->assertSame(ResponseAction::Deny, $dataDomeResponse->action);
        $this->assertSame(ResponseStatus::OK, $dataDomeResponse->status);

        $this->assertIsArray($dataDomeResponse->reasons);
        $this->assertEquals(1, sizeof($dataDomeResponse->reasons));
        $this->assertEquals("brute_force", $dataDomeResponse->reasons[0]);

        $this->assertIsString($dataDomeResponse->ip);
        $this->assertSame($mockIp, $dataDomeResponse->ip);

        $this->assertInstanceOf(Address::class, $dataDomeResponse->location);
        $this->assertSame("GB", $dataDomeResponse->location->countryCode);
        $this->assertSame("United Kingdom", $dataDomeResponse->location->country);
        $this->assertSame("Erith", $dataDomeResponse->location->city);


        $this->assertIsString($dataDomeResponse->ip);
        $this->assertSame($mockIp, $dataDomeResponse->ip);
        $this->assertEquals(10, $dataDomeResponse->score);
        $this->assertSame("01977d30-589f-7560-98e4-debd5affad2b", $dataDomeResponse->eventId);
    }

    public function testIncorrectResponse()
    {
        $mockIp = "192.167.1.1";
        $input = '{"reasons":["brute_force"],"ip":"92.4.12.58","score":15,"location":{"countryCode":"GB","country":"United Kingdom","city":"Erith"},"eventId": "01977d30-589f-7560-98e4-debd5affad2c"}'; //action is missing

        $dataDomeResponse = new DataDomeResponse($input);
        $dataDomeResponse->ip = $mockIp;

        $this->assertInstanceOf(ResponseAction::class, $dataDomeResponse->action);
        $this->assertInstanceOf(ResponseStatus::class, $dataDomeResponse->status);
        $this->assertSame(ResponseAction::Allow, $dataDomeResponse->action);
        $this->assertSame(ResponseStatus::Failure, $dataDomeResponse->status);

        $this->assertIsArray($dataDomeResponse->reasons);
        $this->assertEquals(1, sizeof($dataDomeResponse->reasons));
        $this->assertEquals("brute_force", $dataDomeResponse->reasons[0]);

        $this->assertIsString($dataDomeResponse->ip);
        $this->assertSame($mockIp, $dataDomeResponse->ip);

        $this->assertInstanceOf(Address::class, $dataDomeResponse->location);
        $this->assertSame("GB", $dataDomeResponse->location->countryCode);
        $this->assertSame("United Kingdom", $dataDomeResponse->location->country);
        $this->assertSame("Erith", $dataDomeResponse->location->city);


        $this->assertIsString($dataDomeResponse->ip);
        $this->assertSame($mockIp, $dataDomeResponse->ip);
        $this->assertEquals(15, $dataDomeResponse->score);
        $this->assertSame("01977d30-589f-7560-98e4-debd5affad2c", $dataDomeResponse->eventId);
    }
    public function testInvalidJsonResponse()
    {
        $mockIp = "192.167.1.1";
        $input = '{"reasons":["brute_force"],"ip":"92.4.12.58","location":{}'; // this json is invalid and can not be decoded

        $dataDomeResponse = new DataDomeResponse($input);
        $dataDomeResponse->ip = $mockIp;

        print_r($dataDomeResponse);

        $this->assertInstanceOf(ResponseAction::class, $dataDomeResponse->action);
        $this->assertInstanceOf(ResponseStatus::class, $dataDomeResponse->status);
        $this->assertSame(ResponseAction::Allow, $dataDomeResponse->action);
        $this->assertSame(ResponseStatus::Failure, $dataDomeResponse->status);
    }
    
    public function testInvalidJsonTypesResponse()
    {
        $mockIp = "192.167.1.1";
        $input = '{"action":"deny", "reasons":"brute_force","ip":"92.4.12.58","location": "city", "score":2, "eventId":"abcd"}'; // reasons should be an array

        $dataDomeResponse = new DataDomeResponse($input);
        $dataDomeResponse->ip = $mockIp;

        $this->assertInstanceOf(ResponseAction::class, $dataDomeResponse->action);
        $this->assertInstanceOf(ResponseStatus::class, $dataDomeResponse->status);
        $this->assertEquals(ResponseAction::Deny, $dataDomeResponse->action);
        $this->assertEquals(ResponseStatus::OK, $dataDomeResponse->status);
        $this->assertSame($mockIp, $dataDomeResponse->ip);
        $this->assertEquals(2, $dataDomeResponse->score);
        $this->assertSame("abcd", $dataDomeResponse->eventId);
    }
}
