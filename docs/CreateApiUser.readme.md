# Create API user in the sandbox environment

1.	`createUser($aData) creates a API user for using sandbox. It creates a POST request to end point /v1_0/apiuser and creates API user in sandbox environment.`

> `End user will get a referenceId which will be used as the User ID for the API user to be created.`

### Usage/Examples

```php

<?php
include(__DIR__.'/../../autoload.php');

use momopsdk\SandboxUserProvisioning\User;

try {
    $aData = ['providerCallbackHost' => 'string'];

    $obj = new User();

    $aResponse = User::createUser($aData);

    print_r($aResponse);
} catch (Throwable $e) {
    print_r($e);
}

```

### Example Output

```php
momopsdk\SandboxUserProvisioning\Process\CreateApiUser Object
(
    [aReqBody:momopsdk\SandboxUserProvisioning\Process\CreateApiUser:private] => 
    [referenceId:protected] => 99d63033-90ff-4eaa-9343-f7435a2b1f5d
    [callBackUrl:protected] => 
    [retryLimit] => 2
    [retryCount] => 0
    [rawResponse] => 
    [processType:protected] => 2
)

```

