# Create Refund v2.

1.	`transfer($oReqDataObject, $sDisbursementSubKey,$targetEnvironment, $callbackUrl) create transfer from own account to payee account.`
2. `Request data prepared using DepositModel.`

> `End user will get 202 as response on success. `

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;
use momopsdk\Disbursement\Models\DepositModel;

try {
    $payee = [
        'partyIdType' => 'MSISDN',
        'partyId' => '222222'
    ];

    $oReqDataObject = new DepositModel();

    $oReqDataObject
                ->setAmount('2000')
                ->setCurrency('EUR')
                ->setExternalId('12345678')
                ->setPayerMessage('Payer message here')
                ->setPayeeNote('Payee note here')
                ->setPayee($payee);
    $callbackUrl = "http://webhook.site/c84cd23c-062b-49bb-b206-909bc8625207";
    $request = DisbursementTransaction::transfer(
        $oReqDataObject, $sDisbursementSubKey,
        $targetEnvironment, $callbackUrl
    );

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}

```

### Example Output
`202 ACCEPTED`
```php
momopsdk\Disbursement\Models\ResponseModel Object
(
    [result] => 
    [referenceId] => fbc064cb-853c-4462-8c34-dccbc249ece7
    [httpCode] => 202
)


```

