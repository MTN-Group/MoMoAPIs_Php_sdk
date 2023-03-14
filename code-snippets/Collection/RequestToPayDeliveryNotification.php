<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Collection\Collection;
use momopsdk\Common\Models\DeliveryNotification;

$deliveryNotification = new DeliveryNotification();
$deliveryNotification->setnotificationMessage('Pay for product a mrudul delivery notification');
$referenceId = '11716f27-6bb9-4285-9061-4857d136206b';
$notificationMessage = 'Pay for product a mrudul delivery notification';
$language = "eng";
$contentType = "application/json";
$sCollectionSubKey = 'cf123ce1c20540ff958a8e725468324f';
$targetEnvironment = 'sandbox';

try {

    /**
     * Construct request object and set desired parameters
     */
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
