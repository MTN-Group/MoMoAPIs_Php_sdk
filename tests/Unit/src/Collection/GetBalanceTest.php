<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\GetBalance;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Disbursement\Models\GetAccBalance;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;


class GetBalanceTest extends ProcessTestCase
{
    private $subType = 'collection';

    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $this->constructorArgs = [$env['collection_subscription_key'], $env['target_environment'], $this->subType];
        $this->requestMethod = 'GET';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/collection/v1_0/account/balance';
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
