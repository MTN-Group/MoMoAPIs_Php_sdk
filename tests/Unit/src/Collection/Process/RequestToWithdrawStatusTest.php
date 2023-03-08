<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Collection\Models\StatusResponse;
use momopsdk\Collection\Process\RequestToWithdrawStatus;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;

class RequestToWithdrawStatusTest extends ProcessTestCase
{

    protected function setUp(): void
    {

        $referenceId = '97e71c50-a105-48ff-9efa-9347101ee2e1';
        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $this->constructorArgs = [$referenceId, $env['collection_subscription_key'], $env['target_environment']];
        $this->requestMethod = 'GET';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/collection/v1_0/requesttowithdraw/97e71c50-a105-48ff-9efa-9347101ee2e1';
        $this->className = RequestToWithdrawStatus::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->processType = BaseProcess::SYNCHRONOUS_PROCESS;
        $this->mockResponseObject = 'StatusResponse.json';
        $this->responseType = StatusResponse::class;
    }
}
