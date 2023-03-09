<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Remittance\Remittance;
use momopsdk\Disbursement\Models\DepositModel;

try {

    /**
     * Construct request object and set desired parameters
     */

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
    $sRemittanceSubKey = '6d69c1bd1f874a6aa548ee8b79f9578f';
    $targetEnvironment = 'sandbox';
    $request = Remittance::transfer(
        $oReqDataObject,
        $sRemittanceSubKey,
        $targetEnvironment,
        $callbackUrl
    );

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}
