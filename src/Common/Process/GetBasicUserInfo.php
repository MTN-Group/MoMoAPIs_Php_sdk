<?php

namespace momopsdk\Common\Process;

use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\UserDetail;

/**
 * Class GetBasicUserInfo
 *
 * @package momopsdk\Common\Process
 */
class GetBasicUserInfo extends BaseProcess
{
    /**
     * Collection subscription key
     */
    private $subKey;

    /**
     * Notification Message
     */
    private $msisdn;

    /**
     * Target Environment
     */
    private $targetEnv;

    /**
     * Subscription Type
     */
    public $subType;

    /**
     * Used to het the personal information of the account holder
     *
     * @param  string $accountHolderMSISDN, $sCollectionSubKey, $targetEnvironment
     * @return this
     */
    public function __construct($sAccountHolderMSISDN, $sCollectionSubKey, $sTargetEnvironment, $subType)
    {
        CommonUtil::validateArgument(
            $sAccountHolderMSISDN,
            'accountHolderMSISDN',
            CommonUtil::TYPE_STRING
        );
        CommonUtil::validateArgument(
            $sCollectionSubKey,
            'CollectionSubKey',
            CommonUtil::TYPE_STRING
        );
        $this->msisdn = $sAccountHolderMSISDN;
        $this->setUp(self::SYNCHRONOUS_PROCESS);
        $this->subKey = $sCollectionSubKey;
        $this->targetEnv = $sTargetEnvironment;
        $this->subType = $subType;
        return $this;
    }


    /**
     * Function to execute sending of additional Notification to an End User
     *
     * @return UserDetail
     */
    public function execute()
    {
        $request = RequestUtil::get(str_replace('{subscriptionType}', $this->subType, API::GET_BASIC_USER_INFO))
            ->setUrlParams(
                [
                '{accountHolderMSISDN}' => $this->msisdn
                ]
            )
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnv)
            ->httpHeader(Header::OCP_APIM_SUBSCRIPTION_KEY, $this->subKey)
            ->setSubscriptionKey($this->subKey)
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new UserDetail());
    }
}
