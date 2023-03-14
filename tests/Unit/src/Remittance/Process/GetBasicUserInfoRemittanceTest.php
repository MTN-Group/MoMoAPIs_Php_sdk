<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\GetBasicUserInfo;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\UserDetail;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdkTest\Unit\src\mocks\MockResponse;



class GetBasicUserInfoRemittanceTest extends ProcessTestCase
{
    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $sSubsKey = $env['remittance_subscription_key'];
        $sTargetEnvironmentlter = $env['target_environment'];
        $sAccountHolderMSISDN = '0248888736';
        $sSubType = 'remittance';
        $this->constructorArgs = [$sAccountHolderMSISDN, $sSubsKey, $sTargetEnvironmentlter, $sSubType];
        $this->requestMethod = 'GET';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/remittance/v1_0/accountholder/msisdn/0248888736/basicuserinfo';
        $this->className = GetBasicUserInfo::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->mockResponseObject = 'BasicUserInfo.json';
        $this->responseType = UserDetail::class;
    }
}
