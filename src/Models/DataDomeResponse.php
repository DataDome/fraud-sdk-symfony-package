<?php

namespace DataDome\FraudSdkSymfony\Models;

class DataDomeResponse
{
    public ResponseAction $action;
    public ResponseStatus $status;
    public array $reasons;
    public string $ip;
    public Address $location;
    public int $score;
    public string $eventId;

    public function __construct(string $input = "")
    {
        $parsed_response = json_decode($input); // json_decode returns null if the json can not be decoded
        if (empty($parsed_response)) {
            $this->status = ResponseStatus::Failure;
            $this->action = ResponseAction::Allow;
        } else {
            $this->status = property_exists($parsed_response, "action") ? ResponseStatus::OK : ResponseStatus::Failure;
            $this->action = ResponseAction::fromString($parsed_response->action ?? null);
            $this->ip = $parsed_response->ip ?? "";
            if (!empty($parsed_response->location)) {
                $address = new Address();
                $address->line1 = $parsed_response->location->line1 ?? "";
                $address->line2 = $parsed_response->location->line2 ?? "";
                $address->city = $parsed_response->location->city ?? "";
                $address->countryCode = $parsed_response->location->countryCode ?? "";
                $address->country = $parsed_response->location->country ?? "";
                $address->regionCode = $parsed_response->location->regionCode ?? "";
                $address->zipCode = $parsed_response->location->zipCode ?? "";
                $this->location = $address;
            }
            $this->reasons = is_array($parsed_response->reasons) ? $parsed_response->reasons : [];
            $this->eventId = $parsed_response->eventId ?? "";
            $this->score = $parsed_response->score ?? 0;
        }
    }
}
