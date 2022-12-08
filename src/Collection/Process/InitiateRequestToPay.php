<?php

namespace mmpsdk\Collection\Process;

use mmpsdk\Common\Models\Response;
use mmpsdk\Common\Utils\RequestUtil;

use mmpsdk\Common\Constants\Header;
use mmpsdk\Common\Constants\API;
use mmpsdk\Common\Models\CallbackResponse;
use mmpsdk\Common\Process\BaseProcess;

/**
 * Class InitiateRequestToPay
 * @package mmpsdk\AgentService\Process
 */
class InitiateRequestToPay extends BaseProcess
{

    /**
     * Initiates a Request To Pay.
     *
     * @param string $transaction
     * @return this
     */
    public function __construct($transaction = null)
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
        $env = parse_ini_file(__DIR__ . './../../../config.env');
        $request = RequestUtil::post(
            API::REQUEST_TO_PAY,
            json_encode($this->transaction)
        )
            ->httpHeader(Header::AUTHORIZATION, $auth)
            ->httpHeader(Header::X_REFERENCE_ID, $env['reference_payment'])
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, "sandbox")
            ->httpHeader(Header::SUBSCRIPTION_KEY, $env['subscription_key'])
            ->build();
        print_r($request);
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new CallbackResponse());
    }
}
