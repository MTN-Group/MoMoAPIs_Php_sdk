# Get the User Info with consent

1.	`getUserInfoWithConsent($sCollectionSubKey, $targetEnvironment).This operation is used to claim a consent by the account holder for the requested scopes.`
2. `Request data prepared using DepositModel.`

> `End user will get 200 as response on success. `

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Collection\Collection;

try {

    $request = Collection::getUserInfoWithConsent($sCollectionSubKey, $targetEnvironment);

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
            [sub] => 0
            [name] => Sand Box
            [given_name] => Sand
            [family_name] => Box
            [birthdate] => 1976-08-13
            [locale] => sv_SE
            [gender] => MALE
            [updated_at] => 1677557317
        )

    [httpCode] => 200
)




```

