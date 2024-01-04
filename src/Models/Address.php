<?php

namespace DataDome\FraudSdkSymfony\Models;

/**
 * Names of the form fields in the Address object to be sent to the API.
 */
class Address
{
    /**
     * @var string Name of the address.
     */
    public string $name = "";
    public string $line1 = "";
    public string $line2 = "";
    public string $city = "";
    /**
     * @var string Country code, Format ISO-3166-1-alpha-2.
     */
    public string $countryCode = "";
    public string $country = "";
    public string $regionCode = "";
    public string $zipCode = "";
}
