<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Collection\Collection;
use momopsdk\Common\Models\DeliveryNotification;

try {

    /**
     * Construct request object and set desired parameters
     */

    $deliveryNotification = new DeliveryNotification();
    $deliveryNotification->setnotificationMessage('Pay for product a mrudul delivery notification');
    $referenceId = '0f6a0052-73cf-446a-b1ba-03b3bc572b1a';
    $notificationMessage = 'Pay for product a mrudul delivery notification';
    $language = "eng";
    $contentType = "application/json";
    $request = Collection::requestToPayDeliveryNotification($referenceId, $notificationMessage, $sCollectionSubKey, $targetEnvironment, $deliveryNotification, $language, $contentType);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (MobileMoneyException $ex) {

    print_r($ex->getMessage());
    print_r($ex->getErrorObj());
}
