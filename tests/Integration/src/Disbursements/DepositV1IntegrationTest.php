<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Disbursement\DisbursementTransaction;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Disbursement\Process\CreateDepositV1;
use momopsdk\Disbursement\Models\ResponseModel;
use momopsdk\Disbursement\Models\DepositModel;

class DepositV1IntegrationTest extends IntegrationTestCase
{
    public static $oReqDataObject;

    protected function getProcessInstanceType()
    {
        return CreateDepositV1::class;
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
        $payee = [
            'partyIdType' => 'MSISDN',
            'partyId' => '222222'
        ];
    
        self::$oReqDataObject = new DepositModel();
    
        self::$oReqDataObject
            ->setAmount('2000')
            ->setCurrency('EUR')
            ->setExternalId('12345678')
            ->setPayerMessage('Payer message here')
            ->setPayeeNote('Payee note here')
            ->setPayee($payee);
        }

    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $this->request = DisbursementTransaction::depositV1(
            self::$oReqDataObject,
            $env['disbursement_subscription_key'],
            $env['target_environment'],
            $sCallbackUrl = 'http://webhook.site/c84cd23c-062b-49bb-b206-909bc8625207'
        );
    }
}
