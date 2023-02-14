<?php

namespace momopsdk\Common\Constants;

/**
 * Class API
 * @package momopsdk\Common\Constants
 */
class API
{
    const CREATE_USER = 'https://sandbox.momodeveloper.mtn.com/v1_0/apiuser';
    /**
     * Collections
     */
    const REQUEST_TO_PAY = 'https://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay'; //POST
    const REQUEST_TO_PAY_STATUS = 'https://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay/{referenceId}'; //GET
}
