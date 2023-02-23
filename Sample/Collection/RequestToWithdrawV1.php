<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Collection\Collection;
use momopsdk\Collection\Models\Transaction;

try {

    /**
     * Create a transaction object and set the parameters
     */
    $transaction = new Transaction();
    $transaction->setAmount("100");
    $transaction->setCurrency("EUR");
    $transaction->setExternalId("6253728");
    $payer = [
        'partyIdType' => 'MSISDN',
        'partyId' => '0248888736'
    ];
    $transaction->setPayer($payer);
    $transaction->setPartyId("MSISDN");
    $transaction->setPartyIdType("0248888736");
    $transaction->setPayerMessage("Paying for product a");
    $transaction->setPayeeNote("Payer note");
    /**
     * Construct request object and set desired parameters
     */
    $sCallbackUrl = "https://webhook.site/37b4b85e-8c15-4fe5-9076-b7de3071b85d";
    $sContentType = "application/json";
    $request = Collection::requestToWithdrawV1($transaction, $sCollectionSubKey, $targetEnvironment, $sCallbackUrl, $sContentType);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (MobileMoneyException $ex) {
    print_r($ex->getMessage());
    print_r($ex->getErrorObj());
}
