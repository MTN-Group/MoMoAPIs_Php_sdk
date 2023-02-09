<?php

namespace momopsdk\SandboxUserProvisioning\Process;

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;

class CreateApiUser extends BaseProcess
{
    /**
     * Request body
     */
    private $aReqBody;

    public function __construct($aReqBody)
    {
        CommonUtil::validateArgument(
            $aReqBody,
            'callbackHost',
            CommonUtil::TYPE_ARRAY
        );
        $this->setUp(self::ASYNCHRONOUS_PROCESS);
        return $this;
    }

    /**
     * Function to execute create user
     * @param
     * @return
     */
    public function execute()
    {
        $request = RequestUtil::post(API::CREATE_USER, json_encode($aReqBody))
            ->httpHeader(Header::OCP_APIM_SUBSCRIPTION_KEY)
            ->setReferenceId($this->referenceId)
            ->build();

        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new RequestState());
    }
}
