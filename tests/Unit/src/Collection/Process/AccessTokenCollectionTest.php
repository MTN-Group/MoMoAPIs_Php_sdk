<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\AccessToken;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Constants\API;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;

class AccessTokenCollectionTest extends ProcessTestCase
{
    protected function setUp(): void
    {
        $this->constructorArgs = ['ABCD123', 'EFGH456', 'COLLECTION', 'adfdfds342qwerty'];
        $this->requestMethod = 'POST';
        $this->requestUrl = MobileMoney::getBaseUrl() .API::COLLECTION_ACCESS_TOKEN;
        $this->className = AccessToken::class;
        $this->requestOptions = [
            'Authorization: Basic QUJDRDEyMzpFRkdINDU2',
            'Content-Type: application/json',
            'Ocp-Apim-Subscription-Key: adfdfds342qwerty'
        ];
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->mockResponseObject = 'AccessToken.json';
        $this->responseType = stdClass::class;
    }
}
