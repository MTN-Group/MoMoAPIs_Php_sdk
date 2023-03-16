<?php

use momopsdk\Collection\Collection;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Collection\Process\RetrieveRequestToPay;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Collection\Models\RequestToPayStatusResponse;

class RetrieveRequestToPayIntegrationTest extends IntegrationTestCase
{
    protected function getProcessInstanceType()
    {
        return RetrieveRequestToPay::class;
    }

    protected function getResponseInstanceType()
    {
        return RequestToPayStatusResponse::class;
    }

    protected function getRequestType()
    {
        return BaseProcess::SYNCHRONOUS_PROCESS;
    }

    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $sReferenceId = 'ccf50462-e8e8-4f98-84a8-03007bc93f18';
        $this->request = Collection::requestToPayTransactionStatus(
            $sReferenceId,
            $env['collection_subscription_key'],
            $env['target_environment']
        );
    }
}
