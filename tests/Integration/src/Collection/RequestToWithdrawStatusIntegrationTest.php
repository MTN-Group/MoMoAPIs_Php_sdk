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
        $sReferenceId = 'ccf50462-e8e8-4f98-84a8-03007bc93f18';
        $this->request = Collection::requestToWithdrawTransactionStatus(
            $sReferenceId,
            $env['collection_subscription_key'],
            $env['target_environment']
        );
    }
}
