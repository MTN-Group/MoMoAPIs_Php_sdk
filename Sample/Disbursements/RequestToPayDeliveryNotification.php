<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Disbursement\DisbursementTransaction;
use momopsdk\Common\Models\DeliveryNotification;

try {

    /**
     * Construct request object and set desired parameters
     */

    $deliveryNotification = new DeliveryNotification();
    $deliveryNotification->setnotificationMessage('Pay for product a delivery notification');
    $referenceId = 'ba3f54b1-3105-486b-9185-5f2737a377a4';
    $notificationMessage = 'Pay for product a delivery notification';
    $language = "eng";
    $contentType = "application/json";
    $request = DisbursementTransaction::requestToPayDeliveryNotification($referenceId, $notificationMessage, $sDisbursementSubKey, $targetEnvironment, $deliveryNotification, $language, $contentType);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (MobileMoneyException $ex) {

    print_r($ex->getMessage());
    print_r($ex->getErrorObj());
}
