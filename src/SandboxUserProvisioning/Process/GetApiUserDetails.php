<?php

namespace momopsdk\SandboxUserProvisioning\Process;

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Models\UserDetail;

class GetApiUserDetails extends BaseProcess
{
    /**
     * User reference ID
     */
    private $refId;

    /**
     * Subscription Key
     */
    private $subscriptionKey;

    public function __construct($sSubKey, $sRefId)
    {
        CommonUtil::validateArgument(
            $sRefId,
            'User Reference ID',
            CommonUtil::TYPE_STRING
        );
        $this->subscriptionKey = $sSubKey;
        $this->refId = $sRefId;
        return $this;
    }

    /**
     * Function to execute to call API to get user details
     * @param
     * @return
     */
    public function execute()
    {
        $request = RequestUtil::get(API::GET_USER_INFORMATION)
            ->setUrlParams(['{X-Reference-Id}' => $this->refId])
            ->httpHeader(Header::OCP_APIM_SUBSCRIPTION_KEY, $this->subscriptionKey)
            ->setReferenceId($this->refId)
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new UserDetail());
    }
}
