<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\GetUserInfoWithConsent;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\UserDetail;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdkTest\Unit\src\mocks\MockResponse;



class GetUserInfoWithConsentRemittanceTest extends ProcessTestCase
{
    protected function setUp(): void
    {
        $bcAuthorizeFormData = "login_hint=ID:msisdn/msisdn&scope=profile&access_type=online";
        $Oauth2TokenFormData = "grant_type=urn:openid:params:grant-type:ciba&auth_req_id={auth_req_id}";
        MobileMoney::setBcAuthorizeFormData($bcAuthorizeFormData);
        MobileMoney::setOauth2TokenFormData($Oauth2TokenFormData);
        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $sSubsKey = $env['remittance_subscription_key'];
        $sTargetEnvironmentlter = $env['target_environment'];
        $sSubType = 'remittance';
        $this->constructorArgs = [$sSubsKey, $sTargetEnvironmentlter, $sSubType];
        $this->requestMethod = 'GET';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/remittance/oauth2/v1_0/userinfo';
        $this->className = GetUserInfoWithConsent::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->mockResponseObject = 'GetUserInfoWithConsent.json';
        $this->responseType = UserDetail::class;
    }
}
