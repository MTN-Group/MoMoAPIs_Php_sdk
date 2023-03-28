<?php

namespace momopsdk\Common\Process;

use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\CommonStatusResponse;

/**
 * Class ValidateAccountHolder
 *
 * @package momopsdk\Common\Process
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
     * Subscription Type
     */
    public $subType;

    /**
     * Get the transaction request status.
     *
     * @param  string $sAccountHolderId, $sAccountHolderIdType,
     *                                   $sCollectionSubKey, $sTargetEnvironment
     * @return this
     */
    public function __construct($sAccountHolderId, $sAccountHolderIdType, $sCollectionSubKey, $sTargetEnvironment, $subType)
    {
        CommonUtil::validateArgument(
            $sAccountHolderId,
            'accountHolderId',
            CommonUtil::TYPE_STRING
        );

        CommonUtil::validateArgument(
            $sAccountHolderIdType,
            'accountHolderIdType',
            CommonUtil::TYPE_STRING
        );

        CommonUtil::validateArgument(
            $sCollectionSubKey,
            'sCollectionSubKey',
            CommonUtil::TYPE_STRING
        );

        $this->setUp(self::SYNCHRONOUS_PROCESS);
        $this->accountHolderId = $sAccountHolderId;
        $this->accountHolderIdType = $sAccountHolderIdType;
        $this->subKey = $sCollectionSubKey;
        $this->targetEnv = $sTargetEnvironment;
        $this->subType = $subType;
        return $this;
    }

    /**
     * Function to execute API call to validate account holder status
     *
     * @return StatusResponse
     */
    public function execute()
    {
        $request = RequestUtil::get(str_replace('{subscriptionType}', $this->subType, API::VALIDATE_ACCOUNT_HOLDER))
            ->setUrlParams(
                [
                '{accountHolderId}' => $this->accountHolderId,
                '{accountHolderIdType}' => $this->accountHolderIdType
                ]
            )
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnv)
            ->httpHeader(Header::OCP_APIM_SUBSCRIPTION_KEY, $this->subKey)
            ->setSubscriptionKey($this->subKey)
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new CommonStatusResponse());
    }
}
