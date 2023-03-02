<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Collection\Collection;

try {

    $request = Collection::getUserInfoWithConsent($sCollectionSubKey, $targetEnvironment);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}