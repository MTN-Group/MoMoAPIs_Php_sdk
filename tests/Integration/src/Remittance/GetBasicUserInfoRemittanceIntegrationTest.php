<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Remittance\Remittance;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Common\Process\GetBasicUserInfo;
use momopsdk\Common\Models\UserDetail;

class GetBasicUserInfoRemittanceIntegrationTest extends IntegrationTestCase
{
    protected function getProcessInstanceType()
    {
        return GetBasicUserInfo::class;
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
        $accountHolderMSISDN = '0248888736';
        $this->request = Remittance::getBasicUserinfo(
            $accountHolderMSISDN,
            $env['remittance_subscription_key'],
            $env['target_environment']
        );
    }
}
