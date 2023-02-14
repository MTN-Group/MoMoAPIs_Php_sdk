<?php

namespace momopsdk\Collection\Process;

use momopsdk\Common\Models\Response;
use momopsdk\Common\Utils\RequestUtil;

use momopsdk\Common\Constants\Header;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Models\CallbackResponse;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Collection\Models\Transaction;

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
        $this->setUp(self::ASYNCHRONOUS_PROCESS);
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
        $env = parse_ini_file(__DIR__ . './../../../config.env.example');
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
        $env = parse_ini_file(__DIR__ . './../../../config.env.example');
        $request = RequestUtil::post(
            API::REQUEST_TO_PAY,
            json_encode($this->transaction)
        )
            ->httpHeader(Header::AUTHORIZATION, $auth)
            ->httpHeader(Header::X_REFERENCE_ID, $env['reference_id'])
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, "sandbox")
            ->httpHeader(Header::SUBSCRIPTION_KEY, $env['collection_subscription_key'])
            ->httpHeader(Header::CONTENT_TYPE, "application/json")
            ->build();
        $response = $this->makeRequest($request);
        // print_r($response);
        return $this->parseResponse($response, new CallbackResponse());
    }
}
