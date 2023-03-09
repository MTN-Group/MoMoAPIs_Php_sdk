<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;

$sDisbursementSubKey = '3cf29c9c26074669b3ac292e514fba92';
$targetEnvironment = 'sandbox';
$sRefId = '8e189def-cb60-4500-9544-b9fb8bb9f662';

try {
    /**
     * Construct request object and set desired parameters
     */
    $request = DisbursementTransaction::getDepositStatus($sDisbursementSubKey, $targetEnvironment, $sRefId);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}
