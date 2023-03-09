<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Remittance\Remittance;

try {

    /**
     * Construct request object and set desired parameters
     */
    $sRemittanceSubKey = '6d69c1bd1f874a6aa548ee8b79f9578f';
    $targetEnvironment = 'sandbox';
    $request = Remittance::getUserInfoWithConsent($sRemittanceSubKey, $targetEnvironment);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}
