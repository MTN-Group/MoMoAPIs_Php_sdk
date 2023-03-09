<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\BcAuthorize;
use momopsdk\Common\Process\BaseProcess;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdkTest\Unit\src\mocks\MockResponse;



class BcAuthorizeTest extends ProcessTestCase
{
    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $sReqData = "login_hint=ID:msisdn/msisdn&scope=profile&access_type=online";
        $sSubsKey = $env['remittance_subscription_key'];
        $sTargetEnvironmentlter = $env['target_environment'];
        $subType = 'remittance';
        $this->constructorArgs = [
            $sReqData,
            $env['reference_id'],
            $env['momo_api_key'],
            $sSubsKey,
            $sTargetEnvironmentlter,
            $subType
        ];
        $this->requestMethod = 'POST';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/remittance/v1_0/bc-authorize';
        $this->className = BcAuthorize::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->processType = BaseProcess::SYNCHRONOUS_PROCESS;
        $this->mockResponseObject = 'Bcauthorize.json';
        $this->responseType = stdClass::class;
    }
}
