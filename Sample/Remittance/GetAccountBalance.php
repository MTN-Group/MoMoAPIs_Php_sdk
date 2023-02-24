<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Remittance\Remittance;

try {

    $request = Remittance::getAccountBalance($sRemittanceSubKey, $targetEnvironment);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}