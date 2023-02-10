<?php

namespace momopsdk\Common\Models;

use momopsdk\Common\Models\BaseModel;

/**
 * Class RequestState
 * @package momopsdk\Common\Models
 */
class ResponseState extends BaseModel
{
    /**
     * Reference Id
     */
    public $referenceId;


    public function getReferenceId()
    {
        return $this->referenceId;
    }

    public function setReferenceId($referenceId)
    {
        $this->referenceId = $referenceId;
        return $this;
    }
}