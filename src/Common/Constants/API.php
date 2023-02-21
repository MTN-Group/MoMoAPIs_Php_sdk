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
    DISBURSEMENT_ACCESS_TOKEN = '/disbursement/token/',
    REMITTANCE_ACCESS_TOKEN = '/remittance/token/',
    COLLECTION_ACCESS_TOKEN = '/collection/token/',
    GET_ACCOUNT_BALANCE = '/disbursement/v1_0/account/balance',
    GET_DEPOSIT_STATUS = '/disbursement/v1_0/deposit/{referenceId}',
    GET_REFUND_STATUS = '/disbursement/v1_0/refund/{referenceId}',
    GET_TRANSFER_STATUS = '/disbursement/v1_0/transfer/{referenceId}';
}
