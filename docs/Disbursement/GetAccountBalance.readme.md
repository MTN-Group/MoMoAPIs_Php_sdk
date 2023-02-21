# Get Account Balance

1.	`getAccountBalance($sDisbursementSubKey, $targetEnvironment) Gets the balance of the account`

> `End user will get available balance and currency type. `

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;

try {

    $request = DisbursementTransaction::getAccountBalance($sDisbursementSubKey, $targetEnvironment);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}

```

### Example Output
`200 OK`
```php
momopsdk\Disbursement\Models\GetAccBalance Object
(
    [result] => stdClass Object
        (
            [availableBalance] => 0
            [currency] => EUR
        )

)

```

