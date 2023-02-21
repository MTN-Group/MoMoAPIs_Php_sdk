# Create a request for withdrawel for consumer in the sandbox environment

1.	`requestToWithdrawV1($transaction, $callBackUrl = null) create a withdrawel request for the consumer. It creates a POST request to end point v1_0/requesttowithdraw and initiate a withdrawel request in the sandbox environment.`

> `End user will get result as 202 Accepted if the request to withdraw is sucessful.`

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Enums\NotificationMethod;
use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Collection\Collection;
use momopsdk\Collection\Models\Transaction;

try {

    $transaction = new Transaction();
    $transaction->setAmount("100");
    $transaction->setCurrency("EUR");
    $transaction->setExternalId("6253728");
    $payer = [
        'partyIdType' => 'MSISDN',
        'partyId' => '0248888736'
    ];
    $transaction->setPayer($payer);
    $transaction->setPartyId("MSISDN");
    $transaction->setPartyIdType("0248888736");
    $transaction->setPayerMessage("Paying for product a");
    $transaction->setPayeeNote("Payer note");

    /**
     * Construct request object and set desired parameters
     */

    $request = Collection::requestToWithdrawV1($transaction);

    /**
     * Choose notification method can be either Callback or Polling
     */
    $request->setNotificationMethod(NotificationMethod::CALLBACK);

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
`202 Accepted`
```php
momopsdk\Common\Models\CallbackResponse Object
(
    [result] =>
    [httpCode] => 202
    [referenceId] => dda52501-3493-4189-b11c-286284c86fda
    [hydratorStrategies:protected] =>
    [availableCount:protected] =>
)

```
