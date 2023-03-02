<?php

namespace momopsdk\Remittance;

use momopsdk\Common\Process\GetBalance;
use momopsdk\Common\Process\GetTransferStatus;
use momopsdk\Common\Process\Transfer;
use momopsdk\Common\Process\ValidateAccountHolder;
use momopsdk\Common\Process\RequestToPayDeliveryNotification;
use momopsdk\Common\Process\GetBasicUserInfo;
use momopsdk\Common\Process\GetUserInfoWithConsent;

class Remittance
{
    const SUBTYPE = 'remittance';

    /**
     * Function to get the account balance
     * @param $sSubKey, $sTargetEnvironment
     * @return object
     */
    public static function getAccountBalance($sSubKey, $sTargetEnvironment)
    {
        return new GetBalance($sSubKey, $sTargetEnvironment, Remittance::SUBTYPE);
    }

    /**
     * Function to transfer functionality
     * @param $oTransferData, $sSubKey, $sTargetEnvironment, $sCallBackUrl
     * @return object
     */
    public static function transfer($oTransferData, $sSubKey, $sTargetEnvironment, $sCallBackUrl = null)
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
    public static function getTransferStatus($sSubKey, $sTargetEnvironment, $sRefId)
    {
        return new GetTransferStatus($sSubKey, $sTargetEnvironment, $sRefId, Remittance::SUBTYPE);
    }
    
    /**
     * Function to validate account holder status
     * @param $sAccountHolderId, $sAccountHolderIdType, $sSubKey, $sTargetEnvironment
     * @return object
     */
    public static function validateAccountHolderStatus(
       $sAccountHolderId, $sAccountHolderIdType,
       $sSubKey, $sTargetEnvironment
    )
    {
        return new ValidateAccountHolder(
           $sAccountHolderId, $sAccountHolderIdType,
           $sSubKey, $sTargetEnvironment, Remittance::SUBTYPE
        );
    }

    /**
     * Function to Request to pay delivery notification
     * @param $sReferenceId, $sNotificationMessage, $sSubKey, $sTargetEnvironment, $oDeliveryNotification, $sLanguage, $sContentType
     * @return object
     */
    public static function requestToPayDeliveryNotification($sReferenceId, $sNotificationMessage, $sSubKey,
       $sTargetEnvironment, $oDeliveryNotification, $sLanguage, $sContentType = null
    )
    {
        return new RequestToPayDeliveryNotification($sReferenceId, $sNotificationMessage,
           $sSubKey, $sTargetEnvironment, $oDeliveryNotification, $sLanguage, $sContentType, Remittance::SUBTYPE
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
        return new GetBasicUserInfo($sAccountHolderMSISDN, $sSubKey,
           $sTargetEnvironment, Remittance::SUBTYPE
        );
    }

    public static function getUserInfoWithConsent($sSubKey, $sTargetEnvironment, $sCallBackUrl = null)
    {
        return new GetUserInfoWithConsent(
            $sSubKey,
            $sTargetEnvironment,
            Remittance::SUBTYPE,
            $sCallBackUrl
        );
    }
}