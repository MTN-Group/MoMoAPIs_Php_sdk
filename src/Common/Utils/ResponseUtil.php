<?php

namespace momopsdk\Common\Utils;

use momopsdk\Common\Constants\Header;
use momopsdk\Common\Models\Error;
use momopsdk\Common\Models\MetaData;
use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Utils\AuthUtil;
use momopsdk\Common\Process\GetUserInfoWithConsent;

/**
 * Class ResponseUtil
 * @package momopsdk\Common\Utils
 */
class ResponseUtil
{
    const OK = 200,
        CREATED = 201,
        ACCEPTED = 202,
        BAD_REQUEST = 400,
        UNAUTHORIZED = 401,
        NOT_FOUND = 404,
        INTERNAL_SERVER_ERROR = 500,
        SERVICE_UNAVAILABLE = 503;

    /**
     * Parse the response
     * @param mixed $response
     * @return mixed|null $obj
     */
    public static function parse($response, $obj = null, $request)
    {

        switch ($response->getHttpCode()) {
                //Success Responses
            case self::OK:
                if ($obj != null) {
                    $data = $obj->hydrate($response, null);
                    $data->result = json_decode($response->getResult());
                    if ($response->getReferenceId()) {
                        $data->referenceId = $response->getReferenceId();
                    }
                    $data->httpCode = $response->getHttpCode();
                } else {
                    $data = json_decode($response->getResult());
                }
                MobileMoney::destroyTokenType();
                return $data;
            case self::ACCEPTED:
                $data = $obj->hydrate($request, null);
                $data->referenceId = $response->getReferenceId();
                $data->httpCode = $response->getHttpCode();
                return $data;
                break;
            case self::CREATED:
                if ($response->getResult() != '') {
                    $decodedResponse = $response->getResult();
                    $data = $decodedResponse;
                    if (is_array($decodedResponse) && empty($decodedResponse)) {
                        $data['data'] = $data;
                        $data['metadata'] = new MetaData();
                        return $data;
                    }

                    if ($obj !== null) {
                        $metaData = new MetaData();
                        $data = $obj->hydrate($response, null);
                        $data->result = json_decode($response->getResult());
                        $data->referenceId = $response->getReferenceId();
                        if (is_array($data)) {
                            $dataResponse['data'] = $data;
                            $dataResponse['metadata'] = $metaData;
                            $data = $dataResponse;
                        }
                    }
                } else {
                    $data = $obj->hydrate($request, null);
                    if ($response->getReferenceId()) {
                        $data->referenceId = $response->getReferenceId();
                    }
                    $data->httpCode = $response->getHttpCode();
                }
                return $data;
                break;

                //Failed Responses
            case self::BAD_REQUEST:
                $errorObject = new Error($response->getResult());
                throw new MobileMoneyException(
                    self::BAD_REQUEST .
                        ': ' .
                        $errorObject->getErrorDescription(),
                    $errorObject
                );
                break;
            case self::UNAUTHORIZED:
                if ($response->getResult() != '') {
                    $errorObject = self::decodeJson($response->getResult());
                }
                if (isset($errorObject->statusCode)) {
                    throw new MobileMoneyException(
                        self::UNAUTHORIZED,
                        new Error($response->getResult())
                    );
                } else {
                    if (!isset($request->isAuthTokenRequest)) {
                        print_r('Refreshing Token...');
                        $cachePath = AuthUtil::cachePath();
                        $aExistingData = [];
                        if (file_exists($cachePath)) {
                            $aExistingData = AuthUtil::setExistingData(json_decode(file_get_contents($cachePath), true));
                        }
                        if (MobileMoney::getTokenType() != 'Bearer') {

                            $authObj = AuthUtil::updateAccessToken(
                                MobileMoney::getUserId(),
                                MobileMoney::getApiKey(),
                                MobileMoney::getTokenIdentifier(),
                                MobileMoney::getSubscriptionKey(),
                                MobileMoney::getTokenType(),
                                $aExistingData,
                                MobileMoney::getAuthReqId()
                            );
                        } else {
                            MobileMoney::setTokenType('Basic');
                            GetUserInfoWithConsent::executeBcAuthorize();
                            $authObj = AuthUtil::updateAccessToken(
                                MobileMoney::getUserId(),
                                MobileMoney::getApiKey(),
                                MobileMoney::getTokenIdentifier(),
                                MobileMoney::getSubscriptionKey(),
                                'Bearer',
                                $aExistingData,
                                MobileMoney::getAuthReqId()
                            );
                        }
                    }
                    $request->retryCount += 1;
                    if ($request->retryCount <= $request->retryLimit) {
                        return $request->execute();
                    } else {
                        MobileMoney::destroyTokenType();
                        throw new MobileMoneyException(
                            MobileMoneyException::MAX_RETRIES_EXCEEDED
                        );
                    }
                }
                break;

            case self::NOT_FOUND:
                $errorObject = self::decodeJson($response->getResult());

                if (isset($errorObject->errorCode)) {
                    $errObj = new Error($response->getResult());
                    throw new MobileMoneyException(
                        self::NOT_FOUND . ': ' . $errObj->getErrorDescription(),
                        $errObj
                    );
                } else {
                    throw new MobileMoneyException('Resource Not Found');
                }
                break;
            case self::INTERNAL_SERVER_ERROR:
                throw new MobileMoneyException('Internal Server Error');
                break;
            case self::SERVICE_UNAVAILABLE:
                throw new MobileMoneyException('Service Unavailable');
                break;
            default:
                throw new MobileMoneyException(
                    'Unknown Response: ' .
                        $response->getHttpCode() .
                        $response->getResult()
                );
        }
    }

    public static function decodeJson($jsonData)
    {
        $decodedJson = json_decode($jsonData);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new MobileMoneyException('Invalid JSON Response from API');
        }
        return $decodedJson;
    }
}
