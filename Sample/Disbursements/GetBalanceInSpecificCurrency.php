<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;

try {

    $request = DisbursementTransaction::getAccountBalanceInSpecificCurrency($sDisbursementSubKey, $targetEnvironment, 'EUR');
    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}
