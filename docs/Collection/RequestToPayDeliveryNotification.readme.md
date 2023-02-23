# Initiate a payment request in the sandbox environment

1.`requestToPayDeliveryNotification($referenceId, $notificationMessage, $sCollectionSubKey, $targetEnvironment) creates a POST request to end point /collection/v1_0/requesttopay/{referenceId}/deliverynotification and send additional Notification to an End User in the sandbox environment.`

> `End user will get result as 202 ok if the request to pay delivery notification is sent.`

### Usage/Examples

```php
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
    $referenceId = '11716f27-6bb9-4285-9061-4857d136206b';
    $notificationMessage = 'Pay for product a mrudul delivery notification';
    $callbackUrl = "https://webhook.site/37b4b85e-8c15-4fe5-9076-b7de3071b85d";
    $contentType = "application/json";
    $request = Collection::requestToPayDeliveryNotification($referenceId, $notificationMessage, $sCollectionSubKey, $targetEnvironment, $deliveryNotification, $callbackUrl, $contentType);

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