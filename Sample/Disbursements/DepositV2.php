<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;
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
    $request = DisbursementTransaction::depositV2(
        $oReqDataObject, $sDisbursementSubKey,
        $targetEnvironment, $callbackUrl
    );

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}