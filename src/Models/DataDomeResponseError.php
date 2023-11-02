<?php

namespace DataDome\FraudSdkSymfony\Models;

class DataDomeResponseError extends DataDomeResponse
{
    public string $message;
    public array $errors;

    public function __construct()
    {
        $this->message = "";
        $this->errors = [];

        parent::__construct();
    }
}
