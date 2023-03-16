<?php

namespace momopsdk\Collection\Process;

use momopsdk\Collection\Models\RequestToWithdraw;
use momopsdk\Common\Utils\GUID;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\CallbackResponse;

/**
 * Class RequestToWithdrawV1
 * @package momopsdk\Collection\Process
 */
class RequestToWithdrawV1 extends BaseProcess
{
    /**
     * Transaction object
     *
     * @var Transaction
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
     * Initiates a Request To withdraw.
     *
     * @param Transaction $transaction
     * @param string $sCollectionSubKey, $targetEnvironment
     * @return this
     */
    public function __construct($oTransaction, $sCollectionSubKey, $sTargetEnvironment, $sCallbackUrl, $sContentType)
    {
        CommonUtil::validateArgument(
            $sCollectionSubKey,
            'CollectionSubKey',
            CommonUtil::TYPE_STRING
        );
        CommonUtil::validateArgument(
            $oTransaction,
            'Transaction',
            CommonUtil::TYPE_OBJECT
        );
        $this->setUp(self::ASYNCHRONOUS_PROCESS, $sCallbackUrl);
        $this->transaction = $oTransaction;
        $this->subKey = $sCollectionSubKey;
        $this->targetEnv = $sTargetEnvironment;
        $this->contentType = $sContentType;
        return $this;
    }

    /**
     * This operation is used to request a withdrawal(cash-out) from a consumer (Payer).
     * @return RequestToWithdraw
     */
    public function execute()
    {
        $request = RequestUtil::post(API::REQUEST_TO_WITHDRAW_V1, json_encode($this->transaction))
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
        return $this->parseResponse($response, new RequestToWithdraw());
    }
}
