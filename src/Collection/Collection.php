<?php

namespace momopsdk\Collection;

use momopsdk\Common\Process\GetBalance;
use momopsdk\Common\Process\GetBasicUserInfo;
use momopsdk\Common\Process\ValidateAccountHolder;
use momopsdk\Common\Process\GetUserInfoWithConsent;
use momopsdk\Collection\Process\RequestToWithdrawV1;
use momopsdk\Collection\Process\RequestToWithdrawV2;
use momopsdk\Collection\Process\InitiateRequestToPay;
use momopsdk\Collection\Process\RetrieveRequestToPay;
use momopsdk\Collection\Process\RequestToWithdrawStatus;
use momopsdk\Common\Process\GetBalanceInSpecificCurrency;
use momopsdk\Common\Process\RequestToPayDeliveryNotification;

/**
 * Class Collection
 * @package momopsdk\Collection
 */
class Collection
{
    const SUBTYPE = 'collection';

    /**
     * Create a Collection Payment Request.
     * Asynchronous payment flow is used with a final callback.
     * @param object $oTransaction
     * @param string $sCollectionSubKey, $sTargetEnvironment, $sCallBackUrl, sContentType
     * @return object InitiateRequestToPay
     */
    public static function requestToPay(
        $oTransaction,
        $sCollectionSubKey,
        $sTargetEnvironment,
        $sCallBackUrl = null,
        $sContentType = null
    ) {
        return new InitiateRequestToPay(
            $oTransaction,
            $sCollectionSubKey,
            $sTargetEnvironment,
            $sCallBackUrl,
            $sContentType
        );
    }

    /**
     * Get request to pay status.
     * @param string $sReferenceId, $sCollectionSubKey, $sTargetEnvironment
     * @return object RetrieveRequestToPay
     *
     */
    public static function requestToPayTransactionStatus($sReferenceId, $sCollectionSubKey, $sTargetEnvironment)
    {
        return new RetrieveRequestToPay($sReferenceId, $sCollectionSubKey, $sTargetEnvironment);
    }

    /**
     * For validating account holder status
     * @param string $sAccountHolderId, $sAccountHolderIdType, $sCollectionSubKey, $sTargetEnvironment
     * @return object ValidateAccountHolder
     *
     */
    public static function validateAccountHolderStatus(
        $sAccountHolderId,
        $sAccountHolderIdType,
        $sCollectionSubKey,
        $sTargetEnvironment
    ) {
        return new ValidateAccountHolder(
            $sAccountHolderId,
            $sAccountHolderIdType,
            $sCollectionSubKey,
            $sTargetEnvironment,
            Collection::SUBTYPE
        );
    }

    /**
     * For getting the account balance
     * @param string $sCollectionSubKey, $sTargetEnvironment
     * @return object GetBalance
     *
     */
    public static function getAccountBalance($sCollectionSubKey, $sTargetEnvironment)
    {
        return new GetBalance($sCollectionSubKey, $sTargetEnvironment, Collection::SUBTYPE);
    }

    /**
     * For requesting to withdraw from a consumer account
     * Asynchronous payment flow is used with a final callback.
     * @param object $oTransaction
     * @param string $sCollectionSubKey, $sTargetEnvironment
     * @return object RequestToWithdrawV1
     *
     */
    public static function requestToWithdrawV1(
        $oTransaction,
        $sCollectionSubKey,
        $sTargetEnvironment,
        $sCallbackUrl = null,
        $sContentType = null
    ) {
        return new RequestToWithdrawV1(
            $oTransaction,
            $sCollectionSubKey,
            $sTargetEnvironment,
            $sCallbackUrl,
            $sContentType
        );
    }

    /**
     * For requesting to withdraw from a consumer account
     * Asynchronous payment flow is used with a final callback.
     * @param object $oTransaction
     * @param string $sCollectionSubKey, $sTargetEnvironment
     * @return object RequestToWithdrawV2
     *
     */
    public static function requestToWithdrawV2(
        $oTransaction,
        $sCollectionSubKey,
        $sTargetEnvironment,
        $sCallbackUrl = null,
        $sContentType = null
    ) {
        return new RequestToWithdrawV2(
            $oTransaction,
            $sCollectionSubKey,
            $sTargetEnvironment,
            $sCallbackUrl,
            $sContentType
        );
    }

    /**
     * For getting status of withdrawel request
     * @param string $sReferenceId, $sCollectionSubKey, $sTargetEnvironment
     * @return object RequestToWithdrawStatus
     *
     */
    public static function requestToWithdrawTransactionStatus($sReferenceId, $sCollectionSubKey, $sTargetEnvironment)
    {
        return new RequestToWithdrawStatus($sReferenceId, $sCollectionSubKey, $sTargetEnvironment);
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
        $sCollectionSubKey,
        $sTargetEnvironment,
        $oDeliveryNotification,
        $sLanguage,
        $sContentType = null
    ) {
        return new RequestToPayDeliveryNotification(
            $sReferenceId,
            $sNotificationMessage,
            $sCollectionSubKey,
            $sTargetEnvironment,
            $oDeliveryNotification,
            $sLanguage,
            $sContentType,
            Collection::SUBTYPE
        );
    }

    /**
     * For getting information about the user
     * @param string $sAccountHolderMSISDN, $sCollectionSubKey, $sTargetEnvironment
     * @return object GetBasicUserInfo
     *
     */
    public static function getBasicUserinfo($sAccountHolderMSISDN, $sCollectionSubKey, $sTargetEnvironment)
    {
        return new GetBasicUserInfo(
            $sAccountHolderMSISDN,
            $sCollectionSubKey,
            $sTargetEnvironment,
            Collection::SUBTYPE
        );
    }

    /**
     * For getting information about the user with consent
     * @param string $sSubKey, $sTargetEnvironment, $sCallBackUrl
     * @return object GetUserInfoWithConsent
     *
     */
    public static function getUserInfoWithConsent($sSubKey, $sTargetEnvironment, $sCallBackUrl = null)
    {
        return new GetUserInfoWithConsent(
            $sSubKey,
            $sTargetEnvironment,
            Collection::SUBTYPE,
            $sCallBackUrl
        );
    }

    /**
     * For getting account balance in specific currency
     * @param string $sSubKey, $sTargetEnvironment, $sCurrency
     * @return object GetBasicUserInfo
     *
     */
    public static function getAccountBalanceInSpecificCurrency($sSubKey, $sTargetEnvironment, $sCurrency)
    {
        return new GetBalanceInSpecificCurrency(
            $sSubKey,
            $sTargetEnvironment,
            $sCurrency,
            Collection::SUBTYPE
        );
    }
}
