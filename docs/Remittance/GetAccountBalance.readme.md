# Get Account Balance

1.	`getAccountBalance($sRemittanceSubKey, $targetEnvironment) Gets the balance of the account`

> `End user will get available balance and currency type. `

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Remittance\Remittance;

try {

    $request = Remittance::getAccountBalance($sRemittanceSubKey, $targetEnvironment);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}

```

### Example Output
`200 OK`
```php
momopsdk\Common\Models\GetAccBalance Object
(
    [result] => stdClass Object
        (
            [availableBalance] => 0
            [currency] => EUR
        )

    [httpCode] => 200
)


```

