<?php

namespace momopsdk\Collection\Process;

use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Collection\Models\StatusResponse;

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
     * Collectin subscription Key
     */
    private $subKey;

    /**
     * target Key
     */
    private $targetEnv;

    /**
     * Get the transaction request status.
     *
     * @param string $accountHolderId, $accountHolderIdType,
     * $sCollectionSubKey, $targetEnvironment
     * @return this
     */
    public function __construct($accountHolderId, $accountHolderIdType, $sCollectionSubKey, $targetEnvironment)
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

        CommonUtil::validateArgument(
            $sCollectionSubKey,
            'sCollectionSubKey',
            CommonUtil::TYPE_STRING
        );

        $this->setUp(self::SYNCHRONOUS_PROCESS);
        $this->accountHolderId = $accountHolderId;
        $this->accountHolderIdType = $accountHolderIdType;
        $this->subKey = $sCollectionSubKey;
        $this->targetEnv = $targetEnvironment;
        return $this;
    }

    /**
     * Function to execute API call to validate account holder status
     * @return RequestToPayResponse
     */
    public function execute()
    {
        $env = parse_ini_file(__DIR__ . './../../../config.env');
        $request = RequestUtil::get(API::VALIDATE_ACCOUNT_HOLDER)
            ->setUrlParams([
                '{accountHolderId}' => $this->accountHolderId,
                '{accountHolderIdType}' => $this->accountHolderIdType
            ])
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnv)
            ->httpHeader(Header::SUBSCRIPTION_KEY, $this->subKey)
            ->setSubscriptionKey($this->subKey)
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new StatusResponse());
    }
}
