<?php

namespace momopsdk\SandboxUserProvisioning\Process;

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Models\ResponseState;

class CreateApiUser extends BaseProcess
{
    /**
     * Request body
     */
    protected $aReqBody;

    /**
     * Subscription Key
     */
    private $subscriptionKey;
     

    public function __construct($aReqBody, $sSubKey)
    {
        CommonUtil::validateArgument(
            $aReqBody,
            'callbackHost',
            CommonUtil::TYPE_ARRAY
        );
        $this->setUp(self::ASYNCHRONOUS_PROCESS);
        $this->subscriptionKey = $sSubKey;
        $this->aReqBody = $aReqBody;
        return $this;
    }

    /**
     * Function to execute create user
     * @param
     * @return
     */
    public function execute()
    {
        $request = RequestUtil::post(API::CREATE_USER, json_encode($this->aReqBody))
            ->httpHeader(Header::OCP_APIM_SUBSCRIPTION_KEY, $this->subscriptionKey)
            ->setReferenceId($this->referenceId)
            ->build();

        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new ResponseState());
    }
}
