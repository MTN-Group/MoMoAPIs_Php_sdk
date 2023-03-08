# Create API user in the sandbox environment

1.	`createUser($aData, $sCollectionSubKey) creates a API user for using sandbox. It creates a POST request to end point /v1_0/apiuser and creates API user in sandbox environment.`

> `End user will get a referenceId which will be used as the User ID for the API user to be created.`

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\SandboxUserProvisioning\User;

try {
    $aData = ['providerCallbackHost' => 'www.example.com'];

    $request = User::createUser($aData, $sCollectionSubKey);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}

```

### Example Output
`200 OK`
```php
momopsdk\Common\Models\ResponseState Object
(
    [result] => 
    [referenceId] => 29c8f1ec-b41b-4c5b-a8cf-633a1da0a782
    [httpCode] => 201
)


```

