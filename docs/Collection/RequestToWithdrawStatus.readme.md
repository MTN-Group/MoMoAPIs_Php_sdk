# Shows the status of a request to withdraw in the sandbox environment

1.	`requestToWithdrawTransactionStatus($referenceId, $sCollectionSubKey, $targetEnvironment) creates a GET request to end point /collection/v1_0/requesttowithdraw/{referenceId} and get the status of the created payment request in the sandbox environment and it requires to pass reference id of transaction withdraw request in the header url to get result. Reference id used when creating the request to withdraw.`

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
    $request = Collection::requestToWithdrawTransactionStatus($referenceId, $sCollectionSubKey, $targetEnvironment);

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
            [financialTransactionId] => 1742984081
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

    [httpCode] => 200
    [referenceId] => 09d6bd7d-a253-4ae4-be43-5b2e9277f90a
)

```