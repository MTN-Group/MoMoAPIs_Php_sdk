<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\GetBalance;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\GetAccBalance;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdkTest\Unit\src\mocks\MockResponse;



class GetBalanceRemittanceTest extends ProcessTestCase
{
    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $sSubsKey = $env['remittance_subscription_key'];
        $sTargetEnvironmentlter = $env['target_environment'];
        $subType = 'remittance';
        $this->constructorArgs = [$sSubsKey, $sTargetEnvironmentlter, $subType];
        $this->requestMethod = 'GET';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/remittance/v1_0/account/balance';
        $this->className = GetBalance::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->processType = BaseProcess::SYNCHRONOUS_PROCESS;
        $this->mockResponseObject = 'Balance.json';
        $this->responseType = GetAccBalance::class;
    }
}
