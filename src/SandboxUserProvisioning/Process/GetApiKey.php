<?php

namespace momopsdk\SandboxUserProvisioning\Process;

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Models\UserDetail;

class GetApiKey extends BaseProcess
{
    /**
     * User reference ID
     */
    private $refId;

    /**
     * Subscription Key
     */
    private $subscriptionKey;

    public function __construct($sSubsKey, $sReferenceId)
    {
        CommonUtil::validateArgument(
            $sReferenceId,
            'User Reference ID',
            CommonUtil::TYPE_STRING
        );
        $this->subscriptionKey = $sSubsKey;
        $this->refId = $sReferenceId;
        return $this;
    }

    /**
     * Function to execute the API for API key generation
     * @param
     * @return
     */
    public function execute()
    {
        $request = RequestUtil::post(API::GET_API_KEY)
            ->setUrlParams(['{X-Reference-Id}' => $this->refId])
            ->httpHeader(Header::OCP_APIM_SUBSCRIPTION_KEY, $this->subscriptionKey)
            ->setReferenceId($this->refId)
            ->build();
        $response = $this->makeRequest($request);
        
        return $this->parseResponse($response, new UserDetail());
    }
}
