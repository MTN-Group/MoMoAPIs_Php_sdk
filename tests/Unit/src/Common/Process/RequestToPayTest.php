<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Collection\Models\Transaction;
use momopsdk\Collection\Models\StatusResponse;
use momopsdk\Collection\Process\InitiateRequestToPay;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;

class RequestToPayTest extends ProcessTestCase
{

    private $subType = 'collection';

    protected function setUp(): void
    {
        $transaction = new Transaction();
        $transaction
            ->setAmount('200.00')
            ->setCurrency('RWF')
            ->setExternalId("6253728")
            ->setPartyId("MSISDN")
            ->setPartyIdType("0248888736")
            ->setPayerMessage("Paying for product a")
            ->setPayeeNote("Payer note");
        $payer = [
            'partyIdType' => 'MSISDN',
            'partyId' => '0248888736'
        ];
        $transaction->setPayer($payer);
        $callbackUrl = "http://webhook.site.com/345656";
        $contentType = "application/json";
        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $this->constructorArgs = [$transaction, $env['collection_subscription_key'], $env['target_environment'], $this->subType, $callbackUrl, $contentType];
        $this->requestMethod = 'POST';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/collection/v1_0/requesttopay';
        $this->className = InitiateRequestToPay::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->requestOptions = ['X-Callback-URL: http://webhook.site.com/345656'];
        $this->processType = BaseProcess::ASYNCHRONOUS_PROCESS;
        $this->mockResponseObject = 'BasicUserInfo.json';
        $this->responseType = RequestToPayResponse::class;
    }
}
