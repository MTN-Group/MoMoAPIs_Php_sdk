<?php

namespace mmpsdk\Common\Models;

use mmpsdk\Common\Models\BaseModel;

/**
 * Class Response
 * @package mmpsdk\Common\Models
 */
class Response extends BaseModel
{
    /**
     * @var array
     */
    private $result;

    /**
     * @var array
     */
    private $info;

    /**
     * @var string
     */
    private $httpCode;

    /**
     * @var string
     */
    private $error;

    /**
     * @var string
     */
    private $errorCode;

    /**
     * @var string
     */
    private $clientCorrelationId;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var array
     */
    private $requestObj;

    /**
     * @return array|null
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param array|null $result
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param array|null $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * @param string|null $httpCode
     */
    public function setHttpCode($httpCode)
    {
        $this->httpCode = $httpCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string|null $error
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param string|null $errorCode
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getClientCorrelationId()
    {
        return $this->clientCorrelationId;
    }

    /**
     * @param string|null $clientCorrelationId
     */
    public function setClientCorrelationId($clientCorrelationId)
    {
        $this->clientCorrelationId = $clientCorrelationId;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array|null $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getRequestObj()
    {
        return $this->requestObj;
    }

    /**
     * @param array|null $requestObj
     */
    public function setRequestObj($requestObj)
    {
        $this->requestObj = $requestObj;
        return $this;
    }
}
