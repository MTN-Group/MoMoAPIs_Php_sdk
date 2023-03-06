<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\ValidateAccountHolder;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Collection\Models\StatusResponse;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdkTest\Unit\src\mocks\MockResponse;



class ValidateAccountHolderStatusDisbursementTest extends ProcessTestCase
{
    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $accountHolderId = '0248888736';
        $accountHolderIdType = 'msisdn';
        $sSubsKey = $env['disbursement_subscription_key'];
        $sTargetEnvironmentlter = $env['target_environment'];
        $sSubType = 'disbursement';
        $this->constructorArgs = [
            $accountHolderId,
            $accountHolderIdType,
            $sSubsKey,
            $sTargetEnvironmentlter,
            $sSubType
        ];
        $this->requestMethod = 'GET';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/disbursement/v1_0/accountholder/msisdn/0248888736/active';
        $this->className = ValidateAccountHolder::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->mockResponseObject = 'ValidateAccountHolderStatus.json';
        $this->responseType = StatusResponse::class;
    }
}
