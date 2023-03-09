<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Constants\API;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdk\Common\Models\ResponseState;
use momopsdk\SandboxUserProvisioning\Process\CreateApiUser;

class CreateApiUserTest extends ProcessTestCase
{
    protected function setUp(): void
    {
        $this->constructorArgs = [['body'], 'qwerty1234'];
        $this->requestMethod = 'POST';
        $this->requestUrl = MobileMoney::getBaseUrl() .'/v1_0/apiuser';
        $this->className = CreateApiUser::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->processType = BaseProcess::ASYNCHRONOUS_PROCESS;
        $this->mockResponseObject = 'CreateUser.json';
        $this->responseType = ResponseState::class;
    }
}
