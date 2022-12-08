<?php

namespace mmpsdk\Common\Utils;

use mmpsdk\Common\Constants\Header;
use mmpsdk\Common\Models\Error;
use mmpsdk\Common\Models\MetaData;
use mmpsdk\Common\Exceptions\MobileMoneyException;
use mmpsdk\Common\Constants\MobileMoney;

/**
 * Class ResponseUtil
 * @package mmpsdk\Common\Utils
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
        print_r($response);
        switch ($response->getHttpCode()) {
            //Success Responses
            case self::OK:
            case self::ACCEPTED:
            case self::CREATED:
                if (!$response->getResult()) {
                    $response->setResult(["Operation Successful"]);
                }
                $decodedResponse = self::decodeJson($response->getResult());
                $data = $decodedResponse;
                if (is_array($decodedResponse) && empty($decodedResponse)) {
                    $data['data'] = $data;
                    return $data;
                }
                //Add client correlation id along with response
                if ($response->getClientCorrelationId()) {
                    $data->clientCorrelationId = $response->getClientCorrelationId();
                }
                if ($obj !== null) {
                    $data = $obj->hydrate($decodedResponse, null);
                    if (is_array($data)) {
                        $dataResponse['data'] = $data;
                        $data = $dataResponse;
                    }
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
                $errorObject = self::decodeJson($response->getResult());
                if (isset($errorObject->errorCode)) {
                    throw new MobileMoneyException(
                        self::UNAUTHORIZED,
                        new Error($response->getResult())
                    );
                // } else {
                //     if (!isset($request->isAuthTokenRequest)) {
                //         print_r('Refreshing Token...');
                //         // $authObj = AuthUtil::updateAccessToken(
                //         //     MobileMoney::getConsumerKey(),
                //         //     MobileMoney::getConsumerSecret(),
                //         //     MobileMoney::getApiKey()
                //         // );
                //     }
                //     $request->retryCount += 1;
                //     if ($request->retryCount <= $request->retryLimit) {
                //         return $request->execute();
                //     } else {
                //         throw new MobileMoneyException(
                //             MobileMoneyException::MAX_RETRIES_EXCEEDED
                //         );
                //     }
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
