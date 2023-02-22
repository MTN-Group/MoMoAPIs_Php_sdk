<?php

namespace momopsdk\Collection;

use momopsdk\Collection\Models\Transaction;
use momopsdk\Collection\Process\GetBasicUserInfo;
use momopsdk\Collection\Process\GetAccountBalance;
use momopsdk\Collection\Process\RequestToWithdrawV1;
use momopsdk\Collection\Process\RequestToWithdrawV2;
use momopsdk\Collection\Process\InitiateRequestToPay;
use momopsdk\Collection\Process\RetrieveRequestToPay;
use momopsdk\Collection\Process\ValidateAccountHolder;
use momopsdk\Collection\Process\RequestToWithdrawStatus;
use momopsdk\Collection\Process\RequestToPayDeliveryNotification;

/**
 * Class Collection
 * @package momopsdk\Collection
 */
class Collection
{
    /**
     * Create a Collection Payment Request.
     * Asynchronous payment flow is used with a final callback.
     *
     * @param Transaction $transaction
     * @param string $sCollectionSubKey, $targetEnvironment,$callBackUrl
     * @return InitiateRequestToPay
     */
    public static function requestToPay($transaction, $sCollectionSubKey, $targetEnvironment, $callBackUrl = null)
    {
        return new InitiateRequestToPay($transaction, $sCollectionSubKey, $targetEnvironment, $callBackUrl);
    }

    /**
     * Get request to pay status.
     *
     * @param ReferenceID $referenceId
     * @return RetrieveRequestToPay
     *
     */
    public static function requestToPayTransactionStatus($referenceId, $sCollectionSubKey, $targetEnvironment)
    {
        return new RetrieveRequestToPay($referenceId, $sCollectionSubKey, $targetEnvironment);
    }

    /**
     * For validating account holder status
     *
     * @param string $accountHolderId
     * @param string $accountHolderIdType
     * @return ValidateAccountHolder
     *
     */
    public static function validateAccountHolderStatus($accountHolderId, $accountHolderIdType, $sCollectionSubKey, $targetEnvironment)
    {
        return new ValidateAccountHolder($accountHolderId, $accountHolderIdType, $sCollectionSubKey, $targetEnvironment);
    }

    /**
     * For getting the account balance
     *
     * @return GetAccountBalance
     *
     */
    public static function getAccountBalance($sCollectionSubKey, $targetEnvironment)
    {
        return new GetAccountBalance($sCollectionSubKey, $targetEnvironment);
    }

    /**
     * For requesting to withdraw from a consumer account
     *
     * @param Transaction $transaction
     * @param string $sCollectionSubKey, $targetEnvironment
     * @return RequestToWithdrawV1
     *
     */
    public static function requestToWithdrawV1($transaction, $sCollectionSubKey, $targetEnvironment)
    {
        return new RequestToWithdrawV1($transaction, $sCollectionSubKey, $targetEnvironment);
    }

    /**
     * For requesting to withdraw from a consumer account
     *
     * @param Transaction $transaction
     * @param string $sCollectionSubKey, $targetEnvironment
     * @return RequestToWithdrawV2
     *
     */
    public static function requestToWithdrawV2($transaction, $sCollectionSubKey, $targetEnvironment)
    {
        return new RequestToWithdrawV2($transaction, $sCollectionSubKey, $targetEnvironment);
    }

    /**
     * For getting status of withdrawel request
     * @param string $referenceId
     * @return RequestToWithdrawStatus
     *
     */
    public static function requestToWithdrawTransactionStatus($referenceId, $sCollectionSubKey, $targetEnvironment)
    {
        return new RequestToWithdrawStatus($referenceId, $sCollectionSubKey, $targetEnvironment);
    }

    /**
     * For sending additional Notification to an End User
     *
     * @param string $referenceId
     * @param string $notificationMessage
     * @return RequestToPayDeliveryNotification
     *
     */
    public static function requestToPayDeliveryNotification($referenceId, $notificationMessage, $sCollectionSubKey, $targetEnvironment)
    {
        return new RequestToPayDeliveryNotification($referenceId, $notificationMessage, $sCollectionSubKey, $targetEnvironment);
    }

    /**
     * For getting information about the user
     * @param string $accountHolderMSISDN, $sCollectionSubKey, $targetEnvironment
     * @return GetBasicUserInfo
     *
     */
    public static function getBasicUserinfo($accountHolderMSISDN, $sCollectionSubKey, $targetEnvironment)
    {
        return new GetBasicUserInfo($accountHolderMSISDN, $sCollectionSubKey, $targetEnvironment);
    }
}
