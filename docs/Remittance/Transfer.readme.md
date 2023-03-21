# Transfer.

1.	`transfer($oReqDataObject, $sRemittanceSubKey,$targetEnvironment, $callbackUrl) create transfer from own account to payee account.`
2. `Request data prepared using DepositModel.`

> `End user will get 202 as response on success. `

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Remittance\Remittance;
use momopsdk\Common\Models\DepositModel;

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
    $request = Remittance::transfer(
        $oReqDataObject, $sRemittanceSubKey,
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
    [referenceId] => 2ad781e4-97b8-4d27-9694-3d553e4261e3
    [httpCode] => 202
)



```

