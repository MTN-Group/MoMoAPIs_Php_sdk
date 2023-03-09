<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\ValidateAccountHolder;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Collection\Models\StatusResponse;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;

class ValidateAccountHolderTest extends ProcessTestCase
{
    private $subType = 'collection';

    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $accountHolderId = '0248888736';
        $accountHolderIdType = 'msisdn';
        $this->constructorArgs = [$accountHolderId, $accountHolderIdType, $env['collection_subscription_key'], $env['target_environment'], $this->subType];
        $this->requestMethod = 'GET';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/collection/v1_0/accountholder/msisdn/0248888736/active';
        $this->className = ValidateAccountHolder::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->processType = BaseProcess::SYNCHRONOUS_PROCESS;
        $this->mockResponseObject = 'StatusResponse.json';
        $this->responseType = StatusResponse::class;
    }
}
