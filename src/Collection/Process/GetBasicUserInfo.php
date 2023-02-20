<?php

namespace momopsdk\Collection\Process;

use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\CallbackResponse;

/**
 * Class GetBasicUserInfo
 * @package momopsdk\Collection\Process
 */
class GetBasicUserInfo extends BaseProcess
{
    /**
     * Authentication token
     */
    private $bearerAuth;

    /**
     * Notification Message
     */
    private $msisdn;

    /**
     * Send notification message for a payment request
     *
     * @param string $notificationMessage
     * @param string $referenceId
     * @return this
     */
    public function __construct($accountHolderMSISDN)
    {
        CommonUtil::validateArgument(
            $accountHolderMSISDN,
            'accountHolderMSISDN',
            CommonUtil::TYPE_STRING
        );
        $this->msisdn = $accountHolderMSISDN;
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
     * Function to execute sending of additional Notification to an End User
     * @return CallbackResponse
     */
    public function execute()
    {
        $auth = $this->getBearerAuth();
        $env = parse_ini_file(__DIR__ . './../../../config.env');
        $request = RequestUtil::get(API::GET_BASIC_USER_INFO)
            ->setUrlParams([
                '{accountHolderMSISDN}' => $this->msisdn
            ])
            ->httpHeader(Header::AUTHORIZATION, $auth)
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, "sandbox")
            ->httpHeader(Header::SUBSCRIPTION_KEY, $env['collection_subscription_key'])
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new CallbackResponse());
    }
}
