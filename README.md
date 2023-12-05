# DataDome Fraud Protection - PHP Symfony integration

Module for supporting DataDome Fraud Protection in Symfony PHP applications.

## Installation

This package can be installed through composer by running the following command:

```
composer require datadome/fraud-sdk-symfony
```

Then proceed to run the below command to generate an autoloader containing the main class and options:

```
composer dump-autoload
```

## Usage

Update the .env files with your preferred configuration. 
Please note that the `DATADOME_FRAUD_API_KEY` is mandatory, while the other two settings are optional.

```
DATADOME_FRAUD_API_KEY=my-datadome-client-side-sdk-key
DATADOME_TIMEOUT=1500
DATADOME_ENDPOINT='https://account-api.datadome.co'
```

To make use of the DataDome SDK in your controller, first add the required imports:

```php
use DataDome\FraudSdkSymfony\Config\DataDomeOptions;
use DataDome\FraudSdkSymfony\DataDome;
use DataDome\FraudSdkSymfony\Models\Address;
use DataDome\FraudSdkSymfony\Models\LoginEvent;
use DataDome\FraudSdkSymfony\Models\StatusType;
use DataDome\FraudSdkSymfony\Models\RegistrationEvent;
use DataDome\FraudSdkSymfony\Models\Session;
use DataDome\FraudSdkSymfony\Models\User;
use DataDome\FraudSdkSymfony\Models\ResponseAction;
```

Then proceed to create a private DataDome object as follows:

```php
$key = $_ENV['DATADOME_FRAUD_API_KEY'];
$timeout = $_ENV['DATADOME_TIMEOUT'];
$endpoint = $_ENV['DATADOME_ENDPOINT'];

$options = new DataDomeOptions($key, $timeout, $endpoint);
$this->dataDome = new DataDome($options);
```

Finally, invoke the validate and collect methods as required:

```php
if ($this->validateLogin("account_guid_to_check")) {
    $loginEvent = new LoginEvent("account_guid_to_check", StatusType::Succeeded);
    $loginResponse = $this->dataDome->validate($request, $loginEvent);

    if ($loginResponse != null && $loginResponse->action == ResponseAction::Allow->jsonSerialize()) {
        // Valid login attempt
        return new JsonResponse([true]);
    } else {
        // Business Logic here
        // MFA
        // Challenge
        // Notification email
        // Temporarily lock account
        return new JsonResponse(["Login denied"]);
    }
}
else {
    $loginEvent = new LoginEvent("account_guid_to_check", StatusType::Failed);
    $this->dataDome->collect($request, $loginEvent);
}
```
