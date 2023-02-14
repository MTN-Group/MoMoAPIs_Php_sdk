<?php

namespace momopsdk\Collection\Process;

use momopsdk\Common\Utils\GUID;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Models\Response;

use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;

use momopsdk\Collection\Models\Transaction;
use momopsdk\Common\Models\CallbackResponse;

/**
 * Class InitiateRequestToPay
 * @package momopsdk\Collection\Process
 */
class RetrieveRequestToPay extends BaseProcess
{
    /**
     * Authentication token
     *
     * @var AuthToken
     */
    private $bearerAuth;

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
        $env = parse_ini_file(__DIR__ . './../../../config.env.example');
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
        $env = parse_ini_file(__DIR__ . './../../../config.env.example');
        $request = RequestUtil::get(
            API::REQUEST_TO_PAY_STATUS
        )
            ->setUrlParams(['{referenceId}' => $env['reference_id']])
            ->httpHeader(Header::AUTHORIZATION, $auth)
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, "sandbox")
            ->httpHeader(Header::SUBSCRIPTION_KEY, $env['collection_subscription_key'])
            ->build();

        $response = $this->makeRequest($request);
        print_r($response);
        die;
        return $this->parseResponse($response, new Transaction());
    }
}
