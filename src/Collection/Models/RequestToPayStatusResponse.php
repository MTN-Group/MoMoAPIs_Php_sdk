<?php

namespace momopsdk\Collection\Models;

use momopsdk\Common\Models\BaseModel;

/**
 * Class RequestToPayStatusResponse
 * @package momopsdk\Common\Models
 */
class RequestToPayStatusResponse extends BaseModel
{

    /**
     * @var array
     */
    public $result;

    // /**
    //  * @var string
    //  */
    // public $referenceId;

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
