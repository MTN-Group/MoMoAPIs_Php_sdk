<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Disbursement\DisbursementTransaction;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Common\Process\GetBalance;
use momopsdk\Common\Models\GetAccBalance;

class GetAccountBalanceDisbursementIntegrationTest extends IntegrationTestCase
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
        $this->request = DisbursementTransaction::getAccountBalance(
            $env['disbursement_subscription_key'],
            $env['target_environment']
        );
    }
}
