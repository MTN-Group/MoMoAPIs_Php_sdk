<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Collection\Models\Transaction;
use momopsdk\Collection\Models\RequestToPayResponse;
use momopsdk\Collection\Process\InitiateRequestToPay;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;

class RequestToPayTest extends ProcessTestCase
{

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
        $callbackUrl = "https://webhook.site/";
        $contentType = "application/json";
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $this->constructorArgs =
            [$transaction, $env['collection_subscription_key'], $env['target_environment'], $callbackUrl, $contentType];
        $this->requestMethod = 'POST';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/collection/v1_0/requesttopay';
        $this->className = InitiateRequestToPay::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->processType = BaseProcess::ASYNCHRONOUS_PROCESS;
        $this->mockResponseObject = 'RequestToPayResponse.json';
        $this->responseType = RequestToPayResponse::class;
    }
}
