<?php

namespace momopsdk\Collection\Models;

use momopsdk\Common\Models\BaseModel;

/**
 * Class RequestToPayResponse
 * @package momopsdk\Common\Models
 */
class RequestToPayResponse extends BaseModel
{

    /**
     * @var string
     */
    public $httpCode;

    /**
     * @var string
     */
    public $result;

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
     * @param string|null $httpCode
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getResult()
    {
        return $this->result;
    }
}
