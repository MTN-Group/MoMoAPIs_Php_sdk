<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\SandboxUserProvisioning\User;

try {

    /**
     * Construct request object and set desired parameters
     */

    $aData = ['providerCallbackHost' => 'www.example.com'];
    $sCollectionSubKey = 'cf123ce1c20540ff958a8e725468324f';
    $request = User::createUser($aData, $sCollectionSubKey);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}
