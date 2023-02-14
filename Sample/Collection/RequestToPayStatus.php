<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Enums\NotificationMethod;
use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Collection\Collection;
use momopsdk\Collection\Models\Transaction;

$transaction = new Transaction();

try {
    /**
     * Construct request object and set desired parameters
     */
    $request = Collection::requestToPayStatus($transaction);

    /**
     * Choose notification method can be either Callback or Polling
     */
    $request->setNotificationMethod(NotificationMethod::POLLING);

    /**
     *Execute the request
     */
    $response = $request->execute();
} catch (MobileMoneyException $ex) {
    print_r($ex->getMessage());
    print_r($ex->getErrorObj());
}
