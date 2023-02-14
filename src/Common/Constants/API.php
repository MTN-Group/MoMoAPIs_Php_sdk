<?php

namespace momopsdk\Common\Constants;

/**
 * Class API
 * @package momopsdk\Common\Constants
 */
class API
{
    const CREATE_USER = '/v1_0/apiuser',
    GET_USER_INFORMATION = '/v1_0/apiuser/{X-Reference-Id}',
    GET_API_KEY = '/v1_0/apiuser/{X-Reference-Id}/apikey';
}
