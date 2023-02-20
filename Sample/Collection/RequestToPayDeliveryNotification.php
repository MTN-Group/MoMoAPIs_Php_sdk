<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Collection\Collection;

try {

    /**
     * Construct request object and set desired parameters
     */
    $referenceId = '6743502b-3c8b-453b-9132-0c819fe428f5';
    $notificationMessage = 'Pay for product a mrudul delivery notification';
    $request = Collection::requestToPayDeliveryNotification($referenceId, $notificationMessage);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (MobileMoneyException $ex) {

    print_r($ex->getMessage());
    print_r($ex->getErrorObj());
}
