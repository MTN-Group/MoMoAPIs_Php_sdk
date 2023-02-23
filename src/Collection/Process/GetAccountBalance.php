<?php

namespace momopsdk\Collection\Process;


use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Collection\Models\StatusResponse;

/**
 * Class GetAccountBalance
 * @package momopsdk\Collection\Process
 */
class GetAccountBalance extends BaseProcess
{

    /**
     * Collection subscription key
     */
    private $subKey;

    /**
     * Target environment
     */
    private $targetEnv;

    /**
     * Initiates a Request To Pay.
     *
     * @param string $transaction
     * @return this
     */
    public function __construct($sCollectionSubKey, $targetEnvironment)
    {
        CommonUtil::validateArgument(
            $sCollectionSubKey,
            'User Reference ID',
            CommonUtil::TYPE_STRING
        );
        $this->subKey = $sCollectionSubKey;
        $this->targetEnv = $targetEnvironment;
        return $this;
    }

    /**
     * Function to execute API call to get the account balance
     * @return StatusResponse
     */
    public function execute()
    {
        $request = RequestUtil::get(API::GET_ACCOUNT_BALANCE_COLLECTION)
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnv)
            ->httpHeader(Header::OCP_APIM_SUBSCRIPTION_KEY, $this->subKey)
            ->setSubscriptionKey($this->subKey)
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new StatusResponse());
    }
}
