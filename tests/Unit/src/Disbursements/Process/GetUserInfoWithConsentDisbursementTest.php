<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\GetUserInfoWithConsent;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\UserDetail;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdkTest\Unit\src\mocks\MockResponse;



class GetUserInfoWithConsentDisbursementTest extends ProcessTestCase
{
    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $sSubsKey = $env['disbursement_subscription_key'];
        $sTargetEnvironmentlter = $env['target_environment'];
        $sSubType = 'disbursement';
        $this->constructorArgs = [$sSubsKey, $sTargetEnvironmentlter, $sSubType];
        $this->requestMethod = 'GET';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/disbursement/oauth2/v1_0/userinfo';
        $this->className = GetUserInfoWithConsent::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->mockResponseObject = 'GetUserInfoWithConsent.json';
        $this->responseType = UserDetail::class;
    }
}
