<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\BaseProcess;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdkTest\Unit\src\mocks\MockResponse;
use momopsdk\Common\Models\DepositModel;
use momopsdk\Disbursement\Models\ResponseModel;
use momopsdk\Disbursement\Process\CreateDepositV2;



class DepositV2Test extends ProcessTestCase
{
    protected function setUp(): void
    {
        $payee = [
            'partyIdType' => 'MSISDN',
            'partyId' => '222222'
        ];
    
        $oReqDataObject = new DepositModel();
    
        $oReqDataObject
            ->setAmount('2000')
            ->setCurrency('EUR')
            ->setExternalId('12345678')
            ->setPayerMessage('Payer message here')
            ->setPayeeNote('Payee note here')
            ->setPayee($payee);
        $callbackUrl = "http://webhook.site/c84cd23c-062b-49bb-b206-909bc8625207";


        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $sSubsKey = $env['disbursement_subscription_key'];
        $sTargetEnvironmentlter = $env['target_environment'];
        $subType = 'disbursement';
        $this->constructorArgs = [$oReqDataObject, $sSubsKey, $sTargetEnvironmentlter, $callbackUrl, $subType];
        $this->requestMethod = 'POST';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/disbursement/v2_0/deposit';
        $this->processType = BaseProcess::ASYNCHRONOUS_PROCESS;
        $this->className = CreateDepositV2::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->mockResponseObject = 'DepositV2.json';
        $this->responseType = ResponseModel::class;
    }
}
