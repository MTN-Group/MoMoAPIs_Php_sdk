<?php

namespace momopsdk\Disbursement;

use momopsdk\Disbursement\Process\GetBalance;
use momopsdk\Disbursement\Process\GetDepositStatus;

class DisbursementTransaction
{
    public static function getAccountBalance($sSubKey, $sTargetEnvironment)
    {
        return new GetBalance($sSubKey, $sTargetEnvironment);
    }

    /**
     * Function to get deposit status
     * @param $sSubKey, $sTargetEnvironment, $sRefId
     * @return 
     */
    public function getDepositStatus($sSubKey, $sTargetEnvironment, $sRefId)
    {
        return new GetDepositStatus($sSubKey, $sTargetEnvironment, $sRefId);
    }
}