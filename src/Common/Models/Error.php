<?php

namespace momopsdk\Common\Models;

use momopsdk\Common\Models\BaseModel;

/**
 * Class Error
 * @package mmpsdk\Common\Models
 */
class Error extends BaseModel
{
    private $errorCategory;
    private $errorCode;
    private $errorDescription;
    private $errorDateTime;
    private $errorParameters;

    public function setErrorCategory($errorCategory)
    {
        $this->errorCategory = $errorCategory;
        return $this;
    }
    public function getErrorCategory()
    {
        return $this->errorCategory;
    }
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
        return $this;
    }
    public function getErrorCode()
    {
        return $this->errorCode;
    }
    public function setErrorDescription($errorDescription)
    {
        $this->errorDescription = $errorDescription;
        return $this;
    }
    public function getErrorDescription()
    {
        return $this->errorDescription;
    }
    public function setErrorDateTime($errorDateTime)
    {
        $this->errorDateTime = $errorDateTime;
        return $this;
    }
    public function getErrorDateTime()
    {
        return $this->errorDateTime;
    }
    public function setErrorParameters($errorParameters)
    {
        $this->errorParameters = $errorParameters;
        return $this;
    }
    public function getErrorParameters()
    {
        return $this->errorParameters;
    }

    public function jsonSerialize()
    {
        return $this->filterEmpty([
            'errorCategory' => $this->errorCategory,
            'errorCode' => $this->errorCode,
            'errorDescription' => $this->errorDescription,
            'errorDateTime' => $this->errorDateTime,
            'errorParameters' => $this->errorParameters
        ]);
    }
}
