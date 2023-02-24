<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Remittance\Remittance;

try {

    /**
     * Construct request object and set desired parameters
     */
    $accountHolderMSISDN = '0248888736';
    $request = Remittance::getBasicUserinfo($accountHolderMSISDN, $sRemittanceSubKey, $targetEnvironment);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (MobileMoneyException $ex) {

    print_r($ex->getMessage());
    print_r($ex->getErrorObj());
}
