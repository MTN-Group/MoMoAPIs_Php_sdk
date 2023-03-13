<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\GetAccBalance;
use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\GetBalanceInSpecificCurrency;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;


class GetBalanceInSpecificCurrencyTest extends ProcessTestCase
{
    private $subType = 'collection';

    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $sCurrency = 'EUR';
        $this->constructorArgs = [$env['collection_subscription_key'], $env['target_environment'], $sCurrency, $this->subType];
        $this->requestMethod = 'GET';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/collection/v1_0/account/balance/EUR';
        $this->className = GetBalanceInSpecificCurrency::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->processType = BaseProcess::SYNCHRONOUS_PROCESS;
        $this->mockResponseObject = 'GetAccBalance.json';
        $this->responseType = GetAccBalance::class;
    }
}
