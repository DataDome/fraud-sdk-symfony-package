<?php

namespace DataDome\FraudSdkSymfony\Models;

class DataDomeResponseError extends DataDomeResponse
{
    public string $message;
    public array $errors;

    public function __construct(string $input, ResponseStatus $status, string $message = "")
    {
        $this->action = ResponseAction::Allow;
        $this->status = $status;
        $parsed_response = json_decode($input);
        $this->message = $parsed_response?->message ?? $message;
        $this->errors = is_array($parsed_response?->errors) ? $parsed_response->errors : [];
        
        // No need to call parent constructor here
    }
}
