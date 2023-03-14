<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;

$sCallBackUrl = "http://webhook.site/c84cd23c-062b-49bb-b206-909bc8625207"; // for bc-authorize
$targetEnvironment = 'sandbox';
$sDisbursementSubKey = '3cf29c9c26074669b3ac292e514fba92';

try {

    /**
     * Construct request object and set desired parameters
     */
    $request = DisbursementTransaction::getUserInfoWithConsent($sDisbursementSubKey, $targetEnvironment, $sCallBackUrl);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}
