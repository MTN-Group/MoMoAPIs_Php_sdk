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
    const REQUEST_TO_PAY = 'http://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay'; //POST
    const REQUEST_TO_PAY_STATUS = 'http://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay/{referenceId}'; //GET

}
