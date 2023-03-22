<?php

use momopsdk\Collection\Collection;
use momopsdk\Common\Process\BaseProcess;
use momopsdkTest\Integration\src\IntegrationTestCase;
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
        $payer = [
            'partyIdType' => 'MSISDN',
            'partyId' => '0248888736'
        ];
        self::$transaction = new Transaction();
        self::$transaction
            ->setAmount("100")
            ->setCurrency("EUR")
            ->setExternalId("6253728")
            ->setPayer($payer)
            ->setPartyId("MSISDN")
            ->setPartyIdType("0248888736")
            ->setPayerMessage("Paying for product a")
            ->setPayeeNote("Payer note");
    }

    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $this->request = Collection::requestToPay(
            self::$transaction,
            $env['collection_subscription_key'],
            $env['target_environment']
        );
    }
}
