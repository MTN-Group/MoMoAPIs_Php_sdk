<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\SandboxUserProvisioning\User;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\SandboxUserProvisioning\Process\GetApiKey;
use momopsdk\Common\Models\UserDetail;

class GetApiKeyIntegrationTest extends IntegrationTestCase
{
    public static $oReqDataObject;

    protected function getProcessInstanceType()
    {
        return GetApiKey::class;
    }

    protected function getResponseInstanceType()
    {
        return UserDetail::class;
    }

    protected function getRequestType()
    {
        return BaseProcess::SYNCHRONOUS_PROCESS;
    }


    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $refId = $env['reference_id'];
        $this->request = User::createApiKey(
            $env['remittance_subscription_key'],
            $refId
        );
    }
}
