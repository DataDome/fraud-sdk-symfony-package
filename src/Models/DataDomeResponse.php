<?php

namespace DataDome\FraudSdkSymfony\Models;

class DataDomeResponse
{
    public ResponseAction $action;
    public ResponseStatus $status;
    public array $reasons;
    public string $ip;
    public Address $location;

    public function __construct()
    {
        $this->reasons = [];
        $this->location = new Address();
    }
}
