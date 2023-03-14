# Get the balance of the account

1.	`getAccountBalanceInSpecificCurrency($sDisbursementSubKey, $targetEnvironment, 'EUR') create a GET request to end point /disbursement/v1_0/account/balance/{currency} and return the balance of the account in sanbox environment.Currency parameter passed in GET`

> `End user will get available balance and currency type. `

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;

try {

    $request = DisbursementTransaction::getAccountBalanceInSpecificCurrency($sDisbursementSubKey, $targetEnvironment, 'EUR');
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

)

```