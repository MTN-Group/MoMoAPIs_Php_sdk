<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Remittance\Remittance;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Common\Process\GetUserInfoWithConsent;
use momopsdk\Common\Models\UserDetail;

class GetUserInfoWithConsentRemittanceIntegrationTest extends IntegrationTestCase
{
    protected function getProcessInstanceType()
    {
        return GetUserInfoWithConsent::class;
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
        $sCallBackUrl = "http://webhook.site/c84cd23c-062b-49bb-b206-909bc8625207"; // for bc-authorize
        $this->request = Remittance::getUserInfoWithConsent(
            $env['remittance_subscription_key'],
            $env['target_environment'],
            $sCallBackUrl
        );
    }
}
