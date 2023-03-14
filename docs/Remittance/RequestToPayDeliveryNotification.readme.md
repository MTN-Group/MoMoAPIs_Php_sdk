# This operation is used to send additional Notification to an End User

1.`requestToPayDeliveryNotification($referenceId, $notificationMessage, $sRemittanceSubKey, $targetEnvironment) creates a POST request to end point /remittance/v1_0/requesttopay/{referenceId}/deliverynotification and send additional Notification to an End User in the sandbox environment.`

> `End user will get result as 202 ok if the request to pay delivery notification is sent.`

### Usage/Examples

```php

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