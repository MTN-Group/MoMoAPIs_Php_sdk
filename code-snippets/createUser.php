<?php
require_once __DIR__ . '/bootstrap.php';

use mmpsdk\Common\Enums\NotificationMethod;
use mmpsdk\Common\Exceptions\MobileMoneyException;
use mmpsdk\SandboxService\SandboxService;
use mmpsdk\SandBoxService\Models\User;

$user = new User();
$user
    ->setProviderCallbackHost($env['callback_url']);

try {
    /**
     * Construct request object and set desired parameters
     */
    $request = SandboxService::createAccount($user);

    /**
     * Choose notification method can be either Callback or Polling
     */
    $request->setNotificationMethod(NotificationMethod::POLLING);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (MobileMoneyException $ex) {
    print_r($ex->getMessage());
    print_r($ex->getErrorObj());
}
