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
     * @param string $callBackUrl
     * @return InitiateRequestToPay
     */
    public static function requestToPay($transaction, $callBackUrl = null)
    {
        return new InitiateRequestToPay($transaction, $callBackUrl);
    }

    /**
     * Get request to pay status.
     *
     * @param ReferenceID $referenceId
     * @return RetrieveRequestToPay
     *
     */
    public static function requestToPayTransactionStatus($referenceId)
    {
        return new RetrieveRequestToPay($referenceId);
    }

    /**
     * For validating account holder status
     *
     * @param string $accountHolderId
     * @param string $accountHolderIdType
     * @return ValidateAccountHolder
     *
     */
    public static function validateAccountHolderStatus($accountHolderId, $accountHolderIdType)
    {
        return new ValidateAccountHolder($accountHolderId, $accountHolderIdType);
    }

    /**
     * For getting the account balance
     *
     * @return GetAccountBalance
     *
     */
    public static function getAccountBalance()
    {
        return new GetAccountBalance($callBackUrl = null);
    }

    /**
     * For requesting to withdraw from a consumer account
     * Asynchronous payment flow is used with a final callback.
     *
     * @param Transaction $transaction
     * @param string $callBackUrl
     * @return RequestToWithdrawV1
     *
     */
    public static function requestToWithdrawV1($transaction, $callBackUrl = null)
    {
        return new RequestToWithdrawV1($transaction, $callBackUrl = null);
    }

    /**
     * For requesting to withdraw from a consumer account
     * Asynchronous payment flow is used with a final callback.
     *
     * @param Transaction $transaction
     * @param string $callBackUrl
     * @return RequestToWithdrawV2
     *
     */
    public static function requestToWithdrawV2($transaction, $callBackUrl = null)
    {
        return new RequestToWithdrawV2($transaction, $callBackUrl = null);
    }

    /**
     * For getting status of withdrawel request
     * @param string $referenceId
     * @return RequestToWithdrawStatus
     *
     */
    public static function requestToWithdrawTransactionStatus($referenceId)
    {
        return new RequestToWithdrawStatus($referenceId);
    }

    /**
     * For sending additional Notification to an End User
     *
     * @param string $referenceId
     * @param string $notificationMessage
     * @return RequestToPayDeliveryNotification
     *
     */
    public static function requestToPayDeliveryNotification($referenceId, $notificationMessage)
    {
        return new RequestToPayDeliveryNotification($referenceId, $notificationMessage);
    }

    /**
     * For getting information about the user
     * @param string $accountHolderMSISDN
     * @return GetBasicUserInfo
     *
     */
    public static function getBasicUserinfo($accountHolderMSISDN)
    {
        return new GetBasicUserInfo($accountHolderMSISDN);
    }
}
