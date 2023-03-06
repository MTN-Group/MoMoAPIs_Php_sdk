<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Disbursement\Process\GetRefundStatus;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Disbursement\Models\StatusDetail;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdkTest\Unit\src\mocks\MockResponse;



class GetRefundStatusTest extends ProcessTestCase
{
    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $sSubsKey = $env['disbursement_subscription_key'];
        $sTargetEnvironmentlter = $env['target_environment'];
        $sRefId = '195324cf-ece7-4e88-b296-94fc0082271d';
        $sSubType = 'disbursement';
        $this->constructorArgs = [$sSubsKey, $sTargetEnvironmentlter, $sRefId, $sSubType];
        $this->requestMethod = 'GET';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/disbursement/v1_0/refund/195324cf-ece7-4e88-b296-94fc0082271d';
        $this->className = GetRefundStatus::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->mockResponseObject = 'RefundStatus.json';
        $this->responseType = StatusDetail::class;
    }
}
