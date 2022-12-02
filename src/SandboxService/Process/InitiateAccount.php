<?php

namespace mmpsdk\SandboxService\Process;

use mmpsdk\SandboxService\Models\Account;
use mmpsdk\SandboxService\Models\User;
use mmpsdk\Common\Models\Response;
use mmpsdk\Common\Utils\RequestUtil;

use mmpsdk\Common\Constants\Header;
use mmpsdk\Common\Constants\API;
use mmpsdk\Common\Process\BaseProcess;

/**
 * Class InitiateAccount
 * @package mmpsdk\SandboxService\Process
 */
class InitiateAccount extends BaseProcess
{
    
    /**
     * Account object
     *
     * @var Account
     */
    private $account;

    /**
     * User object
     *
     * @var User
     */
    private $user;

    /**
     * Initiates a Account Request.
     * Asynchronous payment flow is used with a final callback.
     *
     * @param User $user
     * @return this
     */
    public function __construct($user)
    {
        $this->setUp(self::SYNCHRONOUS_PROCESS);
        $this->user = $user;
        return $this;
    }

    /**
     *
     * @return User
     */
    public function execute()
    {
        $env = parse_ini_file(__DIR__ . './../../../config.env');
        $request = RequestUtil::post(
            API::CREATE_USER,
            json_encode($this->user)
        )
            ->httpHeader(Header::X_REFERENCE_ID, $env['reference_id'])
            ->httpHeader(Header::SUBSCRIPTION_KEY, $env['subscription_key'])
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new User());
    }
}
