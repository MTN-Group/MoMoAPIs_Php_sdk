<?php

namespace mmpsdk\Common\Constants;

/**
 * Class API
 * @package mmpsdk\Common\Constants
 */
class API
{
    const SANDBOX_BASE_URL = 'https://sandbox.momodeveloper.mtn.com',
        SANDBOX_COLLECTIONS_URL= 'https://sandbox.momodeveloper.mtn.com/collection',
        PRODUCTION_BASE_URL = 'https://sandbox.mobilemoneyapi.io/2/oauth/simulator/v1.2/mm',
                /**
         * Authentication
         * To generate an Access Token.
         */
        CREATE_USER = '/v1_0/apiuser',
        CREATE_API_KEY = '/v1_0/apiuser/{xReferenceId}/apikey',
        /**
         * Authentication
         * To generate an Access Token.
         */
        ACCESS_TOKEN = '/collection/token/',
        /**
         * Collections
         */
        REQUEST_TO_PAY= '/collection/v1_0/requesttopay', //POST
        REQUEST_TO_PAY_STATUS='/collection/v1_0/requesttopay/{referenceId}', //GET
        
        /**
         * Transactions
         * The Transactions APIs are used to support mobile money financial transaction use cases.
         */
        CREATE_TRANSACTION= '/transactions/type/{transactionType}',
        /**
         * Accounts
         * The Accounts APIs are used to support a range of operations on a financial account resource and associated resources.
         */
        GENERAL_ACCOUNT = '/accounts/{identityType}', //POST, GET, PATCH
        GENERAL_ACCOUNT_IDENTIFIER = '/accounts/{identifierType}/{identifier}', //GET, PATCH
        GENERAL_ACCOUNT_ID = '/accounts/{accountId}',
        UPDATE_ACCOUNT_IDENDITY = '/accounts/{accountId}/identities/{identityId}',
        UPDATE_ACCOUNT_IDENDITY_BY_ID = '/accounts/{identifierType}/{identifier}/identities/{identityId}',
        VIEW_ACCOUNT_STATUS = '/accounts/{accountId}/status',
        VIEW_ACCOUNT_NAME = '/accounts/{accountId}/accountname',
        VIEW_ACCOUNT_BALANCE = '/accounts/{accountId}/balance',
        VIEW_ACCOUNT_BALANCE_CLIENT = '/accounts/balance',
        VIEW_ACCOUNT_TRANSACTIONS = '/accounts/{accountId}/transactions',
        /**
         * Supporting
         * Supporting APIs
         */
        HEARTBEAT = '/heartbeat',
        VIEW_REQUEST_STATE = '/requeststates/{serverCorrelationId}',
        VIEW_RESPONSE = '/responses/{clientCorrelationId}',
        /**
         * Account Links
         * The Links APIs are used to establish a link between two separate accounts on the client and provider systems.
         */
        CREATE_LINK = '/accounts/{accountId}/links',
        VIEW_LINK = '/accounts/{accountId}/links/{linkReference}',
        UPDATE_LINK = '/accounts/{accountId}/links/{linkReference}';

    /**
     * Other API endpoints TBD
     */
}
