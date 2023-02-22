<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;

try {

    $sRefId = '8e189def-cb60-4500-9544-b9fb8bb9f662';

    $request = DisbursementTransaction::getDepositStatus($sDisbursementSubKey, $targetEnvironment, $sRefId);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}