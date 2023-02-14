<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\SandboxUserProvisioning\User;

try {

    $sRefId = 'c34d4077-ea8d-4a50-bf76-dbfd37d8bfb6';

    $request = User::createApiKey($sCollectionSubKey, $sRefId);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}