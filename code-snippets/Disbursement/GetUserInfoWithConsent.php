<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Disbursement\DisbursementTransaction;
use momopsdk\Common\Constants\MobileMoney;

$sCallBackUrl = "http://webhook.site/c84cd23c-062b-49bb-b206-909bc8625207"; // for bc-authorize
$targetEnvironment = 'sandbox';
$sDisbursementSubKey = '3cf29c9c26074669b3ac292e514fba92';

try {
    $bcAuthorizeFormData = "login_hint=ID:msisdn/msisdn&scope=profile&access_type=online";
    $Oauth2TokenFormData = "grant_type=urn:openid:params:grant-type:ciba&auth_req_id={auth_req_id}";
    MobileMoney::setBcAuthorizeFormData($bcAuthorizeFormData);
    MobileMoney::setOauth2TokenFormData($Oauth2TokenFormData);
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
