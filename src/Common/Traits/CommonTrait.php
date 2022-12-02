<?php

namespace mmpsdk\Common\Traits;

trait CommonTrait
{
    /**
     * Retrieves the state of a request for a given Server Correlation Id.
     *
     * @param string $serverCorrelationId
     * @return PollRequest
     */
    public static function viewRequestState($serverCorrelationId)
    {
        return new \mmpsdk\Common\Process\PollRequest($serverCorrelationId);
    }

    /**
     * Retrieves a representation of the resource assuming that it exists.
     *
     * @param string $clientCorrelationId
     * @param Object $objRef
     * @return RetrieveMissingResponse
     */
    public static function viewResponse($clientCorrelationId, $objRef = null)
    {
        return new \mmpsdk\Common\Process\RetrieveMissingResponse(
            $clientCorrelationId,
            $objRef
        );
    }

    /**
     * To determine the availability of the service from the API provider.
     *
     * @return ServiceAvailability
     */
    public static function viewServiceAvailability()
    {
        return new \mmpsdk\Common\Process\ServiceAvailability();
    }

    /**
     * Retrieve transaction object using reference id
     *
     * @param array $transactionReference
     * @param object $ObjRef
     * @return RetrieveTransaction
     */
    public static function viewTransaction($transactionReference)
    {
        return new \mmpsdk\Common\Process\RetrieveTransaction(
            $transactionReference
        );
    }
}
