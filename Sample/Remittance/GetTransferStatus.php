<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Remittance\Remittance;

try {

    $sRefId = 'd25214ef-587e-423a-a49b-9c2c21ff0cbc';

    $request = Remittance::getTransferStatus($sRemittanceSubKey, $targetEnvironment, $sRefId);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}