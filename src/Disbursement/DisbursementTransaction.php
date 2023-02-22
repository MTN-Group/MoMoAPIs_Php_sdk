<?php

namespace momopsdk\Disbursement;

use momopsdk\Disbursement\Process\GetBalance;
use momopsdk\Disbursement\Process\GetDepositStatus;
use momopsdk\Disbursement\Process\GetRefundStatus;
use momopsdk\Disbursement\Process\GetTransferStatus;
use momopsdk\Disbursement\Process\CreateDepositV1;
use momopsdk\Disbursement\Process\CreateDepositV2;

class DisbursementTransaction
{
    public static function getAccountBalance($sSubKey, $sTargetEnvironment)
    {
        return new GetBalance($sSubKey, $sTargetEnvironment);
    }

    /**
     * Function to get deposit status
     * @param $sSubKey, $sTargetEnvironment, $sRefId
     * @return object
     */
    public function getDepositStatus($sSubKey, $sTargetEnvironment, $sRefId)
    {
        return new GetDepositStatus($sSubKey, $sTargetEnvironment, $sRefId);
    }

    /**
     * Function to get refund status
     * @param $sSubKey, $sTargetEnvironment, $sRefId
     * @return object
     */
    public function getRefundStatus($sSubKey, $sTargetEnvironment, $sRefId)
    {
        return new GetRefundStatus($sSubKey, $sTargetEnvironment, $sRefId);
    }

    /**
     * Function to get transfer status
     * @param $sSubKey, $sTargetEnvironment, $sRefId
     * @return object
     */
    public function getTransferStatus($sSubKey, $sTargetEnvironment, $sRefId)
    {
        return new GetTransferStatus($sSubKey, $sTargetEnvironment, $sRefId);
    }

    /**
     * Function to deposit owner's account to payee account
     * @param $oDeposit, $sSubKey, $sTargetEnvironment, $sCallBackUrl
     * @return object
     */
    public function depositV1($oDeposit, $sSubKey, $sTargetEnvironment, $sCallBackUrl)
    {
        return new CreateDepositV1($oDeposit, $sSubKey, $sTargetEnvironment, $sCallBackUrl);
    }

     /**
     * Function to deposit owner's account to payee account
     * @param $oDeposit, $sSubKey, $sTargetEnvironment, $sCallBackUrl
     * @return object
     */
    public function depositV2($oDeposit, $sSubKey, $sTargetEnvironment, $sCallBackUrl)
    {
        return new CreateDepositV2($oDeposit, $sSubKey, $sTargetEnvironment, $sCallBackUrl);
    }
}