<?php

namespace momopsdk\Common\Models;

use momopsdk\Common\Models\BaseModel;

/**
 * Class GetAccBalance
 * @package momopsdk\Disbursement\Models
 */
class TransferResponseModel extends BaseModel
{
    /**
     * Result
     */
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