<?php

use momopsdk\Collection\Collection;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Collection\Models\Transaction;
use momopsdk\Collection\Models\RequestToWithdraw;
use momopsdk\Collection\Process\RequestToWithdrawV1;
use momopsdkTest\Integration\src\IntegrationTestCase;

class RequestToWithdrawV1IntegrationTest extends IntegrationTestCase
{
    private static $transaction;

    protected function getProcessInstanceType()
    {
        return RequestToWithdrawV1::class;
    }

    protected function getResponseInstanceType()
    {
        return RequestToWithdraw::class;
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
        $sCallbackUrl = "https://webhook.site/37b4b85e-8c15-4fe5-9076-b7de3071b85d";
        $sContentType = "application/json";
        $this->request = Collection::requestToWithdrawV1(
            self::$transaction,
            $env['collection_subscription_key'],
            $env['target_environment'],
            $sCallbackUrl,
            $sContentType
        );
    }
}
