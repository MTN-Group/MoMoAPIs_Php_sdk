<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Disbursement\DisbursementTransaction;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Common\Process\ValidateAccountHolder;
use momopsdk\Collection\Models\StatusResponse;

class ValidateAccountHolderStatusDisbursementIntegrationTest extends IntegrationTestCase
{
    public static $oReqDataObject;

    protected function getProcessInstanceType()
    {
        return ValidateAccountHolder::class;
    }

    protected function getResponseInstanceType()
    {
        return StatusResponse::class;
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
        $this->request = DisbursementTransaction::validateAccountHolderStatus(
            $accountHolderId,
            $accountHolderIdType,
            $env['disbursement_subscription_key'],
            $env['target_environment']
        );
    }
}
