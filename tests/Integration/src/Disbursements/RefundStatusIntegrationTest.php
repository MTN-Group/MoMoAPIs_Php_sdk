<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Disbursement\DisbursementTransaction;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Disbursement\Process\GetRefundStatus;
use momopsdk\Disbursement\Models\StatusDetail;

class RefundStatusIntegrationTest extends IntegrationTestCase
{
    protected function getProcessInstanceType()
    {
        return GetRefundStatus::class;
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
        $sRefId = '195324cf-ece7-4e88-b296-94fc0082271d';
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $this->request = DisbursementTransaction::getRefundStatus(
            $env['disbursement_subscription_key'],
            $env['target_environment'],
            $sRefId
        );
    }
}
