# Get API key of the user created in the sandbox environment

1.	`createApiKey($sCollectionSubKey, $sRefId) creates an API key of the user and returns it. It creates a POST request to end point /v1_0/apiuser/{X-Reference-Id}/apikey and returns the API key of the user. The UUID is must be version 4.`

> `End user will get API key as the response.`

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\SandboxUserProvisioning\User;

try {

    $sRefId = 'c34d4077-ea8d-4a50-bf76-dbfd37d8bfb6';

    $request = User::createApiKey($sCollectionSubKey, $sRefId);

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
            [apiKey] => 184f531e0b664be19192db7758b169b6
        )

    [referenceId] => c34d4077-ea8d-4a50-bf76-dbfd37d8bfb6
)

```

