# Get Refund Status

1.	`getRefundStatus($sDisbursementSubKey, $targetEnvironment, $sRefId). This operation is used to get the status of a refund. $sRefId is UUID that was passed in the 'Refund' functionality is used as reference to the request.`

> `End user will get status of the Refund. `

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;

try {

    $sRefId = '645b1efa-b2ce-47e2-8880-2042d670c484';

    $request = DisbursementTransaction::getRefundStatus($sDisbursementSubKey, $targetEnvironment, $sRefId);

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
            [financialTransactionId] => 809394803
            [externalId] => 12wq
            [amount] => 8000
            [currency] => EUR
            [payee] => stdClass Object
                (
                    [partyIdType] => PARTY_CODE
                    [partyId] => 8facf279-081a-429b-bd3f-ef3edb326cb4
                )

            [payerMessage] => Message
            [payeeNote] => None
            [status] => SUCCESSFUL
        )

)




```

