<?php

use momopsdk\Collection\Collection;
use momopsdk\Common\Models\UserDetail;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Process\GetBasicUserInfo;
use momopsdkTest\Integration\src\IntegrationTestCase;

class GetBasicUserInfoIntegrationTest extends IntegrationTestCase
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
        $sAccountHolderMSISDN = '0248888736';
        $this->request = Collection::getBasicUserinfo(
            $sAccountHolderMSISDN,
            $env['collection_subscription_key'],
            $env['target_environment']
        );
    }
}
