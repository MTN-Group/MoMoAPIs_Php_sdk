<?php

use momopsdk\Common\Process\GetBasicUserInfo;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Collection\Models\StatusResponse;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;

class GetBasicUserInfoTest extends ProcessTestCase
{

    private $subType = 'collection';
    private $sAccountHolderMSISDN = '0248888736';

    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $this->constructorArgs = [$this->sAccountHolderMSISDN, $env['collection_subscription_key'], $env['target_environment'], $this->subType];
        $this->requestMethod = 'GET';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/collection/v1_0/accountholder/msisdn/0248888736/basicuserinfo';
        $this->className = GetBasicUserInfo::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->processType = BaseProcess::SYNCHRONOUS_PROCESS;
        $this->mockResponseObject = 'BasicUserInfo.json';
        $this->responseType = StatusResponse::class;
    }
}
