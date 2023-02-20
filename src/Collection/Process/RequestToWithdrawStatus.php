<?php

namespace momopsdk\Collection\Process;

use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\CallbackResponse;

/**
 * Class GetAccountBalance
 * @package momopsdk\Collection\Process
 */
class RequestToWithdrawStatus extends BaseProcess
{
    /**
     * Authentication token
     */
    private $bearerAuth;

    /**
     * Authentication token
     */
    private $refId;

    /**
     * Get the transaction request status.
     *
     * @param string $referenceId
     * @return this
     */
    public function __construct($referenceId)
    {
        CommonUtil::validateArgument(
            $referenceId,
            'User Reference ID',
            CommonUtil::TYPE_STRING
        );
        $this->setUp(self::SYNCHRONOUS_PROCESS);
        $this->refId = $referenceId;
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
     * Function to execute API call to get the account balance
     * @return CallbackResponse
     */
    public function execute()
    {
        $auth = $this->getBearerAuth();
        $env = parse_ini_file(__DIR__ . './../../../config.env');
        $request = RequestUtil::get(API::REQUEST_TO_WITHDRAW_STATUS)
            ->setUrlParams(['{referenceId}' => $this->refId])
            ->httpHeader(Header::AUTHORIZATION, $auth)
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, "sandbox")
            ->httpHeader(Header::SUBSCRIPTION_KEY, $env['collection_subscription_key'])
            ->setReferenceId($this->refId)
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new CallbackResponse());
    }
}
