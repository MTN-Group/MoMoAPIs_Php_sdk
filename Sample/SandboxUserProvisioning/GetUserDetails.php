<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\SandboxUserProvisioning\User;

try {

    $sRefId = 'd0091568-0e09-4d1f-b682-a22d0a7e3b52';

    $request = User::getUserDetails($sCollectionSubKey, $sRefId);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}
