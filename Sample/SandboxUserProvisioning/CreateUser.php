<?php

include(__DIR__.'/../../autoload.php');

use momopsdk\SandboxUserProvisioning\User;

try {
    $aData = ['providerCallbackHost' => 'www.example.com'];

    $obj = new User();

    $aResponse = User::createUser($aData);

    print_r($aResponse);
} catch (Throwable $e) {
    print_r($e);
}