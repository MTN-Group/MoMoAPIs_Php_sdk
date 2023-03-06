<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;

try {

    $sCallBackUrl = "http://webhook.site/c84cd23c-062b-49bb-b206-909bc8625207"; // for bc-authorize
    $request = DisbursementTransaction::getUserInfoWithConsent($sDisbursementSubKey, $targetEnvironment, $sCallBackUrl);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}