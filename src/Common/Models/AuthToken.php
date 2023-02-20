<?php

namespace momopsdk\Common\Models;

use momopsdk\Common\Models\BaseModel;

/**
 * Class AuthToken
 * @package momopsdk\Common\Models
 */
class AuthToken extends BaseModel
{
    private $authToken;
    private $expiresIn;
    private $createdAt;
    public $tokenIdentifier;

    public function setAuthToken($authToken)
    {
        $this->authToken = $authToken;
        return $this;
    }
    public function getAuthToken()
    {
        return $this->authToken;
    }
    public function setExpiresIn($expiresIn)
    {
        $this->expiresIn = $expiresIn;
        return $this;
    }
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function setTokenIdentifier($tokenIdentifier)
    {
        $this->tokenIdentifier = $tokenIdentifier;
        return $this;
    }
    public function getTokenIdentifier()
    {
        return $this->tokenIdentifier;
    }

    public function jsonSerialize()
    {
        return $this->filterEmpty([
            'authToken' => $this->authToken,
            'expiresIn' => $this->expiresIn,
            'createdAt' => $this->createdAt
        ]);
    }
}
