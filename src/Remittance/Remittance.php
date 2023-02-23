<?php

namespace momopsdk\Remittance;

use momopsdk\Common\Process\GetBalance;
use momopsdk\Common\Process\GetTransferStatus;
use momopsdk\Common\Process\Transfer;

class Remittance
{
    const SUBTYPE = 'remittance';

    /**
     * Function to get the account balance
     * @param $sSubKey, $sTargetEnvironment
     * @return object
     */
    public function getAccountBalance($sSubKey, $sTargetEnvironment)
    {
        return new GetBalance($sSubKey, $sTargetEnvironment, Remittance::SUBTYPE);
    }

    /**
     * Function to transfer functionality
     * @param $oTransferData, $sSubKey, $sTargetEnvironment, $sCallBackUrl
     * @return object
     */
    public function transfer($oTransferData, $sSubKey, $sTargetEnvironment, $sCallBackUrl = null)
    {
        return new Transfer(
           $oTransferData, $sSubKey,
           $sTargetEnvironment, $sCallBackUrl,
           Remittance::SUBTYPE
        );
    }

    /**
     * Function to get transfer status
     * @param $sSubKey, $sTargetEnvironment, $sRefId
     * @return object
     */
    public function getTransferStatus($sSubKey, $sTargetEnvironment, $sRefId)
    {
        return new GetTransferStatus($sSubKey, $sTargetEnvironment, $sRefId, Remittance::SUBTYPE);
    }
}