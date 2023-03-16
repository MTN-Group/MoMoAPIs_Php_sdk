<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Disbursement\DisbursementTransaction;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Disbursement\Process\GetDepositStatus;
use momopsdk\Disbursement\Models\StatusDetail;

class DepositStatusIntegrationTest extends IntegrationTestCase
{
    protected function getProcessInstanceType()
    {
        return GetDepositStatus::class;
    }

    protected function getResponseInstanceType()
    {
        return StatusDetail::class;
    }

    protected function getRequestType()
    {
        return BaseProcess::SYNCHRONOUS_PROCESS;
    }

    protected function setUp(): void
    {
        $sRefId = '8e189def-cb60-4500-9544-b9fb8bb9f662';
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $this->request = DisbursementTransaction::getDepositStatus(
            $env['disbursement_subscription_key'],
            $env['target_environment'],
            $sRefId
        );
    }
}
