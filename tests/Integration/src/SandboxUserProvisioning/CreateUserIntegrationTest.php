<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\SandboxUserProvisioning\User;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\SandboxUserProvisioning\Process\CreateApiUser;
use momopsdk\Common\Models\ResponseState;

class CreateUserIntegrationTest extends IntegrationTestCase
{
    public static $oReqDataObject;

    protected function getProcessInstanceType()
    {
        return CreateApiUser::class;
    }

    protected function getResponseInstanceType()
    {
        return ResponseState::class;
    }

    protected function getRequestType()
    {
        return BaseProcess::ASYNCHRONOUS_PROCESS;
    }


    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $aData = ['providerCallbackHost' => 'webhook.site'];
        $this->request = User::createUser(
            $aData,
            $env['remittance_subscription_key']
        );
    }
}
