# Shows the status of initiated payment request in the sandbox environment

1.	`requestToPayTransactionStatus($transaction, $referenceId, $sCollectionSubKey, $targetEnvironment) creates a GET request to end point /v1_0/requesttopay/{referenceId} and get the status of the created payment request in the sandbox environment, and it requires X-Reference-Id that was passed in the post method of request to pay is used as reference to the request..`

> `End user will get result as 200 OK with the created payment request details.`

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Collection\Collection;

try {

    $transaction = new Transaction();
    $request = Collection::requestToPayTransactionStatus($referenceId, $sCollectionSubKey, $targetEnvironment);
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
momopsdk\Collection\Models\RequestToPayStatusResponse Object
(
    [result] => stdClass Object
        (
            [financialTransactionId] => 1530828708
            [externalId] => 6253728
            [amount] => 100
            [currency] => EUR
            [payer] => stdClass Object
                (
                    [partyIdType] => MSISDN
                    [partyId] => 0248888736
                )

            [payerMessage] => Paying for product a
            [payeeNote] => Payer note
            [status] => SUCCESSFUL
        )

    [httpCode] =>
    [referenceId] => a52d1a60-b777-4c0f-a3b1-9957cf74b25e
)

```