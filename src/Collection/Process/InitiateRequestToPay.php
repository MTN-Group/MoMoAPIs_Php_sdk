<?php

namespace momopsdk\Collection\Process;

use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Collection\Models\RequestToPayResponse;

/**
 * Class InitiateRequestToPay
 * @package momopsdk\Collection\Process
 */
class InitiateRequestToPay extends BaseProcess
{
    /**
     * Transaction object
     */
    private $transaction;

    /**
     * Collection subscription key
     */
    private $subKey;

    /**
     * Target environment
     */
    private $targetEnv;

    /**
     * Content type
     */
    private $contentType;

    /**
     * Initiates a Request To Pay.
     *
     * @param string $transaction
     * @return this
     */
    public function __construct($oTransaction, $sCollectionSubKey, $sTargetEnvironment, $sCallBackUrl, $sContentType)
    {
        CommonUtil::validateArgument(
            $sCollectionSubKey,
            'CollectionSubscriptionKey',
            CommonUtil::TYPE_STRING
        );
        CommonUtil::validateArgument(
            $oTransaction,
            'Transaction',
            CommonUtil::TYPE_OBJECT
        );
        $this->setUp(self::ASYNCHRONOUS_PROCESS, $sCallBackUrl);
        $this->transaction = $oTransaction;
        $this->subKey = $sCollectionSubKey;
        $this->targetEnv = $sTargetEnvironment;
        $this->contentType = $sContentType;
        return $this;
    }

    /**
     *
     * @return RequestToPayResponse
     */
    public function execute()
    {
        $request = RequestUtil::post(API::REQUEST_TO_PAY, json_encode($this->transaction))
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnv)
            ->httpHeader(Header::OCP_APIM_SUBSCRIPTION_KEY, $this->subKey)
            ->setReferenceId($this->referenceId)
            ->setSubscriptionKey($this->subKey);
        if ($this->callBackUrl != null) {
            $request = $request->httpHeader(Header::X_CALLBACK_URL, $this->callBackUrl);
        }
        if ($this->contentType != null) {
            $request = $request->httpHeader(Header::CONTENT_TYPE, $this->contentType);
        }
        $request = $request->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new RequestToPayResponse());
    }
}
