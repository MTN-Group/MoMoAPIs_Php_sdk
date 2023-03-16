<?php

namespace momopsdk\Common\Models;

use momopsdk\Common\Models\BaseModel;

/**
 * Class GetAccBalance
 * @package momopsdk\Disbursement\Models
 */
class TransferStatusDetail extends BaseModel
{
    /**
     * Reference Id
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