<?php

namespace momopsdk\Disbursement;

use momopsdk\Disbursement\Process\GetBalance;

class DisbursementTransaction
{
    public static function getAccountBalance($sSubKey, $sTargetEnvironment)
    {
        return new GetBalance($sSubKey, $sTargetEnvironment);
    }
}