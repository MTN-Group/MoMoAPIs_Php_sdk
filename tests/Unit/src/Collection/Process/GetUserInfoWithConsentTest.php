<?php

use momopsdk\Common\Models\UserDetail;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\GetUserInfoWithConsent;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;

class GetUserInfoWithConsentTest extends ProcessTestCase
{

    protected function setUp(): void
    {
        $bcAuthorizeFormData = "login_hint=ID:msisdn/msisdn&scope=profile&access_type=online";
        $Oauth2TokenFormData = "grant_type=urn:openid:params:grant-type:ciba&auth_req_id={auth_req_id}";
        MobileMoney::setBcAuthorizeFormData($bcAuthorizeFormData);
        MobileMoney::setOauth2TokenFormData($Oauth2TokenFormData);
        $subType = 'collection';
        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $callbackUrl = "https://webhook.site/";
        $this->constructorArgs = [$env['collection_subscription_key'], $env['target_environment'], $subType, $callbackUrl];
        $this->requestMethod = 'GET';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/collection/oauth2/v1_0/userinfo';
        $this->className = GetUserInfoWithConsent::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->processType = BaseProcess::SYNCHRONOUS_PROCESS;
        $this->mockResponseObject = 'BasicUserInfo.json';
        $this->responseType = UserDetail::class;
    }
}
