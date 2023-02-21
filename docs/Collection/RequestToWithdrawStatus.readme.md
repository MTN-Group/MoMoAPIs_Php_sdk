# Shows the status of initiated payment request in the sandbox environment

1.	`requestToWithdrawTransactionStatus($referenceId) get the status of transaction withdraw request. It creates a GET request to end point /collection/v1_0/requesttowithdraw/{referenceId} and get the status of the created payment request in the sandbox environment and it requires to pass reference id of transaction withdraw request in the header url to get result. Reference id used when creating the request to withdraw.`

> `End user will get result as 200 OK. Note that a failed request to pay will be returned with this status too. The 'status' of the RequestToPayResult can be used to determine the outcome of the request. The 'reason' field can be used to retrieve a cause in case of failure.`

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
    $referenceId = '06bc2597-5c93-4e37-878e-489dc75b8113';
    $request = Collection::requestToWithdrawTransactionStatus($referenceId);

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
momopsdk\Common\Models\CallbackResponse Object
(
    [result] => {"financialTransactionId":"863997450","externalId":"6353636","amount":"5","currency":"EUR","payer":{"partyIdType":"MSISDN","partyId":"0248888736"},"payerMessage":"Pay for product a","payeeNote":"payer note","status":"SUCCESSFUL"}
    [httpCode] => 200
    [referenceId] => e270a95f-dbdc-4981-b636-3f15ab7eb6fa
    [hydratorStrategies:protected] =>
    [availableCount:protected] =>
)

```