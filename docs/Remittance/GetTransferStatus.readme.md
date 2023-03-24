# Get Transfer Status

1.	`getTransferStatus($sRemittanceSubKey, $targetEnvironment, $sRefId). This operation is used to get the status of a transfer. $sRefId is UUID that was passed in the 'Transfer' functionality is used as reference to the request.`

> `End user will get status of the Transfer. `

2. `$sRefId is the reference id of the Transfer transaction.`

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Remittance\Remittance;

try {

    $sRefId = 'd25214ef-587e-423a-a49b-9c2c21ff0cbc';

    $request = Remittance::getTransferStatus($sRemittanceSubKey, $targetEnvironment, $sRefId);

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
            [amount] => 2000
            [currency] => EUR
            [financialTransactionId] => 324662314
            [externalId] => 12345678
            [payee] => stdClass Object
                (
                    [partyIdType] => MSISDN
                    [partyId] => 222222
                )

            [payerMessage] => Payer message here
            [payeeNote] => Payee note here
            [status] => SUCCESSFUL
        )

    [httpCode] => 200
)


```

