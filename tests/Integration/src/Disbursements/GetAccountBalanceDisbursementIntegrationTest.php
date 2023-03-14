<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Disbursement\DisbursementTransaction;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Common\Process\GetBalance;
use momopsdk\Common\Models\GetAccBalance;

class GetAccountBalanceDisbursementIntegrationTest extends IntegrationTestCase
{
    protected function getProcessInstanceType()
    {
        return GetBalance::class;
    }

    protected function getResponseInstanceType()
    {
        return GetAccBalance::class;
    }

    protected function getRequestType()
    {
        return BaseProcess::SYNCHRONOUS_PROCESS;
    }

    // public static function setUpBeforeClass(): void
    // {
    //     self::$batchTransaction = new BatchTransaction();
    //     self::$batchTransaction
    //         ->setBatchTitle('Batch_Test')
    //         ->setBatchDescription('Testing a Batch')
    //         ->setScheduledStartDate('2019-12-11T15:08:03.158Z');
    //     $transactionsArray = [];
    //     $transactionItem1 = new Transaction();
    //     $transactionItem2 = new Transaction();
    //     $transactionItem1
    //         ->setCreditParty(['walletid' => '1'])
    //         ->setDebitParty(['msisdn' => '+44012345678'])
    //         ->setCurrency('RWF')
    //         ->setAmount('200.00')
    //         ->setType('transfer');
    //     $transactionItem2
    //         ->setCreditParty(['msisdn' => '+44012345678'])
    //         ->setDebitParty(['walletid' => '1'])
    //         ->setCurrency('RWF')
    //         ->setAmount('200.00')
    //         ->setType('transfer');
    //     array_push($transactionsArray, $transactionItem1);
    //     array_push($transactionsArray, $transactionItem2);
    //     self::$batchTransaction->setTransactions($transactionsArray);
    // }

    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $this->request = DisbursementTransaction::getAccountBalance(
            $env['disbursement_subscription_key'], $env['target_environment']
        );
    }
}
