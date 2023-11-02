<?php

namespace DataDome\FraudSdkSymfony\Models;

/**
 * Names of the form fields in the User object to be sent to the API.
 */
class User
{
    /**
     * @var string A unique customer identifier from your system. It has to be the same for all other event sent.
     */
    public string $id = "";
    /**
     * @var string Title of the user.
     */
    public string $title = "";
    /**
     * @var string First name of the user.
     */
    public string $firstName = "";
    /**
     * @var string Last name of the user.
     */
    public string $lastName = "";
    /**
     * @var string Creation date of the user, Format ISO 8601 YYYY-MM-DDThh:mm:ssTZD.
     */
    public string $createdAt;
    /**
     * @var string Phone of the user, E.164 format including + and a region code, for example +33978787878.
     */
    public string $phone = "";
    /**
     * @var string Email of the user.
     */
    public string $email = "";
    /**
     * @var Address Address of the user.
     */
    public Address $address;

    public function __construct()
    {
        $this->createdAt = date("c");
        $this->address = new Address();
    }
}
