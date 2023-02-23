<?php

namespace momopsdk\Common\Models;

use momopsdk\Common\Models\BaseModel;

/**
 * Class UserDetail
 * @package momopsdk\Common\Models
 */
class UserDetail extends BaseModel
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
