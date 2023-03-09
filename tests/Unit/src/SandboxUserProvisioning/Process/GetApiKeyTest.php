<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Constants\API;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdk\Common\Models\UserDetail;
use momopsdk\SandboxUserProvisioning\Process\GetApiKey;

class GetApiKeyTest extends ProcessTestCase
{
    protected function setUp(): void
    {
        $this->constructorArgs = ['subkey123', 'qwerty1234'];
        $this->requestMethod = 'POST';
        $this->requestUrl = MobileMoney::getBaseUrl() .'/v1_0/apiuser/qwerty1234/apikey';
        $this->className = GetApiKey::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->mockResponseObject = 'GetApiKey.json';
        $this->responseType = UserDetail::class;
    }
}
