<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Collection\Collection;

try {

    /**
     * Construct request object and set desired parameters
     */
    $accountHolderMSISDN = '0248888736';
    $request = Collection::getBasicUserinfo($accountHolderMSISDN, $sCollectionSubKey, $targetEnvironment);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (MobileMoneyException $ex) {

    print_r($ex->getMessage());
    print_r($ex->getErrorObj());
}
