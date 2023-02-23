<?php

namespace momopsdk\Collection\Process;

use momopsdk\Collection\Models\StatusResponse;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;

/**
 * Class GetAccountBalance
 * @package momopsdk\Collection\Process
 */
class RequestToWithdrawStatus extends BaseProcess
{
    /**
     * Collection subscription key
     */
    private $subKey;

    /**
     * Target environment
     */
    private $targetEnv;

    /**
     * Authentication token
     */
    private $refId;

    /**
     * Get the transaction request status.
     *
     * @param string $referenceId
     * @return this
     */
    public function __construct($referenceId, $sCollectionSubKey, $targetEnvironment)
    {
        CommonUtil::validateArgument(
            $referenceId,
            'User Reference ID',
            CommonUtil::TYPE_STRING
        );
        $this->refId = $referenceId;
        $this->subKey = $sCollectionSubKey;
        $this->targetEnv = $targetEnvironment;
        return $this;
    }

    /**
     * Function  used to get the status of a request to withdraw.
     * @return CallbackResponse
     */
    public function execute()
    {
        $request = RequestUtil::get(API::REQUEST_TO_WITHDRAW_STATUS)
            ->setUrlParams(['{referenceId}' => $this->refId])
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnv)
            ->httpHeader(Header::OCP_APIM_SUBSCRIPTION_KEY, $this->subKey)
            ->setSubscriptionKey($this->subKey)
            ->setReferenceId($this->refId)
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new StatusResponse());
    }
}
