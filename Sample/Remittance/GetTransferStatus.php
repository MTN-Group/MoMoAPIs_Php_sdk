<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Remittance\Remittance;

try {

    $sRefId = 'f47e80b6-9c21-40a1-82d6-a2051505fdb3';

    $request = Remittance::getTransferStatus($sRemittanceSubKey, $targetEnvironment, $sRefId);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}