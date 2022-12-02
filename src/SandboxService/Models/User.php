<?php

namespace mmpsdk\SandBoxService\Models;

use mmpsdk\Common\Models\BaseModel;
use mmpsdk\Common\Utils\CommonUtil;

class User extends BaseModel
{

    /**
     * @var string
     */
    private $providerCallbackHost;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    protected $apiKey;


    /**
     * @return string|null
     */
    public function getProviderCallbackHost()
    {
        return $this->providerCallbackHost;
    }

    /**
     * @param string|null $providerCallbackHost
     *
     * @return User
     */
    public function setProviderCallbackHost($providerCallbackHost)
    {
        $this->providerCallbackHost = $providerCallbackHost;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string|null $apikey
     *
     * @return User
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function jsonSerialize()
    {
        return $this->filterEmpty([
            'providerCallbackHost' => $this->providerCallbackHost,
            'apiKey' => $this->apiKey,
        ]);
    }

    public function hydratorStrategies()
    {
        // $this->addHydratorStrategy(
        //     'identity',
        //     new \mmpsdk\AgentService\Models\Identity()
        // );
        // $this->addHydratorStrategy(
        //     'commissionEarned',
        //     new \mmpsdk\AgentService\Models\Commission()
        // );
        // $this->addHydratorStrategy(
        //     'fees', 
        //     new \mmpsdk\Common\Models\Fees()
        // );
    }
}
