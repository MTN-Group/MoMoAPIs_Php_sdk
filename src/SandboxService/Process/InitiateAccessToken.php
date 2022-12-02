<?php

namespace mmpsdk\SandboxService\Process;

use mmpsdk\SandboxService\Models\User;
use mmpsdk\Common\Models\Response;
use mmpsdk\Common\Utils\RequestUtil;

use mmpsdk\Common\Utils\CommonUtil;
use mmpsdk\Common\Constants\Header;
use mmpsdk\Common\Constants\API;
use mmpsdk\Common\Process\BaseProcess;

/**
 * Class InitiateApiKey
 * @package mmpsdk\AgentService\Process
 */
class InitiateAccessToken extends BaseProcess
{

    /**
     * Initiates an API key request.
     * Asynchronous payment flow is used with a final callback.
     *
     * @param string $user
     * @return this
     */
    public function __construct($user = null)
    {
        $this->setUp(self::SYNCHRONOUS_PROCESS);
        $this->user = $user;
        return $this;
    }

    /**
     * Creates basic b64 authorization header.
     * Asynchronous payment flow is used with a final callback.
     *
     * @return this
     */
    public function getBasicAuth()
    {
        $env = parse_ini_file(__DIR__ . './../../../config.env');
        $authString = $env['reference_id'] . ":" . $env['momo_api_key'];
        $this->basicAuth = "Basic " . base64_encode($authString);
        return $this->basicAuth;
    }

    /**
     *
     * @return Response
     */
    public function execute()
    {
        $auth = $this->getBasicAuth();
        $env = parse_ini_file(__DIR__ . './../../../config.env');
        $request = RequestUtil::post(
            API::ACCESS_TOKEN,
        )
            ->httpHeader(Header::AUTHORIZATION, $auth)
            ->httpHeader(Header::SUBSCRIPTION_KEY, $env['subscription_key'])
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new User());
    }
}
