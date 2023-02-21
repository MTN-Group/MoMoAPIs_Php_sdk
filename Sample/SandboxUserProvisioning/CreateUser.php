<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\SandboxUserProvisioning\User;

try {
    $aData = ['providerCallbackHost' => 'www.example.com'];

    $request = User::createUser($aData, $sCollectionSubKey);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}
