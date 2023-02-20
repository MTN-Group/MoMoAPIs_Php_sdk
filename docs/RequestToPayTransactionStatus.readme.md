# Shows the status of initiated payment request in the sandbox environment

1.	`requestToPayTransactionStatus($transaction) create a payment request for the user. It creates a GET request to end point /v1_0/requesttopay/{referenceId} and get the status of the created payment request in the sandbox environment and it requires to pass reference id of transaction in the header url to get result. Reference id used when creating the request to pay..`

> `End user will get result as 200 OK with the created payment request details.`

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Collection\Collection;

try {

    $transaction = new Transaction();
    $request = Collection::requestToPayTransactionStatus($transaction);
    $request->setNotificationMethod(NotificationMethod::POLLING);
    $response = $request->execute();

} catch (MobileMoneyException $ex) {

    print_r($ex->getMessage());
    print_r($ex->getErrorObj());

}

```
### Example Output
`200 OK`
```php
momopsdk\Common\Models\CallbackResponse Object
(
    [result] => {"financialTransactionId":"863997450","externalId":"6353636","amount":"5","currency":"EUR","payer":{"partyIdType":"MSISDN","partyId":"0248888736"},"payerMessage":"Pay for product a","payeeNote":"payer note","status":"SUCCESSFUL"}
    [httpCode] => 200
    [referenceId] => e270a95f-dbdc-4981-b636-3f15ab7eb6fa
    [hydratorStrategies:protected] =>
    [availableCount:protected] =>
)

```