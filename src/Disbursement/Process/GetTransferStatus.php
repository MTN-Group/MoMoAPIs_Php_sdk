<?php

namespace momopsdk\Disbursement\Process;

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Disbursement\Models\StatusDetail;

class GetTransferStatus extends BaseProcess
{
    /**
     * Subscription Key
     */
    private $subscriptionKey;

    /**
     * Target Environment
     */
    private $targetEnvironment;
    
    /**
     * Reference Id
     */
    private $refId;

    public function __construct($sSubsKey, $sTargetEnvironment, $sReferenceId)
    {
        CommonUtil::validateArgument(
            $sSubsKey,
            'Subscription Key',
            CommonUtil::TYPE_STRING
        );
        CommonUtil::validateArgument(
            $sReferenceId,
            'Reference Id',
            CommonUtil::TYPE_STRING
        );
        $this->subscriptionKey = $sSubsKey;
        $this->targetEnvironment = $sTargetEnvironment;
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
        $request = RequestUtil::get(API::GET_TRANSFER_STATUS)
            ->setUrlParams(['{referenceId}' => $this->refId])
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnvironment)
            ->httpHeader(Header::OCP_APIM_SUBSCRIPTION_KEY, $this->subscriptionKey)
            ->setSubscriptionKey($this->subscriptionKey)
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new StatusDetail());
    }
}
