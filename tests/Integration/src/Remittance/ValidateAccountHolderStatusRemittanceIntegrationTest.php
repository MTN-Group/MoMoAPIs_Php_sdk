<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Remittance\Remittance;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Common\Process\ValidateAccountHolder;
use momopsdk\Common\Models\CommonStatusResponse;

class ValidateAccountHolderStatusRemittanceIntegrationTest extends IntegrationTestCase
{
    public static $oReqDataObject;

    protected function getProcessInstanceType()
    {
        return ValidateAccountHolder::class;
    }

    protected function getResponseInstanceType()
    {
        return CommonStatusResponse::class;
    }

    protected function getRequestType()
    {
        return BaseProcess::SYNCHRONOUS_PROCESS;
    }

    protected function setUp(): void
    {
        $accountHolderId = '0248888736';
        $accountHolderIdType = 'msisdn';
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $this->request = Remittance::validateAccountHolderStatus(
            $accountHolderId,
            $accountHolderIdType,
            $env['remittance_subscription_key'],
            $env['target_environment']
        );
    }
}
