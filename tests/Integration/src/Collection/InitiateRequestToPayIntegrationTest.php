<?php

use momopsdk\Collection\Collection;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Integration\src\IntegrationTestCase;
use momopsdk\Collection\Models\RequestToPayResponse;
use momopsdk\Collection\Models\Transaction;
use momopsdk\Collection\Process\InitiateRequestToPay;

class InitiateRequestToPayIntegrationTest extends IntegrationTestCase
{
    private static $transaction;

    protected function getProcessInstanceType()
    {
        return InitiateRequestToPay::class;
    }

    protected function getResponseInstanceType()
    {
        return RequestToPayResponse::class;
    }

    protected function getRequestType()
    {
        return BaseProcess::ASYNCHRONOUS_PROCESS;
    }

    public static function setUpBeforeClass(): void
    {
        self::$transaction = new Transaction();
        self::$transaction
            ->setAmount("100")
            ->setCurrency("EUR")
            ->setExternalId("6253728");
        $payer = [
            'partyIdType' => 'MSISDN',
            'partyId' => '0248888736'
        ];
        self::$transaction->setPayer($payer)
            ->setPartyId("MSISDN")
            ->setPartyIdType("0248888736")
            ->setPayerMessage("Paying for product a")
            ->setPayeeNote("Payer note");
    }

    protected function setUp(): void
    {
        $this->request = Collection::requestToPay(
            self::$transaction,
            'cf123ce1c20540ff958a8e725468324f',
            'sandbox'
        );
    }
}
