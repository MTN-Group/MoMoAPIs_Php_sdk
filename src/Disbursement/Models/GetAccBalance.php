<?php

namespace momopsdk\Disbursement\Models;

use momopsdk\Common\Models\BaseModel;

/**
 * Class RequestState
 * @package momopsdk\Disbursement\Models
 */
class GetAccBalance extends BaseModel
{
    /**
     * Reference Id
     */
    public $result;


    public function getResult()
    {
        return $this->referenceId;
    }

    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }
}