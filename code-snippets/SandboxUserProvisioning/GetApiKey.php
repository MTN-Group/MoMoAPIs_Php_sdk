<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\SandboxUserProvisioning\User;

try {

    /**
     * Construct request object and set desired parameters
     */

    $sRefId = 'c34d4077-ea8d-4a50-bf76-dbfd37d8bfb6';
    $sCollectionSubKey = 'cf123ce1c20540ff958a8e725468324f';
    $request = User::createApiKey($sCollectionSubKey, $sRefId);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}
