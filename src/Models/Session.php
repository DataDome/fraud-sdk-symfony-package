<?php

namespace DataDome\FraudSdkSymfony\Models;

/**
 * Names of the form fields in the Session object to be sent to the API.
 */
class Session
{
    /**
     * @var string A unique session identifier from your system.
     */
    public string $id;
    /**
     * @var string Creation date of the session, Format ISO 8601 YYYY-MM-DDThh:mm:ssTZD.
     */
    public string $createdAt;

    public function __construct()
    {
        $this->id = "";
        $this->createdAt = date("c");
    }
}
