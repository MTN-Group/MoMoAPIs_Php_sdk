<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\SandboxUserProvisioning\User;

try {

    /**
     * Construct request object and set desired parameters
     */

    $sRefId = 'd0091568-0e09-4d1f-b682-a22d0a7e3b52';
    $sCollectionSubKey = 'cf123ce1c20540ff958a8e725468324f';
    $request = User::getUserDetails($sCollectionSubKey, $sRefId);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}
