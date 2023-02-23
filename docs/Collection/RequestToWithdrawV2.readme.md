# Create a request for withdrawel for consumer in the sandbox environment

1.	`requestToWithdrawV2($transaction, $sCollectionSubKey, $targetEnvironment) create a withdrawel request for the consumer. It creates a POST request to end point v2_0/requesttowithdraw and initiate a withdrawel request in the sandbox environment.`

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

    /**
     * Create a transaction object and set the parameters
     */
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
    $sCallbackUrl = "https://webhook.site/37b4b85e-8c15-4fe5-9076-b7de3071b85d";
    $sContentType = "application/json";
    $request = Collection::requestToWithdrawV2($transaction, $sCollectionSubKey, $targetEnvironment, $sCallbackUrl, $sContentType);

    /**
     * Choose notification method can be either Callback or Polling
     */
    $request->setNotificationMethod(NotificationMethod::POLLING);

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
momopsdk\Collection\Models\RequestToPayResponse Object
(
    [httpCode] => 202
    [referenceId] => 7e8be910-0294-443c-920a-b58988124541
)

```