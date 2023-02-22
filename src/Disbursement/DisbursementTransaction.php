<?php

namespace momopsdk\Disbursement;

use momopsdk\Common\Process\GetBalance;
use momopsdk\Disbursement\Process\GetDepositStatus;
use momopsdk\Disbursement\Process\GetRefundStatus;
use momopsdk\Common\Process\GetTransferStatus;
use momopsdk\Disbursement\Process\CreateDepositV1;
use momopsdk\Disbursement\Process\CreateDepositV2;
use momopsdk\Disbursement\Process\CreateRefundV1;
use momopsdk\Disbursement\Process\CreateRefundV2;
use momopsdk\Common\Process\Transfer;

class DisbursementTransaction
{
    const SUBTYPE = 'disbursement';

    public static function getAccountBalance($sSubKey, $sTargetEnvironment)
    {
        return new GetBalance($sSubKey, $sTargetEnvironment, DisbursementTransaction::SUBTYPE);
    }

    /**
     * Function to get deposit status
     * @param $sSubKey, $sTargetEnvironment, $sRefId
     * @return object
     */
    public function getDepositStatus($sSubKey, $sTargetEnvironment, $sRefId)
    {
        return new GetDepositStatus($sSubKey, $sTargetEnvironment, $sRefId, DisbursementTransaction::SUBTYPE);
    }

    /**
     * Function to get refund status
     * @param $sSubKey, $sTargetEnvironment, $sRefId
     * @return object
     */
    public function getRefundStatus($sSubKey, $sTargetEnvironment, $sRefId)
    {
        return new GetRefundStatus($sSubKey, $sTargetEnvironment, $sRefId, DisbursementTransaction::SUBTYPE);
    }

    /**
     * Function to get transfer status
     * @param $sSubKey, $sTargetEnvironment, $sRefId
     * @return object
     */
    public function getTransferStatus($sSubKey, $sTargetEnvironment, $sRefId)
    {
        return new GetTransferStatus($sSubKey, $sTargetEnvironment, $sRefId, DisbursementTransaction::SUBTYPE);
    }

    /**
     * Function to deposit owner's account to payee account
     * @param $oDeposit, $sSubKey, $sTargetEnvironment, $sCallBackUrl
     * @return object
     */
    public function depositV1($oDeposit, $sSubKey, $sTargetEnvironment, $sCallBackUrl = null)
    {
        return new CreateDepositV1($oDeposit, $sSubKey, $sTargetEnvironment, $sCallBackUrl, DisbursementTransaction::SUBTYPE);
    }

     /**
     * Function to deposit owner's account to payee account
     * @param $oDeposit, $sSubKey, $sTargetEnvironment, $sCallBackUrl
     * @return object
     */
    public function depositV2($oDeposit, $sSubKey, $sTargetEnvironment, $sCallBackUrl = null)
    {
        return new CreateDepositV2($oDeposit, $sSubKey, $sTargetEnvironment, $sCallBackUrl, DisbursementTransaction::SUBTYPE);
    }

    /**
     * Function to refund an amount from the owner’s account to a payee account.
     * @param
     * @return object
     */
    public function refundV1($oRefund, $sSubKey, $sTargetEnvironment, $sCallBackUrl = null)
    {
        return new CreateRefundV1($oRefund, $sSubKey, $sTargetEnvironment, $sCallBackUrl, DisbursementTransaction::SUBTYPE);
    }

    /**
     * Function to refund an amount from the owner’s account to a payee account.
     * @param
     * @return object
     */
    public function refundV2($oRefund, $sSubKey, $sTargetEnvironment, $sCallBackUrl = null)
    {
        return new CreateRefundV2($oRefund, $sSubKey, $sTargetEnvironment, $sCallBackUrl, DisbursementTransaction::SUBTYPE);
    }

    /**
     * Function to transfer functionality
     * @param
     * @return object
     */
    public function transfer($oTransferData, $sSubKey, $sTargetEnvironment, $sCallBackUrl)
    {
        return new Transfer($oTransferData, $sSubKey, $sTargetEnvironment, $sCallBackUrl, DisbursementTransaction::SUBTYPE);
    }
}