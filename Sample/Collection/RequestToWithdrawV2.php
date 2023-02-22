<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Enums\NotificationMethod;
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

    $request = Collection::requestToWithdrawV2($transaction, $sCollectionSubKey, $targetEnvironment);

    /**
     * Choose notification method can be either Callback or Polling
     */
    $request->setNotificationMethod(NotificationMethod::POLLING);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (MobileMoneyException $ex) {
    print_r($ex->getMessage());
    print_r($ex->getErrorObj());
}
