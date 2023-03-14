<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;

$sDisbursementSubKey = '3cf29c9c26074669b3ac292e514fba92';
$targetEnvironment = 'sandbox';

try {
    /**
     * Construct request object and set desired parameters
     */
    $request = DisbursementTransaction::getAccountBalance($sDisbursementSubKey, $targetEnvironment);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}
