<?php

namespace momopsdk\Collection\Process;

use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Collection\Models\RequestToPayStatusResponse;

/**
 * Class RetrieveRequestToPay
 *
 * @package momopsdk\Collection\Process
 */
class RetrieveRequestToPay extends BaseProcess
{
    /**
     * Collection subscription key
     */
    private $subKey;

    /**
     * Reference Id
     */
    private $refId;

    /**
     * Target Environment
     */
    private $targetEnv;

    /**
     * Get the transaction request status.
     *
     * @param  string $sReferenceId, $sCollectionSubKey, $sTargetEnvironment
     * @return this
     */
    public function __construct($sReferenceId, $sCollectionSubKey, $sTargetEnvironment)
    {
        CommonUtil::validateArgument(
            $sReferenceId,
            'User Reference ID',
            CommonUtil::TYPE_STRING
        );
        CommonUtil::validateArgument(
            $sCollectionSubKey,
            'Subscription Key',
            CommonUtil::TYPE_STRING
        );
        $this->setUp(self::SYNCHRONOUS_PROCESS);
        $this->refId = $sReferenceId;
        $this->subKey = $sCollectionSubKey;
        $this->targetEnv = $sTargetEnvironment;
        return $this;
    }


    /**
     * Function to execute API call to get payment status
     *
     * @return RequestToPayStatusResponse
     */
    public function execute()
    {
        $request = RequestUtil::get(API::REQUEST_TO_PAY_STATUS)
            ->setUrlParams(['{X-Reference-Id}' => $this->refId])
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnv)
            ->httpHeader(Header::OCP_APIM_SUBSCRIPTION_KEY, $this->subKey)
            ->setReferenceId($this->refId)
            ->setSubscriptionKey($this->subKey)
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new RequestToPayStatusResponse());
    }
}
