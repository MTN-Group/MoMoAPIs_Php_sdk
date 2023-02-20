<?php

namespace momopsdk\Collection\Process;

use momopsdk\Common\Utils\GUID;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
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
     * Authentication token
     *
     * @var AuthToken
     */
    private $bearerAuth;

    /**
     * Initiates a Request To Pay.
     *
     * @param string $transaction
     * @return this
     */
    public function __construct($transaction, $callBackUrl = null)
    {
        $this->setUp(self::ASYNCHRONOUS_PROCESS, $callBackUrl);
        $this->transaction = $transaction;
        return $this;
    }

    /**
     * Creates bearer authorization header.
     *
     * @return this
     */
    public function getBearerAuth()
    {
        $env = parse_ini_file(__DIR__ . './../../../config.env');
        $accessToken = $env['access_token'];
        $this->bearerAuth = "Bearer " . $accessToken;
        return $this->bearerAuth;
    }

    /**
     *
     * @return CallbackResponse
     */
    public function execute()
    {
        $auth = $this->getBearerAuth();
        $referenceId = GUID::create();
        $env = parse_ini_file(__DIR__ . './../../../config.env');
        $request = RequestUtil::post(
            API::REQUEST_TO_WITHDRAW_V1,
            json_encode($this->transaction)
        )
            ->httpHeader(Header::AUTHORIZATION, $auth)
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, "sandbox")
            ->httpHeader(Header::SUBSCRIPTION_KEY, $env['collection_subscription_key'])
            ->httpHeader(Header::CONTENT_TYPE, "application/json")
            ->setReferenceId($referenceId)
            ->build();

        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new CallbackResponse());
    }
}
