<?php

namespace momopsdk\Collection\Process;


use momopsdk\Common\Utils\GUID;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Collection\Models\Transaction;
use momopsdk\Collection\Models\RequestToPayResponse;

/**
 * Class InitiateRequestToPay
 * @package momopsdk\Collection\Process
 */
class InitiateRequestToPay extends BaseProcess
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
     * Initiates a Request To Pay.
     *
     * @param string $transaction
     * @return this
     */
    public function __construct($transaction, $sCollectionSubKey, $targetEnvironment, $callBackUrl = null)
    {
        CommonUtil::validateArgument(
            $sCollectionSubKey,
            'CollectionSubKey',
            CommonUtil::TYPE_STRING
        );
        // $this->setUp(self::ASYNCHRONOUS_PROCESS, $callBackUrl);
        $this->transaction = $transaction;
        $this->subKey = $sCollectionSubKey;
        $this->targetEnv = $targetEnvironment;
        return $this;
    }

    /**
     *
     * @return RequestToPayResponse
     */
    public function execute()
    {
        $referenceId = GUID::create();
        $request = RequestUtil::post(API::REQUEST_TO_PAY, json_encode($this->transaction))
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnv)
            ->httpHeader(Header::SUBSCRIPTION_KEY, $this->subKey)
            ->setReferenceId($referenceId)
            ->setSubscriptionKey($this->subKey)
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new RequestToPayResponse());
    }
}
