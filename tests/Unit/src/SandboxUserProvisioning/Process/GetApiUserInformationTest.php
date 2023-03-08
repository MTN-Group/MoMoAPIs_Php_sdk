<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Constants\API;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdk\Common\Models\UserDetail;
use momopsdk\SandboxUserProvisioning\Process\GetApiUserDetails;

class GetApiUserInformationTest extends ProcessTestCase
{
    protected function setUp(): void
    {
        $this->constructorArgs = ['qwerty1234', 'fstarw452'];
        $this->requestMethod = 'GET';
        $this->requestUrl = MobileMoney::getBaseUrl() .'/v1_0/apiuser/fstarw452';
        $this->className = GetApiUserDetails::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->mockResponseObject = 'UserDetails.json';
        $this->responseType = UserDetail::class;
    }
}
