<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Collection\Process\RetrieveRequestToPay;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdk\Collection\Models\RequestToPayStatusResponse;

class RequestToPayStatusTest extends ProcessTestCase
{

    protected function setUp(): void
    {

        $referenceId = '9ffb31ab-a7bc-494d-8ab0-76589c773719';
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $this->constructorArgs = [$referenceId, $env['collection_subscription_key'], $env['target_environment']];
        $this->requestMethod = 'GET';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/collection/v1_0/requesttopay/9ffb31ab-a7bc-494d-8ab0-76589c773719';
        $this->className = RetrieveRequestToPay::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->processType = BaseProcess::SYNCHRONOUS_PROCESS;
        $this->mockResponseObject = 'RequestToPayStatusResponse.json';
        $this->responseType = RequestToPayStatusResponse::class;
    }
}
