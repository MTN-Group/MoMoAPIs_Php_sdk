# Get the account balance in the sandbox environment

1. `getAccountBalance(sCollectionSubKey, $targetEnvironment) create a GET request to end point /v1_0/account/balance and get the  balance of the account in the sandbox environment.`

> `End user will get result as 200 OK with account balace and currency details.`

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Collection\Collection;


try {
    /**
     * Construct request object and set desired parameters
     */
     $request = Collection::getAccountBalance($sCollectionSubKey, $targetEnvironment);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (MobileMoneyException $ex) {

    print_r($ex->getMessage());
    print_r($ex->getErrorObj());
}

```
### Example Output

`200 OK`
```php
momopsdk\Collection\Models\StatusResponse Object
(
    [result] => stdClass Object
        (
            [availableBalance] => 1000
            [currency] => EUR
        )

    [httpCode] => 200
)

```