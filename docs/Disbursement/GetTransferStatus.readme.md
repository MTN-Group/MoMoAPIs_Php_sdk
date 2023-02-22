# Get Transfer Status

1.	`getTransferStatus($sDisbursementSubKey, $targetEnvironment, $sRefId). This operation is used to get the status of a transfer. $sRefId is UUID that was passed in the 'Transfer' functionality is used as reference to the request.`

> `End user will get status of the Transfer. `

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;

try {

    $sRefId = '61c49589-997d-449f-923b-19f9bcd70b8c';

    $request = DisbursementTransaction::getTransferStatus($sDisbursementSubKey, $targetEnvironment, $sRefId);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}

```

### Example Output
`200 OK`
```php
momopsdk\Disbursement\Models\StatusDetail Object
(
    [result] => stdClass Object
        (
            [amount] => 1000
            [currency] => EUR
            [financialTransactionId] => 868170949
            [externalId] => 12345678
            [payee] => stdClass Object
                (
                    [partyIdType] => MSISDN
                    [partyId] => 0245565634
                )

            [payerMessage] => January Salary
            [payeeNote] => Any thing we want to type.
            [status] => SUCCESSFUL
        )

)

```

