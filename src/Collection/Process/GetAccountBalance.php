<?php

namespace momopsdk\Collection\Process;

use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\CallbackResponse;

/**
 * Class GetAccountBalance
 * @package momopsdk\Collection\Process
 */
class GetAccountBalance extends BaseProcess
{
    /**
     * Authentication token
     */
    private $bearerAuth;

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
     * Function to execute API call to get the account balance
     * @return CallbackResponse
     */
    public function execute()
    {
        $auth = $this->getBearerAuth();
        $env = parse_ini_file(__DIR__ . './../../../config.env');
        $request = RequestUtil::get(API::GET_ACCOUNT_BALANCE)
            ->httpHeader(Header::AUTHORIZATION, $auth)
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, "sandbox")
            ->httpHeader(Header::SUBSCRIPTION_KEY, $env['collection_subscription_key'])
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new CallbackResponse());
    }
}
