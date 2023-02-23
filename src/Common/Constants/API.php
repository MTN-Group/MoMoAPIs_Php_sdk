<?php

namespace momopsdk\Common\Constants;

/**
 * Class API
 * @package momopsdk\Common\Constants
 */
class API
{
    const SANDBOX_BASE_URL = 'https://sandbox.momodeveloper.mtn.com',
        PRODUCTION_BASE_URL = '',


        CREATE_USER = '/v1_0/apiuser',
        GET_USER_INFORMATION = '/v1_0/apiuser/{X-Reference-Id}',
        GET_API_KEY = '/v1_0/apiuser/{X-Reference-Id}/apikey',
        REQUEST_TO_PAY = '/collection/v1_0/requesttopay',
        REQUEST_TO_PAY_STATUS = '/collection/v1_0/requesttopay/{X-Reference-Id}',
        VALIDATE_ACCOUNT_HOLDER = '/{subscriptionType}/v1_0/accountholder/{accountHolderIdType}/{accountHolderId}/active',
        //GET_ACCOUNT_BALANCE_COLLECTION = '/collection/v1_0/account/balance',
        REQUEST_TO_WITHDRAW_V1 = '/collection/v1_0/requesttowithdraw',
        REQUEST_TO_WITHDRAW_V2 = '/collection/v2_0/requesttowithdraw',
        REQUEST_TO_WITHDRAW_STATUS = '/collection/v1_0/requesttowithdraw/{referenceId}',
        GET_BASIC_USER_INFO = '/{subscriptionType}/v1_0/accountholder/msisdn/{accountHolderMSISDN}/basicuserinfo',
        REQUEST_TO_PAY_DELIVERY_NOTIFICATION = '/{subscriptionType}/v1_0/requesttopay/{referenceId}/deliverynotification',

        /**Token Generate urls */
        DISBURSEMENT_ACCESS_TOKEN = '/disbursement/token/',
        REMITTANCE_ACCESS_TOKEN = '/remittance/token/',
        COLLECTION_ACCESS_TOKEN = '/collection/token/',


        GET_ACCOUNT_BALANCE = '/{subscriptionType}/v1_0/account/balance',
        GET_DEPOSIT_STATUS = '/{subscriptionType}/v1_0/deposit/{referenceId}',
        GET_REFUND_STATUS = '/{subscriptionType}/v1_0/refund/{referenceId}',
        GET_TRANSFER_STATUS = '/{subscriptionType}/v1_0/transfer/{referenceId}',
        GET_DEPOSIT_V1 = '/{subscriptionType}/v1_0/deposit',
        GET_DEPOSIT_V2 = '/{subscriptionType}/v2_0/deposit',
        CREATE_REFUND_V1 = '/{subscriptionType}/v1_0/refund',
        CREATE_REFUND_V2 = '/{subscriptionType}/v2_0/refund',
        CREATE_TRANSFER = '/{subscriptionType}/v1_0/transfer';
}
