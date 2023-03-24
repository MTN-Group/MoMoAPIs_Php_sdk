# Get Deposit Status

1.	`getDepositStatus($sDisbursementSubKey, $targetEnvironment, $sRefId). This operation is used to get the status of a deposit. sRefId is the UUID which uses in the Deposit functionalities.`

> `End user will get status of the deposit. `

2. `$sRefId is the reference id of the Deposit transaction.`

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;

try {

    $sRefId = '648e6758-2da6-48eb-aeb3-565e58c7c4b1';

    $request = DisbursementTransaction::getDepositStatus($sDisbursementSubKey, $targetEnvironment, $sRefId);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}

```

### Example Output
`200 OK`
```php
momopsdk\Common\Models\StatusDetail Object
(
    [result] => stdClass Object
        (
            [externalId] => 15234353
            [amount] => 1000
            [currency] => EUR
            [payee] => stdClass Object
                (
                    [partyIdType] => MSISDN
                    [partyId] => 0245565634
                )

            [payerMessage] => June Salary
            [payeeNote] => Any thing we want to type.
            [status] => SUCCESSFUL
        )

)


```

