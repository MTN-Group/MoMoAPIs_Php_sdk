<?php

namespace momopsdk\Collection\Process;

use momopsdk\Common\Models\Response;
use momopsdk\Common\Utils\RequestUtil;

use momopsdk\Common\Constants\Header;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Models\CallbackResponse;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Collection\Models\Transaction;
use momopsdk\Common\Utils\GUID;

/**
 * Class InitiateRequestToPay
 * @package momopsdk\Collection\Process
 */
class InitiateRequestToPay extends BaseProcess
{
    /**
     * Transaction object
     *
     * @var Transaction
     */
    private $transaction;

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
    public function __construct($transaction, $sCollectionSubKey, $targetEnvironment, $callBackUrl = null)
    {
        $this->setUp(self::ASYNCHRONOUS_PROCESS, $callBackUrl);
        $this->transaction = $transaction;
        $this->subKey = $sCollectionSubKey;
        $this->targetEnv = $targetEnvironment;
        return $this;
    }

    // /**
    //  * Creates bearer authorization header.
    //  *
    //  * @return this
    //  */
    // public function getBearerAuth()
    // {
    //     $env = parse_ini_file(__DIR__ . './../../../config.env');
    //     $accessToken = $env['access_token'];
    //     $this->bearerAuth = "Bearer " . $accessToken;
    //     return $this->bearerAuth;
    // }

    /**
     *
     * @return CallbackResponse
     */
    public function execute()
    {
        $referenceId = GUID::create();
        $request = RequestUtil::post(API::REQUEST_TO_PAY, json_encode($this->transaction))
            ->httpHeader(Header::X_REFERENCE_ID, $referenceId)
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnv)
            ->httpHeader(Header::SUBSCRIPTION_KEY, $this->subKey)
            ->setSubscriptionKey($this->subKey)
            ->setReferenceId($referenceId)
            ->build();
        print_r("fbghnhjnjh");
        die;
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new CallbackResponse());
    }
}
