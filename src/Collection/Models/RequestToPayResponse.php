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
    public $referenceId;

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
    public function setReferenceId($referenceId)
    {
        $this->referenceId = $referenceId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReferenceId()
    {
        return $this->referenceId;
    }
}
