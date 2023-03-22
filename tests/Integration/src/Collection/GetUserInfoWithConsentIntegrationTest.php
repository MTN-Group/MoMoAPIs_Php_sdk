<?php

use momopsdk\Collection\Collection;
use momopsdk\Common\Models\UserDetail;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\GetUserInfoWithConsent;
use momopsdkTest\Integration\src\IntegrationTestCase;

class GetUserInfoWithConsentIntegrationTest extends IntegrationTestCase
{
    protected function getProcessInstanceType()
    {
        return GetUserInfoWithConsent::class;
    }

    protected function getResponseInstanceType()
    {
        return UserDetail::class;
    }

    protected function getRequestType()
    {
        return BaseProcess::SYNCHRONOUS_PROCESS;
    }

    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $bcAuthorizeFormData = "login_hint=ID:msisdn/msisdn&scope=profile&access_type=online";
        $Oauth2TokenFormData = "grant_type=urn:openid:params:grant-type:ciba&auth_req_id={auth_req_id}";
        MobileMoney::setBcAuthorizeFormData($bcAuthorizeFormData);
        MobileMoney::setOauth2TokenFormData($Oauth2TokenFormData);
        $this->request = Collection::getUserInfoWithConsent(
            $env['collection_subscription_key'],
            $env['target_environment']
        );
    }
}
