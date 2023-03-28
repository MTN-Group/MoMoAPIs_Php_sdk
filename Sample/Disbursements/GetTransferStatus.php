<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;

try {

    $sRefId = '62e6e29b-4a3d-46e7-92c9-2c25473117cf';

    $request = DisbursementTransaction::getTransferStatus($sDisbursementSubKey, $targetEnvironment, $sRefId);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}