<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;

$sRefId = '79396086-73e1-4694-b6a3-54d6d0e7a879';
$targetEnvironment = 'sandbox';
$sDisbursementSubKey = '3cf29c9c26074669b3ac292e514fba92';
try {

    /**
     * Construct request object and set desired parameters
     */
    $request = DisbursementTransaction::getTransferStatus($sDisbursementSubKey, $targetEnvironment, $sRefId);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}
