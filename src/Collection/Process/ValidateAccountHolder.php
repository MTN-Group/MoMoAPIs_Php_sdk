<?php

namespace momopsdk\Collection\Process;

use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\CallbackResponse;

/**
 * Class ValidateAccountHolder
 * @package momopsdk\Collection\Process
 */
class ValidateAccountHolder extends BaseProcess
{

    /**
     * Party Id of the transaction initiated
     */
    private $accountHolderId;

    /**
     * Party type of the transaction initiated
     */
    private $accountHolderIdType;

    /**
     * Authentication token
     */
    private $bearerAuth;

    /**
     * Get the transaction request status.
     *
     * @param string $referenceId
     * @return this
     */
    public function __construct($accountHolderId, $accountHolderIdType)
    {
        CommonUtil::validateArgument(
            $accountHolderId,
            'accountHolderId',
            CommonUtil::TYPE_STRING
        );

        CommonUtil::validateArgument(
            $accountHolderIdType,
            'accountHolderIdType',
            CommonUtil::TYPE_STRING
        );

        $this->setUp(self::SYNCHRONOUS_PROCESS);
        $this->accountHolderId = $accountHolderId;
        $this->accountHolderIdType = $accountHolderIdType;
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
     * Function to execute API call to validate account holder status
     * @return CallbackResponse
     */
    public function execute()
    {
        $auth = $this->getBearerAuth();
        $env = parse_ini_file(__DIR__ . './../../../config.env');
        $request = RequestUtil::get(API::VALIDATE_ACCOUNT_HOLDER)
            ->setUrlParams([
                '{accountHolderId}' => $this->accountHolderId,
                '{accountHolderIdType}' => $this->accountHolderIdType
            ])
            ->httpHeader(Header::AUTHORIZATION, $auth)
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, "sandbox")
            ->httpHeader(Header::SUBSCRIPTION_KEY, $env['collection_subscription_key'])
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new CallbackResponse());
    }
}
