<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;

$sRefId = '195324cf-ece7-4e88-b296-94fc0082271d';
$targetEnvironment = 'sandbox';
$sDisbursementSubKey = '3cf29c9c26074669b3ac292e514fba92';

try {

    /**
     * Construct request object and set desired parameters
     */
    $request = DisbursementTransaction::getRefundStatus($sDisbursementSubKey, $targetEnvironment, $sRefId);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}
