# Initiate a payment request in the sandbox environment

1.	`requestToPay($transaction) create a payment request for the user. It creates a POST request to end point /v1_0/requesttopay and initiate a payment request in the sandbox environment.`

> `End user will get result as 202 Accepted if the request to payment is sucessful.`

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Collection\Collection;

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
    $request = Collection::requestToPay($transaction);
    $request->setNotificationMethod(NotificationMethod::POLLING);
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
    [httpCode] => 202
    [referenceId] => c1f51313-247f-4431-b3c2-aef3567e4794
    [hydratorStrategies:protected] =>
    [availableCount:protected] =>
)

```