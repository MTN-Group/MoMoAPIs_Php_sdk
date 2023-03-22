<?php

use momopsdk\Collection\Collection;
use momopsdk\Common\Process\BaseProcess;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Common\Process\GetBalance;
use momopsdk\Common\Models\GetAccBalance;

class GetBalanceIntegrationTest extends IntegrationTestCase
{
    protected function getProcessInstanceType()
    {
        return GetBalance::class;
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
        $this->request = Collection::getAccountBalance(
            $env['collection_subscription_key'],
            $env['target_environment']
        );
    }
}
