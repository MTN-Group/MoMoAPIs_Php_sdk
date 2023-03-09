<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Remittance\Remittance;
use momopsdk\Common\Models\DeliveryNotification;

try {

    /**
     * Construct request object and set desired parameters
     */

    $deliveryNotification = new DeliveryNotification();
    $deliveryNotification->setnotificationMessage('Pay for product a delivery notification');
    $referenceId = 'ce20fe55-fc5c-4a50-8d5a-43a85e67f928';
    $notificationMessage = 'Pay for product a delivery notification';
    $language = "eng";
    $contentType = "application/json";
    $sRemittanceSubKey = '6d69c1bd1f874a6aa548ee8b79f9578f';
    $targetEnvironment = 'sandbox';
    $request = Remittance::requestToPayDeliveryNotification($referenceId, $notificationMessage, $sRemittanceSubKey, $targetEnvironment, $deliveryNotification, $language, $contentType);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (MobileMoneyException $ex) {

    print_r($ex->getMessage());
    print_r($ex->getErrorObj());
}
