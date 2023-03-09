<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\Oauth2AccessToken;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Constants\API;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;

class Oauth2TokenCollectionTest extends ProcessTestCase
{
    protected function setUp(): void
    {
        $this->constructorArgs = ['ABCD123', 'EFGH456', 'COLLECTION', 'adfdfds342qwerty', 'qwe123'];
        $this->requestMethod = 'POST';
        $this->requestUrl = MobileMoney::getBaseUrl() .API::COLLECTION_OAUTH2ACCESS_TOKEN;
        $this->className = Oauth2AccessToken::class;
        $this->requestOptions = [
            'Authorization: Basic QUJDRDEyMzpFRkdINDU2',
            'Content-Type: application/x-www-form-urlencoded',
            'Ocp-Apim-Subscription-Key: adfdfds342qwerty',
            'X-Target-Environment: sandbox'
        ];
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->mockResponseObject = 'AccessToken.json';
        $this->responseType = stdClass::class;
    }
}
