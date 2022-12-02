<?php

namespace mmpsdk\SandboxService\Process;

use mmpsdk\SandboxService\Models\Account;
use mmpsdk\SandboxService\Models\User;
use mmpsdk\Common\Models\Response;
use mmpsdk\Common\Utils\RequestUtil;

use mmpsdk\Common\Utils\CommonUtil;
use mmpsdk\Common\Constants\Header;
use mmpsdk\Common\Constants\API;
use mmpsdk\Common\Process\BaseProcess;

/**
 * Class InitiateApiKey
 * @package mmpsdk\SandboxService\Process
 */
class InitiateApiKey extends BaseProcess
{

    /**
     * Initiates an API key request.
     * Asynchronous payment flow is used with a final callback.
     *
     * @param string $callBackUrl
     * @return this
     */
    public function __construct($callBackUrl = null)
    {
        $this->setUp(self::SYNCHRONOUS_PROCESS);
        return $this;
    }

    /**
     *
     * @return Response
     */
    public function execute()
    {
        $env = parse_ini_file(__DIR__ . './../../../config.env');
        $request = RequestUtil::post(
            API::CREATE_API_KEY,
        )
            ->setUrlParams(['{xReferenceId}' => $env['reference_id']])
            ->httpHeader(Header::X_CALLBACK_URL, $this->callBackUrl)
            ->httpHeader(Header::SUBSCRIPTION_KEY, $env['subscription_key'])
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new Response());
    }
}
