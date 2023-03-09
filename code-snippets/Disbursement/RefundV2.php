<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;
use momopsdk\Disbursement\Models\RefundModel;

try {

    $oReqDataObject = new RefundModel();

    /**
     * Construct request object and set desired parameters
     */
    $oReqDataObject
        ->setAmount('2000')
        ->setCurrency('EUR')
        ->setExternalId('12345678')
        ->setPayerMessage('Payer message here')
        ->setPayeeNote('Payee note here')
        ->setReferenceIdToRefund('ce20fe55-fc5c-4a50-8d5a-43a85e67f928');
    $callbackUrl = "http://webhook.site/c84cd23c-062b-49bb-b206-909bc8625207";
    $sDisbursementSubKey = '3cf29c9c26074669b3ac292e514fba92';
    $targetEnvironment = 'sandbox';

    /**
     *Execute the request
     */
    $request = DisbursementTransaction::refundV2(
        $oReqDataObject,
        $sDisbursementSubKey,
        $targetEnvironment,
        $callbackUrl
    );

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}
