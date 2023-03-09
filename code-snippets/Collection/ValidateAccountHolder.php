<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Collection\Collection;

$accountHolderId = '0248888736';
$accountHolderIdType = 'msisdn';
$sCollectionSubKey = 'cf123ce1c20540ff958a8e725468324f';
$targetEnvironment = 'sandbox';

try {

    /**
     * Construct request object and set desired parameters
     */
    $request = Collection::validateAccountHolderStatus($accountHolderId, $accountHolderIdType, $sCollectionSubKey, $targetEnvironment);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (MobileMoneyException $ex) {

    print_r($ex->getMessage());
    print_r($ex->getErrorObj());
}
