# Validate the account holder status in the sandbox environment

1. `validateAccountHolderStatus($accountHolderId, $accountHolderIdType, $sCollectionSubKey, $targetEnvironment) create a GET request to end point /v1_0/accountholder/{accountHolderIdType}/{accountHolderId}/active and get statsus of the account holder in the sandbox environment.`

> `End user will get result as 200 OK True if account holder is registered and active, false if the account holder is not active or not found.`

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
    $accountHolderId = '0248888736';
    $accountHolderIdType = 'msisdn';
    $request = Collection::validateAccountHolderStatus($accountHolderId, $accountHolderIdType, $sCollectionSubKey, $targetEnvironment);

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
            [result] => 1
        )

    [httpCode] => 200
)

```
