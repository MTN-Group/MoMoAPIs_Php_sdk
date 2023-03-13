<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Collection\Collection;

$sCollectionSubKey = 'cf123ce1c20540ff958a8e725468324f';
$targetEnvironment = 'sandbox';

try {

    /**
     * Construct request object and set desired parameters
     */
    $request = Collection::getAccountBalanceInSpecificCurrency($sCollectionSubKey, $targetEnvironment, 'EUR');

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}
