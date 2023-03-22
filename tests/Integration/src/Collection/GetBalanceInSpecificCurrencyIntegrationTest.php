<?php

use momopsdk\Collection\Collection;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\GetAccBalance;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Common\Process\GetBalanceInSpecificCurrency;

class GetBalanceInSpecificCurrencyIntegrationTest extends IntegrationTestCase
{
    protected function getProcessInstanceType()
    {
        return GetBalanceInSpecificCurrency::class;
    }

    protected function getResponseInstanceType()
    {
        return GetAccBalance::class;
    }

    protected function getRequestType()
    {
        return BaseProcess::SYNCHRONOUS_PROCESS;
    }

    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $currency = 'EUR';
        $this->request = Collection::getAccountBalanceInSpecificCurrency(
            $env['collection_subscription_key'],
            $env['target_environment'],
            $currency,
        );
    }
}
