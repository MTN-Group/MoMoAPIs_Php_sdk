# Displays API user created in the sandbox environment

1.	`getUserDetails($sCollectionSubKey, $sRefId) gets the details of the API user created in sandbox. It creates a GET request to end point v1_0/apiuser/{X-Reference-Id} and returns the details of the api user created.`

> `End user will get result as the details of the user created.`

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\SandboxUserProvisioning\User;

try {

    $sRefId = 'c34d4077-ea8d-4a50-bf76-dbfd37d8bfb6';

    $request = User::getUserDetails($sCollectionSubKey, $sRefId);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}

```

### Example Output
`200 OK`
```php
momopsdk\Common\Models\UserDetail Object
(
    [result] => stdClass Object
        (
            [providerCallbackHost] => www.example.com
            [targetEnvironment] => sandbox
        )

    [referenceId] => d0091568-0e09-4d1f-b682-a22d0a7e3b52
    [httpCode] => 200
)


```

