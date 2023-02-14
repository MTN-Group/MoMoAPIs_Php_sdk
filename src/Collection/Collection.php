<?php

namespace momopsdk\Collection;

use momopsdk\Collection\Process\InitiateRequestToPay;
use momopsdk\Collection\Models\Transaction;

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
    public static function requestToPay(
        $transaction,
        $callBackUrl = null
    ) {
        return new InitiateRequestToPay($transaction, $callBackUrl);
    }

    /**
     * Get request to pay status.
     *
     * @param Transaction $transaction
     * @param string $callBackUrl
     * @return RetrieveRequestToPay
     */
    public static function requestToPayStatus(
        $transaction,
        $callBackUrl = null
    ) {
        return new \momopsdk\Collection\Process\RetrieveRequestToPay(
            $transaction,
            $callBackUrl
        );
    }
}
