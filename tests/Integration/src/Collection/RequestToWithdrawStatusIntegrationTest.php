<?php

use momopsdk\Collection\Collection;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Collection\Models\StatusResponse;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Collection\Process\RequestToWithdrawStatus;

class RequestToWithdrawStatusIntegrationTest extends IntegrationTestCase
{
    protected function getProcessInstanceType()
    {
        return RequestToWithdrawStatus::class;
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
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $sReferenceId = 'a80dbde9-97c8-4ed5-92db-5e4465feba59';
        $this->request = Collection::requestToWithdrawTransactionStatus(
            $sReferenceId,
            $env['collection_subscription_key'],
            $env['target_environment']
        );
    }
}
