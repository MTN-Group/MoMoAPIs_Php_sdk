<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Collection\Collection;

try {
    /**
     * Construct request object and set desired parameters
     */
    $request = Collection::getUserInfoWithConsent($sCollectionSubKey, $targetEnvironment);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}
