<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;

try {

    $sRefId = '61c49589-997d-449f-923b-19f9bcd70b8c';

    $request = DisbursementTransaction::getTransferStatus($sDisbursementSubKey, $targetEnvironment, $sRefId);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}