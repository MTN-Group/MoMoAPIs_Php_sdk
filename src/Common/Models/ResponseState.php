<?php

namespace momopsdk\Common\Models;

use momopsdk\Common\Models\BaseModel;

/**
 * Class RequestState
 * @package momopsdk\Common\Models
 */
class ResponseState extends BaseModel
{
    
    public $result;

    public function getResult()
    {
        return $this->result;
    }

    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }
}