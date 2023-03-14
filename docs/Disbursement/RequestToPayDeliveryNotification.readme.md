# This operation is used to send additional Notification to an End User.

1.`requestToPayDeliveryNotification($referenceId, $notificationMessage, $sDisbursementSubKey, $targetEnvironment) creates a POST request to end point /disbursement/v1_0/requesttopay/{referenceId}/deliverynotification and send additional Notification to an End User in the sandbox environment.`

> `End user will get result as 200 ok, if the request to pay delivery notification is sent.`

### Usage/Examples

```php

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
    $referenceId = 'ce20fe55-fc5c-4a50-8d5a-43a85e67f928';
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


```
### Example Output
`200 OK`
```php
momopsdk\Common\Models\CallbackResponse Object
(
    [result] =>
    [httpCode] => 200
    [referenceId] => 11716f27-6bb9-4285-9061-4857d136206b
)

```