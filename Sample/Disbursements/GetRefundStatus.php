<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;

try {

    $sRefId = '547bd2f0-daf0-4038-b079-29b03c57e9da';

    $request = DisbursementTransaction::getRefundStatus($sDisbursementSubKey, $targetEnvironment, $sRefId);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}