<?php

use momopsdk\Collection\Collection;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\CommonStatusResponse;
use momopsdk\Common\Process\ValidateAccountHolder;
use momopsdkTest\Integration\src\IntegrationTestCase;

class ValidateAccountHolderStatusIntegrationTest extends IntegrationTestCase
{
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
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $accountHolderId = '0248888736';
        $accountHolderIdType = 'msisdn';
        $this->request = Collection::validateAccountHolderStatus(
            $accountHolderId,
            $accountHolderIdType,
            $env['collection_subscription_key'],
            $env['target_environment']
        );
    }
}
