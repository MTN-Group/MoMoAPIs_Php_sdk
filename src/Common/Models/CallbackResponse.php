<?php

namespace momopsdk\Common\Models;

use momopsdk\Common\Models\BaseModel;

/**
 * Class CallbackResponse
 * @package momopsdk\Common\Models
 */
class CallbackResponse extends BaseModel
{
    /**
     * @var array
     */
    public $result;

    /**
     * @var string
     */
    public $httpCode;

    /**
     * @var string
     */
    // public $referenceId;


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

    // /**
    //  * @param string|null $httpCode
    //  */
    // public function setReferenceId($referenceId)
    // {
    //     $this->referenceId = $referenceId;
    //     return $this;
    // }

    // /**
    //  * @return string|null
    //  */
    // public function getReferenceId()
    // {
    //     return $this->referenceId;
    // }
}
