<?php

namespace momopsdk\Common\Process;

use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\EncDecUtil;

class AccessToken extends BaseProcess
{
    private $userId;

    private $apiKey;

    public $isAuthTokenRequest = true;

    private $tokenIdentifier;

    private $subscriptionKey;

    /**
     * Use this API call to generate an Access Token. You can then use the token to authenticate on subsequent API requests until the token expires.
     * To generate the access token, a Consumer Key and a Consumer Secret is required
     *
     */
    public function __construct($userId, $apiKey, $tokenIdentifier, $sSubKey)
    {
        CommonUtil::validateArgument($userId, 'userId');
        CommonUtil::validateArgument($apiKey, 'apiKey');
        // $this->setUp(self::SYNCHRONOUS_PROCESS);
        $this->userId = $userId;
        $this->apiKey = $apiKey;
        $this->tokenIdentifier = $tokenIdentifier;
        $this->subscriptionKey = $sSubKey;
        return $this;
    }

    public function execute()
    {

        switch ($this->tokenIdentifier) {
            case 'COLLECTION':
                $apiUrl = API::COLLECTION_ACCESS_TOKEN;
                break;
            case 'DISBURSEMENT':
                $apiUrl = API::DISBURSEMENT_ACCESS_TOKEN;
                break;
            case 'REMITTANCE':
                $apiUrl = API::REMITTANCE_ACCESS_TOKEN;
                break;
            default:
                # code...
                break;
        }
        $request = RequestUtil::post(
            $apiUrl
        )
            ->httpHeader(
                Header::AUTHORIZATION,
                EncDecUtil::getBasicAuthHeader(
                    $this->userId,
                    $this->apiKey
                )
            )
            ->httpHeader(
                Header::CONTENT_TYPE,
                'application/json'
            )
            ->httpHeader(
                Header::OCP_APIM_SUBSCRIPTION_KEY,
                $this->subscriptionKey
            )
            ->build();
        $response = $this->makeRequest($request);
        print_r($response);
        die;
        return $this->parseResponse($response);
    }
}
