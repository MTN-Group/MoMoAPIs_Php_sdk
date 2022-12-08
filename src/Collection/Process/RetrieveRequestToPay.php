<?php

namespace mmpsdk\Collection\Process;

use mmpsdk\Common\Models\Response;
use mmpsdk\Common\Utils\RequestUtil;

use mmpsdk\Common\Constants\Header;
use mmpsdk\Common\Constants\API;
use mmpsdk\Common\Models\CallbackResponse;
use mmpsdk\Common\Process\BaseProcess;

use mmpsdk\Collection\Models\Transaction;
/**
 * Class RetrieveRequestToPay
 * @package mmpsdk\AgentService\Process
 */
class RetrieveRequestToPay extends BaseProcess
{

    /**
     * Initiates a Request To Pay.
     *
     * @param string $transactionReference
     * @return this
     */
    public function __construct()
    {
        $this->setUp(self::SYNCHRONOUS_PROCESS);
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
     * @return Transaction
     */
    public function execute()
    {
        $auth = $this->getBearerAuth();
        $env = parse_ini_file(__DIR__ . './../../../config.env');
        $request = RequestUtil::get(
            API::REQUEST_TO_PAY_STATUS,
        )
            ->setUrlParams(['{referenceId}' => $env['reference_payment']])
            ->httpHeader(Header::AUTHORIZATION, $auth)
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, "sandbox")
            ->httpHeader(Header::SUBSCRIPTION_KEY, $env['subscription_key'])
            ->build();
        print_r($request);
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new Transaction());
    }
}
