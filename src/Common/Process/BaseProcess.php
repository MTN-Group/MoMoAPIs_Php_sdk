<?php

namespace mmpsdk\Common\Process;

use mmpsdk\Common\Constants\MobileMoney;
use mmpsdk\Common\Enums\NotificationMethod;
use mmpsdk\Common\Utils\AuthUtil;
use mmpsdk\Common\Utils\GUID;
use mmpsdk\Common\Utils\ResponseUtil;

abstract class BaseProcess
{
    /**
     * The final resource is always provided in response to an API request.
     * There is no interim response.
     */
    const SYNCHRONOUS_PROCESS = 1;

    /**
     * Interim response is always provided in response to an API request in the form of a Request State object.
     * The final response is provided via a callback or alternatively can be accessed via polling on Request State.
     */
    const ASYNCHRONOUS_PROCESS = 2;

    /**
     * UUID that enables the client to correlate the API request
     * with the resource created/updated by the provider.
     *
     * @var string
     */
    protected $clientCorrelationId;

    /**
     * Indicates whether a callback will be issued or whether the client will need to poll.
     *
     * @var string
     */
    protected $notificationMethod = NotificationMethod::CALLBACK;

    /**
     * String containing the URL which should receive the Callback.
     * For asynchronous requests.
     *
     * @var string
     */
    protected $callBackUrl;

    /**
     * Retry limit
     *
     * @var int
     */
    public $retryLimit = 2;

    /**
     * Retry count
     *
     * @var int
     */
    public $retryCount = 0;

    /**
     * Raw response from the API
     *
     * @var mixed
     */
    public $rawResponse;

    /**
     * Standardised flow pattern type followed by the APIs.
     *
     * @var int
     */
    protected $processType = self::SYNCHRONOUS_PROCESS;

    public function __construct($processType, $callBackUrl = null)
    {
        $this->setUp($processType, $callBackUrl);
    }

    public function setNotificationMethod($notificationMethod)
    {
        if (
            in_array(
                $notificationMethod,
                NotificationMethod::getNotificationMethodOptions()
            )
        ) {
            $this->notificationMethod = $notificationMethod;
            switch ($notificationMethod) {
                case NotificationMethod::POLLING:
                    $this->callBackUrl = null;
                    break;
                case NotificationMethod::CALLBACK:
                    if (empty($this->callBackUrl)) {
                        throw new \mmpsdk\Common\Exceptions\MobileMoneyException(
                            'Callback URL is empty'
                        );
                    }
                    break;

                default:
                    break;
            }
        } elseif ($this->processType == self::ASYNCHRONOUS_PROCESS) {
            throw new \mmpsdk\Common\Exceptions\MobileMoneyException(
                'Unknown notification method: ' . $notificationMethod
            );
        }
    }

    protected function setUp($processType, $callBackUrl = null)
    {
        AuthUtil::validateCredentials();
        $this->processType = $processType;
        if ($this->processType == self::ASYNCHRONOUS_PROCESS) {
            $this->clientCorrelationId = GUID::create();
            $this->callBackUrl = $callBackUrl
                ? $callBackUrl
                : MobileMoney::getCallbackUrl();
            if (
                $this->callBackUrl !== null &&
                filter_var($this->callBackUrl, FILTER_VALIDATE_URL) === false
            ) {
                throw new \mmpsdk\Common\Exceptions\MobileMoneyException(
                    'Invalid Callback URL format: ' . $this->callBackUrl
                );
            }
        }
    }

    /**
     * Retrieve the client correlation id generated for the request
     *
     * @return string
     */
    public function getClientCorrelationId()
    {
        return $this->clientCorrelationId;
    }

    /**
     * Retrieve the callback URL
     *
     * @return string
     */
    public function getCallBackUrl()
    {
        return $this->callBackUrl;
    }

    /**
     * Retrieve the process type
     *
     * @return string
     */
    public function getProcessType()
    {
        return $this->processType;
    }

    /**
     * Get raw response
     *
     * @return mixed
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    /**
     * Make the API request
     *
     * @param RequestUtil $request
     * @return Curl
     */
    protected function makeRequest($request)
    {
        return $request->call();
    }

    /**
     * Parse the response from the API
     *
     * @param Curl $response
     * @return mixed
     */
    protected function parseResponse($response, $obj = null)
    {
        $this->rawResponse = $response;
        return ResponseUtil::parse($response, $obj, $this);
    }

    /**
     * Execute the request
     *
     * @return mixed
     */
    abstract public function execute();
}
