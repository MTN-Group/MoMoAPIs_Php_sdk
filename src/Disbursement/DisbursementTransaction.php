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
use momopsdk\Common\Process\ValidateAccountHolder;
use momopsdk\Common\Process\RequestToPayDeliveryNotification;
use momopsdk\Common\Process\GetBasicUserInfo;

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
    public static function getDepositStatus($sSubKey, $sTargetEnvironment, $sRefId)
    {
        return new GetDepositStatus($sSubKey, $sTargetEnvironment, $sRefId, DisbursementTransaction::SUBTYPE);
    }

    /**
     * Function to get refund status
     * @param $sSubKey, $sTargetEnvironment, $sRefId
     * @return object
     */
    public static function getRefundStatus($sSubKey, $sTargetEnvironment, $sRefId)
    {
        return new GetRefundStatus($sSubKey, $sTargetEnvironment, $sRefId, DisbursementTransaction::SUBTYPE);
    }

    /**
     * Function to get transfer status
     * @param $sSubKey, $sTargetEnvironment, $sRefId
     * @return object
     */
    public static function getTransferStatus($sSubKey, $sTargetEnvironment, $sRefId)
    {
        return new GetTransferStatus($sSubKey, $sTargetEnvironment, $sRefId, DisbursementTransaction::SUBTYPE);
    }

    /**
     * Function to deposit owner's account to payee account
     * @param $oDeposit, $sSubKey, $sTargetEnvironment, $sCallBackUrl
     * @return object
     */
    public static function depositV1($oDeposit, $sSubKey, $sTargetEnvironment, $sCallBackUrl = null)
    {
        return new CreateDepositV1(
            $oDeposit,
            $sSubKey,
            $sTargetEnvironment,
            $sCallBackUrl,
            DisbursementTransaction::SUBTYPE
        );
    }

     /**
     * Function to deposit owner's account to payee account
     * @param $oDeposit, $sSubKey, $sTargetEnvironment, $sCallBackUrl
     * @return object
     */
    public static function depositV2($oDeposit, $sSubKey, $sTargetEnvironment, $sCallBackUrl = null)
    {
        return new CreateDepositV2(
            $oDeposit,
            $sSubKey,
            $sTargetEnvironment,
            $sCallBackUrl,
            DisbursementTransaction::SUBTYPE
        );
    }

    /**
     * Function to refund an amount from the owner’s account to a payee account.
     * @param
     * @return object
     */
    public static function refundV1($oRefund, $sSubKey, $sTargetEnvironment, $sCallBackUrl = null)
    {
        return new CreateRefundV1(
            $oRefund,
            $sSubKey,
            $sTargetEnvironment,
            $sCallBackUrl,
            DisbursementTransaction::SUBTYPE
        );
    }

    /**
     * Function to refund an amount from the owner’s account to a payee account.
     * @param
     * @return object
     */
    public static function refundV2($oRefund, $sSubKey, $sTargetEnvironment, $sCallBackUrl = null)
    {
        return new CreateRefundV2(
            $oRefund,
            $sSubKey,
            $sTargetEnvironment,
            $sCallBackUrl,
            DisbursementTransaction::SUBTYPE
        );
    }

    /**
     * Function to transfer functionality
     * @param $oTransferData, $sSubKey, $sTargetEnvironment, $sCallBackUrl
     * @return object
     */
    public static function transfer($oTransferData, $sSubKey, $sTargetEnvironment, $sCallBackUrl = null)
    {
        return new Transfer(
            $oTransferData,
            $sSubKey,
            $sTargetEnvironment,
            $sCallBackUrl,
            DisbursementTransaction::SUBTYPE
        );
    }


    /**
     * For sending additional Notification to an End User
     * @param string $sReferenceId, $sNotificationMessage, $sCollectionSubKey, $sTargetEnvironment, $oDeliveryNotification
     * @return object RequestToPayDeliveryNotification
     *
     */
    public static function requestToPayDeliveryNotification(
        $sReferenceId,
        $sNotificationMessage,
        $sSubKey,
        $sTargetEnvironment,
        $oDeliveryNotification,
        $sLanguage,
        $sContentType = null
    )
    {
        return new RequestToPayDeliveryNotification(
            $sReferenceId,
            $sNotificationMessage,
            $sSubKey,
            $sTargetEnvironment,
            $oDeliveryNotification,
            $sLanguage,
            $sContentType,
            DisbursementTransaction::SUBTYPE
        );
    }

    /**
     * For getting information about the user
     * @param string $sAccountHolderMSISDN, $sSubKey, $sTargetEnvironment
     * @return object GetBasicUserInfo
     *
     */
    public static function getBasicUserinfo($sAccountHolderMSISDN, $sSubKey, $sTargetEnvironment)
    {
        return new GetBasicUserInfo(
            $sAccountHolderMSISDN,
            $sSubKey,
            $sTargetEnvironment,
            DisbursementTransaction::SUBTYPE
        );
    }

    /**
     * For validating account holder status
     * @param string $sAccountHolderId, $sAccountHolderIdType, $sSubKey, $sTargetEnvironment
     * @return object ValidateAccountHolder
     *
     */
    public static function validateAccountHolderStatus(
        $sAccountHolderId,
        $sAccountHolderIdType,
        $sSubKey,
        $sTargetEnvironment
    )
    {
        return new ValidateAccountHolder(
            $sAccountHolderId,
            $sAccountHolderIdType,
            $sSubKey,
            $sTargetEnvironment,
            DisbursementTransaction::SUBTYPE
        );
    }
}