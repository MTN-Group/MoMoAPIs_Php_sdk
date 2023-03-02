<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\GetBalance;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Disbursement\Models\GetAccBalance;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdkTest\Unit\src\mocks\MockResponse;

class GetBalanceTest extends ProcessTestCase
{

    private $sSubsKey = 'cf123ce1c20540ff958a8e725468324f';

    private $sTargetEnvironmentlter = 'sandbox';

    private $subType = 'collection';

    protected function setUp(): void
    {
        $this->constructorArgs = [$this->sSubsKey, $this->sTargetEnvironmentlter, $this->subType];
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
