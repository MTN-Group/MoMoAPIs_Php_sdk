<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Disbursement\DisbursementTransaction;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Disbursement\Process\CreateRefundV1;
use momopsdk\Disbursement\Models\ResponseModel;
use momopsdk\Disbursement\Models\RefundModel;

class RefundV1IntegrationTest extends IntegrationTestCase
{
    public static $oReqDataObject;

    protected function getProcessInstanceType()
    {
        return CreateRefundV1::class;
    }

    protected function getResponseInstanceType()
    {
        return ResponseModel::class;
    }

    protected function getRequestType()
    {
        return BaseProcess::ASYNCHRONOUS_PROCESS;
    }

    public static function setUpBeforeClass(): void
    {
        self::$oReqDataObject = new RefundModel();
    
        self::$oReqDataObject
            ->setAmount('2000')
            ->setCurrency('EUR')
            ->setExternalId('12345678')
            ->setPayerMessage('Payer message here')
            ->setPayeeNote('Payee note here')
            ->setReferenceIdToRefund('ce20fe55-fc5c-4a50-8d5a-43a85e67f928');
        }

    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $this->request = DisbursementTransaction::refundV1(
            self::$oReqDataObject,
            $env['disbursement_subscription_key'],
            $env['target_environment'],
            $sCallbackUrl = 'http://webhook.site/c84cd23c-062b-49bb-b206-909bc8625207'
        );
    }
}
