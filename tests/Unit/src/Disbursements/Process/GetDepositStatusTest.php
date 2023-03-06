<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Disbursement\Process\GetDepositStatus;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Disbursement\Models\StatusDetail;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdkTest\Unit\src\mocks\MockResponse;



class GetDepositStatusTest extends ProcessTestCase
{
    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $sSubsKey = $env['disbursement_subscription_key'];
        $sTargetEnvironmentlter = $env['target_environment'];
        $sRefId = '8e189def-cb60-4500-9544-b9fb8bb9f662';
        $sSubType = 'disbursement';
        $this->constructorArgs = [$sSubsKey, $sTargetEnvironmentlter, $sRefId, $sSubType];
        $this->requestMethod = 'GET';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/disbursement/v1_0/deposit/8e189def-cb60-4500-9544-b9fb8bb9f662';
        $this->className = GetDepositStatus::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->mockResponseObject = 'DepositStatus.json';
        $this->responseType = StatusDetail::class;
    }
}
