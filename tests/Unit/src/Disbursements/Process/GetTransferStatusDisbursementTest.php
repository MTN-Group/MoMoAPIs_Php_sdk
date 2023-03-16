<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\GetTransferStatus;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\TransferStatusDetail;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdkTest\Unit\src\mocks\MockResponse;



class GetTransferStatusDisbursementTest extends ProcessTestCase
{
    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $sSubsKey = $env['disbursement_subscription_key'];
        $sTargetEnvironmentlter = $env['target_environment'];
        $sRefId = '79396086-73e1-4694-b6a3-54d6d0e7a879';
        $sSubType = 'disbursement';
        $this->constructorArgs = [$sSubsKey, $sTargetEnvironmentlter, $sRefId, $sSubType];
        $this->requestMethod = 'GET';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/disbursement/v1_0/transfer/79396086-73e1-4694-b6a3-54d6d0e7a879';
        $this->className = GetTransferStatus::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->mockResponseObject = 'TransferStatus.json';
        $this->responseType = TransferStatusDetail::class;
    }
}
