<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Remittance\Remittance;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Common\Process\GetTransferStatus;
use momopsdk\Common\Models\TransferStatusDetail;

class TransferStatusRemittanceIntegrationTest extends IntegrationTestCase
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
        $sRefId = 'd25214ef-587e-423a-a49b-9c2c21ff0cbc';
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $this->request = Remittance::getTransferStatus(
            $env['remittance_subscription_key'],
            $env['target_environment'],
            $sRefId
        );
    }
}
