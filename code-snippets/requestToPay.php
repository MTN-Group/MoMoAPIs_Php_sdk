<?php
require_once __DIR__ . '/bootstrap.php';

use mmpsdk\Common\Enums\NotificationMethod;
use mmpsdk\Common\Exceptions\MobileMoneyException;
use mmpsdk\Collection\Collection;
use mmpsdk\Collection\Models\Transaction;

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


try {
    /**
     * Construct request object and set desired parameters
     */
    $request = Collection::requestToPay($transaction);

    /**
     * Choose notification method can be either Callback or Polling
     */
    $request->setNotificationMethod(NotificationMethod::CALLBACK);

    /**
     *Execute the request
     */
    $response = $request->execute();
} catch (MobileMoneyException $ex) {
    print_r($ex->getMessage());
    print_r($ex->getErrorObj());
}
