<?php

namespace mmpsdk\Common\Constants;

/**
 * Class Header
 * @package mmpsdk\Common\Constants
 */
class Header
{
    /**
     * Authorization Header
     */
    const AUTHORIZATION = 'Authorization',
        /**
         * Length of request content in 8-bit bytes
         */
        CONTENT_LENGTH = 'Content-Length',
        /**
         * Content Type
         */
        CONTENT_TYPE = 'Content-Type',
        /**
         * MoMo Subscription Key
         */
        SUBSCRIPTION_KEY = 'Ocp-Apim-Subscription-Key',
        /**
         * Used to pass pre-shared client's identifier to the server.
         */
        X_TARGET_ENVIRONMENT = 'X-Target-Environment',
        /**
         * Header parameter to uniquely identify the request. Must be supplied as a GUID.
         */
        X_REFERENCE_ID = 'X-Reference-Id',
        /**
         * String containing the URL which should receive the Callback for asynchronous requests.
         */
        X_CALLBACK_URL = 'X-Callback-URL';
}
