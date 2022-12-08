<?php

namespace mmpsdk\Collection;

use mmpsdk\Common\Traits\CommonTrait;

/**
 * Class Collection
 * @package mmpsdk\Collection
 */
class Collection
{
    use CommonTrait;

    /**
     * Initiates a Request to Pay.
     *
     * @param Transaction $transaction
     * @param string $callBackUrl
     * @return InitiateRequestToPay
     */
    public static function requestToPay(
        $transaction,
        $callBackUrl = null
    ) {
        return new \mmpsdk\Collection\Process\InitiateRequestToPay(
            $transaction,
            $callBackUrl
        );
    }

    /**
     * Initiates a Request to Pay.
     *
     * @param Transaction $transaction
     * @param string $callBackUrl
     * @return InitiateRequestToPay
     */
    public static function requestToPayStatus(
        $transaction,
        $callBackUrl = null
    ) {
        return new \mmpsdk\Collection\Process\RetrieveRequestToPay(
            $transaction,
            $callBackUrl
        );
    }
}
