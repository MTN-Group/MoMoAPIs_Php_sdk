<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Disbursement\DisbursementTransaction;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Common\Process\GetTransferStatus;
use momopsdk\Common\Models\TransferStatusDetail;

class TransferStatusDisbursementIntegrationTest extends IntegrationTestCase
{
    protected function getProcessInstanceType()
    {
        return GetTransferStatus::class;
    }

    protected function getResponseInstanceType()
    {
        return TransferStatusDetail::class;
    }

    protected function getRequestType()
    {
        return BaseProcess::SYNCHRONOUS_PROCESS;
    }

    protected function setUp(): void
    {
        $sRefId = '62e6e29b-4a3d-46e7-92c9-2c25473117cf';
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $this->request = DisbursementTransaction::getTransferStatus(
            $env['disbursement_subscription_key'],
            $env['target_environment'],
            $sRefId
        );
    }
}
