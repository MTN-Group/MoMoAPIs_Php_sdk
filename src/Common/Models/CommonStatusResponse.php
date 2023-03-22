<?php

namespace momopsdk\Common\Models;

use momopsdk\Common\Models\BaseModel;

/**
 * Class StatusResponse
 * @package momopsdk\Collection\Models
 */
class CommonStatusResponse extends BaseModel
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
}
