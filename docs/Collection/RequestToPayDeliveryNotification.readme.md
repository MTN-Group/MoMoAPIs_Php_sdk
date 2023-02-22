# Initiate a payment request in the sandbox environment

1.`requestToPayDeliveryNotification($referenceId, $notificationMessage, $sCollectionSubKey, $targetEnvironment) creates a POST request to end point /collection/v1_0/requesttopay/{referenceId}/deliverynotification and send additional Notification to an End User in the sandbox environment.`

> `End user will get result as 202 ok if the request to pay delivery notification is sent.`

### Usage/Examples

```php
<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Collection\Collection;

try {

    /**
     * Construct request object and set desired parameters
     */
    $referenceId = '135c338c-4d01-4bb5-ad27-a1020cd01520';
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

```