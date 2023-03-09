<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\GetBalanceInSpecificCurrency;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\GetAccBalance;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdkTest\Unit\src\mocks\MockResponse;



class GetAccountBalanceInCurrencyDisbursementTest extends ProcessTestCase
{
    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $sSubsKey = $env['disbursement_subscription_key'];
        $sTargetEnvironmentlter = $env['target_environment'];
        $sCurrency = 'EUR';
        $sSubType = 'disbursement';
        $this->constructorArgs = [$sSubsKey, $sTargetEnvironmentlter, $sCurrency, $sSubType];
        $this->requestMethod = 'GET';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/disbursement/v1_0/account/balance/EUR';
        $this->className = GetBalanceInSpecificCurrency::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->mockResponseObject = 'AccountBalanceInSpecificCurrency.json';
        $this->responseType = GetAccBalance::class;
    }
}
