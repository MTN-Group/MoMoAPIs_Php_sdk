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
        GET_API_KEY = '/v1_0/apiuser/{X-Reference-Id}/apikey',
        REQUEST_TO_PAY = '/collection/v1_0/requesttopay',
        REQUEST_TO_PAY_STATUS = '/collection/v1_0/requesttopay/{X-Reference-Id}',
        VALIDATE_ACCOUNT_HOLDER = '/collection/v1_0/accountholder/{accountHolderIdType}/{accountHolderId}/active',
        GET_ACCOUNT_BALANCE = '/collection/v1_0/account/balance',
        REQUEST_TO_WITHDRAW_V1 = '/collection/v1_0/requesttowithdraw',
        REQUEST_TO_WITHDRAW_V2 = '/collection/v2_0/requesttowithdraw',
        REQUEST_TO_WITHDRAW_STATUS = '/collection/v1_0/requesttowithdraw/{referenceId}',
        GET_BASIC_USER_INFO = '/collection/v1_0/accountholder/msisdn/{accountHolderMSISDN}/basicuserinfo',
        REQUEST_TO_PAY_DELIVERY_NOTIFICATION = '/collection/v1_0/requesttopay/{referenceId}/deliverynotification';
}
