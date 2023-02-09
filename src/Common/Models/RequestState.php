<?php

namespace momopsdk\Common\Models;

use momopsdk\Common\Models\BaseModel;

/**
 * Class RequestState
 * @package momopsdk\Common\Models
 */
class RequestState extends BaseModel
{
    /**
     * A unique identifier issued by the provider to enable the client to identify the RequestState resource on subsequent polling requests.
     * @var string
     */
    private $serverCorrelationId;

    /**
     * A unique identifier issued by the provider to enable the client to identify the RequestState resource on subsequent polling requests.
     * @var string
     */
    private $clientCorrelationId;

    /**
     * Provides a reference to the subject resource
     * @var string
     */
    private $objectReference;

    /**
     * Indicates the status of the request.
     * @var string
     */
    private $status;

    /**
     * Indicates whether a callback will be issued or whether the client will need to poll.
     * @var string
     */
    private $notificationMethod;

    /**
     * A textual description that can be provided to describe the reason for a pending status.
     * @var string
     */
    private $pendingReason;

    /**
     * Indicates the time by which the provider will fail the request if completion criteria have not been met.
     * @var string
     */
    private $expiryTime;

    /**
     * Indicates the number of poll attempts for the given requeststate resource that will be allowed by the provider.
     * @var Int
     */
    private $pollLimit;

    /**
     * If the asynchronous Processing failed, details of the error will be returned here.
     * @var mixed
     */
    private $errorReference;

    /**
     * @param string $serverCorrelationId
     */
    public function setServerCorrelationId($serverCorrelationId)
    {
        $this->serverCorrelationId = $serverCorrelationId;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientCorrelationId()
    {
        return $this->clientCorrelationId;
    }

    /**
     * @param string $clientCorrelationId
     */
    public function setClientCorrelationId($clientCorrelationId)
    {
        $this->clientCorrelationId = $clientCorrelationId;
        return $this;
    }

    /**
     * @return string
     */
    public function getServerCorrelationId()
    {
        return $this->serverCorrelationId;
    }

    /**
     * @param string $objectReference
     */
    public function setObjectReference($objectReference)
    {
        $this->objectReference = $objectReference;
        return $this;
    }

    /**
     * @return string
     */
    public function getObjectReference()
    {
        return $this->objectReference;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $notificationMethod
     */
    public function setNotificationMethod($notificationMethod)
    {
        $this->notificationMethod = $notificationMethod;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotificationMethod()
    {
        return $this->notificationMethod;
    }

    /**
     * @param string $pendingReason
     */
    public function setPendingReason($pendingReason)
    {
        $this->pendingReason = $pendingReason;
        return $this;
    }

    /**
     * @return string
     */
    public function getPendingReason()
    {
        return $this->pendingReason;
    }

    /**
     * @param string $expiryTime
     */
    public function setExpiryTime($expiryTime)
    {
        $this->expiryTime = $expiryTime;
        return $this;
    }

    /**
     * @return string
     */
    public function getExpiryTime()
    {
        return $this->expiryTime;
    }

    /**
     * @param Int $pollLimit
     */
    public function setPollLimit($pollLimit)
    {
        $this->pollLimit = $pollLimit;
        return $this;
    }

    /**
     * @return Int
     */
    public function getPollLimit()
    {
        return $this->pollLimit;
    }

    /**
     * @param mixed $errorReference
     */
    public function setErrorReference($errorReference)
    {
        $this->errorReference = $errorReference;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getErrorReference()
    {
        return $this->errorReference;
    }
}
