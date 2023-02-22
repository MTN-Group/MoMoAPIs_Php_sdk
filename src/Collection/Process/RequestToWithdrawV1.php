<?php

namespace momopsdk\Collection\Process;

use momopsdk\Collection\Models\RequestToPayResponse;
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
     * Initiates a Request To withdraw.
     *
     * @param Transaction $transaction
     * @param string $sCollectionSubKey, $targetEnvironment
     * @return this
     */
    public function __construct($transaction, $sCollectionSubKey, $targetEnvironment)
    {
        CommonUtil::validateArgument(
            $sCollectionSubKey,
            'CollectionSubKey',
            CommonUtil::TYPE_STRING
        );
        $this->transaction = $transaction;
        $this->subKey = $sCollectionSubKey;
        $this->targetEnv = $targetEnvironment;
        return $this;
    }

    /**
     * This operation is used to request a withdrawal(cash-out) from a consumer (Payer).
     * @return RequestToPayResponse
     */
    public function execute()
    {
        $referenceId = GUID::create();
        $request = RequestUtil::post(API::REQUEST_TO_WITHDRAW_V1, json_encode($this->transaction))
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnv)
            ->httpHeader(Header::SUBSCRIPTION_KEY, $this->subKey)
            ->setReferenceId($referenceId)
            ->setSubscriptionKey($this->subKey)
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new RequestToPayResponse());
    }
}
