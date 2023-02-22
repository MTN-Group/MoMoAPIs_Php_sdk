<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Collection\Collection;

try {

    /**
     * Construct request object and set desired parameters
     */
    $referenceId = 'a52d1a60-b777-4c0f-a3b1-9957cf74b25e';
    $notificationMessage = 'Pay for product a mrudul delivery notification';
    $request = Collection::requestToPayDeliveryNotification($referenceId, $notificationMessage, $sCollectionSubKey, $targetEnvironment);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (MobileMoneyException $ex) {

    print_r($ex->getMessage());
    print_r($ex->getErrorObj());
}
