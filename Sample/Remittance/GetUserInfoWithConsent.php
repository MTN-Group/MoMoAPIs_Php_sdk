<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Remittance\Remittance;
use momopsdk\Common\Constants\MobileMoney;

try {

    $bcAuthorizeFormData = "login_hint=ID:msisdn/msisdn&scope=profile&access_type=online";
    $Oauth2TokenFormData = "grant_type=urn:openid:params:grant-type:ciba&auth_req_id={auth_req_id}";
    MobileMoney::setBcAuthorizeFormData($bcAuthorizeFormData);
    MobileMoney::setOauth2TokenFormData($Oauth2TokenFormData);
    $request = Remittance::getUserInfoWithConsent($sRemittanceSubKey, $targetEnvironment);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}