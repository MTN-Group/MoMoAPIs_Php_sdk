# Get the User Info with consent

1.	`getUserInfoWithConsent($sRemittanceSubKey, $targetEnvironment).This operation is used to claim a consent by the account holder for the requested scopes.`
2. `Request data prepared using DepositModel.`

> `End user will get 200 as response on success. `

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Remittance\Remittance;

try {

    $request = Remittance::getUserInfoWithConsent($sRemittanceSubKey, $targetEnvironment);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}

```

### Example Output
`200 OK`

```php




```
