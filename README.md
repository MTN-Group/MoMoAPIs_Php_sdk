# momoapi-php-sdk

The MOMOAPI SDK for PHP enables PHP developers to easily work with [MTN Mobile Money API](https://momodeveloper.mtn.com/api-documentation).

The SDK provides separate use cases to handle necessary MOMOAPI functionality including Collections,Disbursements,Remittance and Sandbox User Provisioning(For sandbox). Each use case exposes use case scenarios
to customize your application integrations as needed. The SDK also includes a Samples, so you can test interactions before integration.

## Index

This document contains the following sections:

-   [Requirements](#requirements)
-   [Getting Started](#getting-started)
    -   [Installation](#installation)
        -   [Composer](#composer)
        -   [Manual Installation](#manual-installation)
-   [Setting Up](#setting-up)
    -   [Initialization of PHP SDK](#initialization-of-php-sdk)
    -   [Instantiating the models](#instantiating-the-models)
    -   [Handling errors](#handling-errors)
-   [Use Cases](#use-cases)
    -   [Collection](#collection)
    -   [Disbursements](#disbursements)
    -   [Remittance](#remittance)
    -   [Sandbox User Provisioning](#sandbox-user-provisioning)
-   [Tests](#tests)
    -   [Unit tests](#unit-tests)
    -   [Integration tests](#integration-tests)
    -   [Execute all tests (unit + integration)](#execute-all-tests-unit--integration)
-   [Samples](#samples)

## Requirements

-   PHP 5.4+
-   cURL PHP Extension
-   JSON PHP Extension

## Getting Started

### Installation

#### Composer

Update your composer.json file as per the example below and then run for this specific release `composer update`.

```json
{
    "require": {
        "php": ">=5.4",
        "momopsdk/momopsdk": "<version_number_here>"
    }
}
```

After installation through Composer, don't forget to require its autoloader in your script or bootstrap file:

```php
require 'vendor/autoload.php';
```

#### Manual Installation

If you prefer not to use Composer, you can manually install the SDK.

-   Download the latest stable release of php-sdk
-   Extract php-sdk into your projects vendor folder
-   Require autoloader in your script or bootstrap file:
    ```php
    require 'path/to/sdk/autoload.php';
    ```

## Setting Up

### Initialization of PHP SDK

All PHP code snippets presented [here](/docs) assumes that you have initialized the PHP SDK before using them in your Development Environment. This section details the initialization of the PHP SDK.

To initialize the PHP SDK, the static method `initialize()` of `MobileMoney` class is used. `initialize()` has the following required parameters:

1.  `Environment` value can be one of the following
    -   `MobileMoney::SANDBOX` for Sandbox
    -   `MobileMoney::PRODUCTION` for Production
2.  `$env['reference_id']` the reference id or user Id (can be obtained from partner gateway.In Sandbox account it can be generated using user provisioning APIs.)
3.  `$env['momo_api_key']` the API key of the user (can be obtained from partner gateway or sandbox user provisioning APIs)

Other optional functions available for `MobileMoney` class are:

-   `setSecurityLevel()` - When making API requests, this property is used to specify the type of authentication to be used. If not set the default `SecurityLevel::STANDARD` will be used. Value can be one of the following
    -   `SecurityLevel::DEVELOPMENT` - Uses Basic authentication for requests.
    -   `SecurityLevel::STANDARD` - Uses OAuth2 authentication for requests.

```php
<?php
//require the autoload file
require 'path/to/sdk/autoload.php';

// or if you are using composer
// require 'vendor/autoload.php';

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Enums\SecurityLevel;
use momopsdk\Common\Exceptions\MobileMoneyException;

//Initialize SDK
try {
    MobileMoney::initialize(
        MobileMoney::SANDBOX,
        $env['reference_id'],
        $env['momo_api_key']
    );
} catch (MobileMoneyException $exception) {
    print_r($exception->getMessage());
}
```

### Instantiating the models

When making a specific API call using the PHP SDK, you usually have to include a specific class used for the data sent or returned as part of that API request. The PHP classes used to pass data to and from API endpoints are called models.
We will use the `DepositModel` object as an example.
The `amount` property is an example of a string that is part of the `DepositModel` class that has both a public getter and a public setter. To set the `amount` property of a `DepositModel` object, use this code:

```php
$deposit = new DepositModel();
$deposit->setAmount($amount);
```

To get the value of the amount property, you can simply use the string that it returns, like this:

```php
$deposit->getAmount();
```


### Handling errors

Error handling is a crucial aspect of software development. Both expected and unexpected errors should be handled by your code.

The PHP SDK provides an `MobileMoneyException` class that is used for common scenarios where exceptions are thrown. The `getErrorObj()` and `getMessage()` methods can provide useful information to understand the cause of errors.

```php
<?php
require_once __DIR__ . './../bootstrap.php';
use momopsdk\Disbursement\Models\DepositModel;
use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Disbursement\DisbursementTransaction;

$payee = [
        'partyIdType' => 'MSISDN',
        'partyId' => '222222'
    ];

    $oReqDataObject = new DepositModel();

    $oReqDataObject
        ->setAmount('2000')
        ->setCurrency('EUR')
        ->setExternalId('12345678')
        ->setPayerMessage('Payer message here')
        ->setPayeeNote('Payee note here')
        ->setPayee($payee);
    $callbackUrl = "http://webhook.site/c84cd23c-062b-49bb-b206-909bc8625207";
try {
    /**
     * Construct request object and set desired parameters
     */
    $request = DisbursementTransaction::depositV1(
        $oReqDataObject,
        $sDisbursementSubKey,
        $targetEnvironment,
        $callbackUrl
    );

    /**
     *Execute the request
     */
    $response = $request->execute();
} catch (MobileMoneyException $ex) {
    print_r($ex->getMessage());
    print_r($ex->getErrorObj());
}
```

Sample Response:

```php
400: Invalid JSON Field

momopsdk\Common\Models\Error Object
(
    [errorCategory:momopsdk\Common\Models\Error:private] => validation
    [errorCode:momopsdk\Common\Models\Error:private] => formatError
    [errorDescription:momopsdk\Common\Models\Error:private] => Invalid JSON Field
    [errorDateTime:momopsdk\Common\Models\Error:private] => 2022-01-10T07:46:56.529Z
    [errorParameters:momopsdk\Common\Models\Error:private] => Array
        (
            [0] => stdClass Object
                (
                    [key] => amount
                    [value] => must match "^([0]|([1-9][0-9]{0,17}))([.][0-9]{0,3}[0-9])?$"
                )

        )
)
```

## Use Cases

-   [Collection](#collection)
-   [Disbursements](#disbursements)
-   [Remittance](#remittance)
-   [Sandbox User Provisioning](#sandbox-user-provisioning)

### Collection

<table>
<thead>
  <tr>
    <th>Scenarios</th>
    <th>API</th>
    <th>Function</th>
    <th>Parameters</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td>Get Account Balance</td>
    <td><a href="docs/Collection/GetAccountBalance.readme.md">Get Account Balance</a></td>
    <td>Get the balance of the account</td>
    <td>string $sCollectionSubKey, string $targetEnvironment</td>
  </tr>
  <tr>
    <td>Get Account Balance In Specific Currency</td>
    <td><a href="docs/Collection/GetAccountBalanceInSpecificCurrency.readme.md">Get Account Balance In Specific Currency</a></td>
    <td>Get the balance of the account in specific currency</td>
    <td>string $sSubsKey, string $sTargetEnvironment, string $sCurrency</td>
  </tr>
  <tr>
    <td>Get Basic User Info</td>
    <td><a href="docs/Collection/GetBasicUserInfo.readme.md">Get Basic User Info</a></td>
    <td>returns personal information of the account holder</td>
    <td>string $accountHolderMSISDN, string $sCollectionSubKey, string $targetEnvironment</td>
  </tr>
  <tr>
    <td>Get User Info With Consent</td>
    <td><a href="docs/Collection/GetUserInfoWithConsent.readme.md">Get User Info With Consent</a></td>
    <td>claim a consent by the account holder for the requested scopes</td>
    <td>string $sCollectionSubKey, string $targetEnvironment</td>
  </tr>
  <tr>
    <td>Request To Pay</td>
    <td><a href="docs/Collection/RequestToPay.readme.md">Request To Pay</a></td>
    <td>This operation is used to request a payment from a consumer (Payer). The payer will be asked to authorize the payment. The transaction will be executed once the payer has authorized the payment.</td>
    <td>Transaction $transaction, string $sCollectionSubKey, string $targetEnvironment, string $callBackUrl=null, string $contentType=null</td>
  </tr>
  <tr>
    <td>Request To Pay Delivery Notification</td>
    <td><a href="docs/Collection/RequestToPayDeliveryNotification.readme.md">Request To Pay Delivery Notification</a></td>
    <td>This operation is used to send additional Notification to an End User.</td>
    <td>string $referenceId, string $notificationMessage, string $sCollectionSubKey, string $targetEnvironment,DeliveryNotification $deliveryNotification, string $callbackUrl, string $contentType</td>
  </tr>
  <tr>
    <td>Request To Pay Transaction Status</td>
    <td><a href="docs/Collection/RequestToPayTransactionStatus.readme.md">Request To Pay Transaction Status</a></td>
    <td>This operation is used to get the status of a request to pay.</td>
    <td>string $referenceId, string $sCollectionSubKey, string $targetEnvironment</td>
  </tr>
  <tr>
    <td>Request To Withdraw Transaction Status</td>
    <td><a href="docs/Collection/RequestToWithdrawStatus.readme.md">Request To Withdraw Transaction Status</a></td>
    <td>Used to get the status of a request to withdraw</td>
    <td>string $referenceId, string $sCollectionSubKey, string $targetEnvironment</td>
  </tr>
  <tr>
    <td>Request To Withdraw V1</td>
    <td><a href="docs/Collection/RequestToWithdrawV1.readme.md">Request To Withdraw V1</a></td>
    <td>Used to request a withdrawal (cash-out) from a consumer (Payer). </td>
    <td>Transaction $transaction, string $sCollectionSubKey, string $targetEnvironment, string $sCallbackUrl, string $sContentType</td>
  </tr>
  <tr>
    <td>Request To Withdraw V2</td>
    <td><a href="docs/Collection/RequestToWithdrawV2.readme.md">Request To Withdraw V2</a></td>
    <td>Used to request a withdrawal (cash-out) from a consumer (Payer). </td>
    <td>Transaction $transaction, string $sCollectionSubKey, string $targetEnvironment, string $sCallbackUrl, string $sContentType</td>
  </tr>
  <tr>
    <td>Validate Account Holder Status</td>
    <td><a href="docs/Collection/ValidateAccountHolder.readme.md">Validate Account Holder Status</a></td>
    <td>Used to check if an account holder is registered and active in the system </td>
    <td>string $accountHolderId, string $accountHolderIdType, string $sCollectionSubKey, string $targetEnvironment</td>
  </tr>
</tbody>
</table>

### Disbursements

<table>
<thead>
  <tr>
    <th>Scenarios</th>
    <th>API</th>
    <th>Function</th>
    <th>Parameters</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td>Individual Disbursement</td>
    <td><a href="docs/disbursement/createDisbursementTransaction.Readme.md">Create a Individual Disbursement request </a></td>
    <td>createDisbursementTransaction</td>
    <td>Transaction $transaction, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td rowspan="4">Bulk Disbursement</td>
    <td><a href="docs/disbursement/createBatchTransaction.Readme.md">Create A Transaction Batch</a></td>
    <td>createBatchTransaction</td>
    <td>BatchTransaction $batchTransaction, $callBackUrl = null</td>
  </tr>
  <tr>
    <td><a href="docs/disbursement/viewBatchTransaction.Readme.md">View A Transaction Batch</a></td>
    <td>viewBatchTransaction</td>
    <td>string $batchId</td>
  </tr>
  <tr>
    <td><a href="docs/disbursement/viewBatchCompletions.Readme.md">View Batch Completions</a></td>
    <td>viewBatchCompletions</td>
    <td>string $batchId, array $filter = null</td>
  </tr>
  <tr>
    <td><a href="docs/disbursement/viewBatchRejections.Readme.md">View Batch Rejections</a></td>
    <td>viewBatchRejections</td>
    <td>string $batchId, array $filter = null</td>
  </tr>
  <tr>
    <td rowspan="5">Bulk Disbursement with Maker / Checker</td>
    <td><a href="docs/disbursement/createBatchTransaction.Readme.md">Create A Transaction Batch</a></td>
    <td>createBatchTransaction</td>
    <td>BatchTransaction $batchTransaction, $callBackUrl = null</td>
  </tr>
  <tr>
    <td><a href="docs/disbursement/updateBatchTransaction.Readme.md">Update A Transaction Batch</a></td>
    <td>updateBatchTransaction</td>
    <td>array $patchData, string $batchId, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td><a href="docs/disbursement/viewBatchTransaction.Readme.md">View A Transaction Batch</a></td>
    <td>viewBatchTransaction</td>
    <td>string $batchId</td>
  </tr>
  <tr>
    <td><a href="docs/disbursement/viewBatchCompletions.Readme.md">View Batch Completions</a></td>
    <td>viewBatchCompletions</td>
    <td> string $batchId, array $filter = null</td>
  </tr>
  <tr>
    <td><a href="docs/disbursement/viewBatchRejections.Readme.md">View Batch Rejections</a></td>
    <td>viewBatchRejections</td>
    <td>string $batchId, array $filter = null</td>
  </tr>
  <tr>
    <td rowspan="3">Individual Disbursement Using the Polling Method</td>
    <td><a href="docs/disbursement/createDisbursementTransaction.Readme.md">Create a Individual Disbursement request </a></td>
    <td>createDisbursementTransaction</td>
    <td>Transaction $transaction, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td><a href="docs/disbursement/viewRequestState.Readme.md">Poll to Determine the Request State</a></td>
    <td>viewRequestState</td>
    <td>string $serverCorrelationId</td>
  </tr>
  <tr>
    <td><a href="docs/disbursement/viewTransaction.Readme.md">Retrieve a Transaction</a></td>
    <td>viewTransaction</td>
    <td>string $transactionReference</td>
  </tr>
  <tr>
    <td>Disbursement Reversal</td>
    <td><a href="docs/disbursement/createReversal.Readme.md">Perform a Disbursement Reversal</a></td>
    <td>createReversal</td>
    <td>string $transactionReference, Reversal $reversal=null, string $callBackUrl=null</td>
  </tr>
  <tr>
    <td>Obtain a Disbursement Organisation Balance</td>
    <td><a href="docs/disbursement/viewAccountBalance.Readme.md">Get an Account Balance</a></td>
    <td>viewAccountBalance</td>
    <td>array $accountIdentifier</td>
  </tr>
  <tr>
    <td>Retrieve Transactions for a Disbursement Organisation</td>
    <td><a href="docs/disbursement/viewAccountTransactions.Readme.md">Retrieve a Set of Transactions for an Account</a></td>
    <td>viewAccountTransactions</td>
    <td>array $accountIdentifier, array $filter=null</td>
  </tr>
  <tr>
    <td>Check for Service Availability</td>
    <td><a href="docs/disbursement/viewServiceAvailability.Readme.md">Check for Service Availability</a></td>
    <td>viewServiceAvailability</td>
    <td>NA</td>
  </tr>
  <tr>
    <td>Retrieve a Missing API Response</td>
    <td><a href="docs/disbursement/viewResponse.Readme.md">Retrieve a Missing Response</a></td>
    <td>viewResponse</td>
    <td>string $clientCorrelationId, Object $objRef=null</td>
  </tr>
</tbody>
</table>

### International Transfers

<table>
<thead>
  <tr>
    <th>Scenarios</th>
    <th>API</th>
    <th>Function</th>
    <th>Parameters</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td rowspan="3">International Transfer via Hub</td>
    <td><a href="/docs/internationalTransfer/createQuotation.Readme.md">Request a International Transfer Quotation</a></td>
    <td>createQuotation</td>
    <td>Quotation quotation, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td><a href="/docs/internationalTransfer/createInternationalTransaction.Readme.md">Perform an International Transfer</a></td>
    <td>createInternationalTransaction</td>
    <td>Transaction $transaction, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td>Optional <a href="/docs/internationalTransfer/viewQuotation.Readme.md">View A Quotation</a></td>
    <td>viewQuotation</td>
    <td>String quotationReference</td>
  </tr>
  <tr>
    <td rowspan="3">Bilateral International Transfer</td>
    <td><a href="/docs/internationalTransfer/createQuotation.Readme.md">Request a International Transfer Quotation</a></td>
    <td>createQuotation</td>
    <td>Quotation quotation, string $callBackUrl = null</td>
  </tr>

 <tr>
    <td><a href="/docs/internationalTransfer/createInternationalTransaction.Readme.md">Perform an International Transfer</a></td>
    <td>createInternationalTransaction</td>
    <td>Transaction $transaction, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td>Optional <a href="/docs/internationalTransfer/viewQuotation.Readme.md">View A Quotation</a></td>
    <td>viewQuotation</td>
    <td>String quotationReference</td>
  </tr>
  <tr>
  <tr>
    <td>International Transfer Reversal</td>
    <td><a href="/docs/internationalTransfer/createReversal.Readme.md">Perform a Transaction Reversal</a></td>
    <td>createReversal</td>
    <td>string $transactionReference, Reversal $reversal=null, string $callBackUrl=null</td>
  </tr>
  <tr>
    <td>Obtain an FSP Balance</td>
    <td><a href="/docs/internationalTransfer/viewAccountBalance.Readme.md">Get an Account Balance</a></td>
    <td>viewAccountBalance</td>
    <td>array $accountIdentifier</td>
  </tr>
  <tr>
    <td>Retrieve Transactions for an FSP</td>
    <td><a href="/docs/internationalTransfer/viewAccountTransactions.Readme.md">Retrieve a Set of Transactions for an Account</a></td>
    <td>viewAccountTransactions</td>
    <td>array $accountIdentifier, array $filter=null</td>
  </tr>
  <tr>
    <td>Check for Service Availability</td>
    <td><a href="/docs/internationalTransfer/viewServiceAvailability.Readme.md">Check for Service Availability</a></td>
    <td>viewServiceAvailability</td>
    <td>NA</td>
  </tr>
  <tr>
    <td>Retrieve a Missing API Response</td>
    <td><a href="/docs/internationalTransfer/viewResponse.Readme.md">Retrieve a Missing Response</a></td>
    <td>viewResponse</td>
    <td>string $clientCorrelationId, Object $objRef=null</td>
  </tr>
</tbody>
</table>

### P2P Transfers

<table>
<thead>
  <tr>
    <th>Scenarios</th>
    <th>API</th>
    <th>Function</th>
    <th>Parameters</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td rowspan="3">P2P Transfer via Switch</td>
    <td><a href="/docs/p2pTransfer/viewAccountName.Readme.md">Retrieve the Name of the Recipient</a></td>
    <td>viewAccountName</td>
    <td>array $accountIdentifier</td>
  </tr>
  <tr>
    <td><a href="/docs/p2pTransfer/createQuotation.Readme.md">Request a P2P Quotation</a></td>
    <td>createQuotation</td>
    <td>Quotation quotation, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td><a href="/docs/p2pTransfer/createTransferTransaction.Readme.md">Perform a P2P Transfer</a></td>
    <td>createTransferTransaction</td>
    <td>Transaction $transaction, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td rowspan="2">Bilateral P2P Transfer</td>
    <td><a href="/docs/p2pTransfer/viewAccountName.Readme.md">Retrieve the Name of the Recipient</a></td>
    <td>viewAccountName</td>
    <td>array $accountIdentifier</td>
  </tr>
  <tr>
    <td><a href="/docs/p2pTransfer/createTransferTransaction.Readme.md">Perform a P2P Transfer</a></td>
    <td>createTransferTransaction</td>
    <td>Transaction $transaction, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td rowspan="3">‘On-us’ P2P Transfer Initiated by a Third Party Provider</td>
    <td><a href="/docs/p2pTransfer/viewAccountName.Readme.md">Retrieve the Name of the Recipient</a></td>
    <td>viewAccountName</td>
    <td>array $accountIdentifier</td>
  </tr>
  <tr>
    <td><a href="/docs/p2pTransfer/createQuotation.Readme.md">Request a P2P Quotation</a></td>
    <td>createQuotation</td>
    <td>Quotation quotation, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td><a href="/docs/p2pTransfer/createTransferTransaction.Readme.md">Perform a P2P Transfer</a></td>
    <td>createTransferTransaction</td>
    <td>Transaction $transaction, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td>P2P Transfer Reversal</td>
    <td><a href="/docs/p2pTransfer/createReversal.Readme.md">Perform a Transaction Reversal</a></td>
    <td>createReversal</td>
    <td>string $transactionReference, Reversal $reversal=null, string $callBackUrl=null</td>
  </tr>
  <tr>
    <td>Obtain an FSP Balance</td>
    <td><a href="/docs/p2pTransfer/viewAccountBalance.Readme.md">Get an Account Balance</a></td>
    <td>viewAccountBalance</td>
    <td>array $accountIdentifier</td>
  </tr>
   <tr>
    <td>Retrieve Transactions for an FSP</td>
    <td><a href="/docs/p2pTransfer/viewAccountTransactions.Readme.md">Retrieve a Set of Transactions for an Account</a></td>
    <td>viewAccountTransactions</td>
    <td>array $accountIdentifier, array $filter=null</td>
  </tr>
  <tr>
    <td>Check for Service Availability</td>
    <td><a href="/docs/p2pTransfer/viewServiceAvailability.Readme.md">Check for Service Availability</a></td>
    <td>viewServiceAvailability</td>
    <td>NA</td>
  </tr>
  <tr>
    <td>Retrieve a Missing API Response</td>
    <td><a href="/docs/p2pTransfer/viewResponse.Readme.md">Retrieve a Missing Response</a></td>
    <td>viewResponse</td>
    <td>string $clientCorrelationId, Object $objRef=null</td>
  </tr>
</tbody>
</table>

### Recurring Payments

<table>
<thead>
  <tr>
    <th>Scenarios</th>
    <th>API</th>
    <th>Function</th>
    <th>Parameters</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td>Setup a Recurring Payment</td>
    <td><a href="/docs/recurringPayment/createAccountDebitMandate.Readme.md">Setup a Recurring Payment</a></td>
    <td>createAccountDebitMandate</td>
    <td>array $accountIdentifier, DebitMandate $debitMandate, $callBackUrl = null</td>
  </tr>

  <tr>
    <td>Take a Recurring Payment</td>
    <td><a href="/docs/recurringPayment/createMerchantTransaction.Readme.md">Take a Recurring Payment</a></td>
    <td>createMerchantTransaction</td>
    <td>NA</td>
  </tr>

  <tr>
    <td rowspan="3">Take a Recurring Payment using the Polling Method</td>
    <td><a href="/docs/recurringPayment/createMerchantTransaction.Readme.md">Take a Recurring Payment</a></td>
    <td>createMerchantTransaction</td>
    <td>Transaction $transaction, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td><a href="/docs/recurringPayment/viewRequestState.Readme.md">Poll to Determine the Request State</a></td>
    <td>viewRequestState</td>
    <td>string serverCorrelationId</td>
  </tr>
  <tr>
    <td><a href="/docs/recurringPayment/viewTransaction.Readme.md">Retrieve a Transaction</a></td>
    <td>viewTransaction</td>
    <td>string $transactionReference</td>
  </tr>

  <tr>
    <td>Recurring Payment Refund</td>
    <td><a href="/docs/recurringPayment/createRefundTransaction.Readme.md">Perform a Recurring Payment Refund</a></td>
    <td>createRefundTransaction</td>
    <td>Transaction $transaction, string $callBackUrl=null</td>
  </tr>

  <tr>
    <td>Recurring Payment Reversal</td>
    <td><a href="/docs/recurringPayment/createReversal.Readme.md">Perform a Merchant Payment Reversal</a></td>
    <td>createReversal</td>
    <td>string $transactionReference, Reversal $reversal=null, string $callBackUrl=null</td>
  </tr>

  <tr>
    <td>Payer sets up a Recurring Payment using MMP Channel</td>
    <td><a href="/docs/recurringPayment/createAccountDebitMandate.Readme.md">Setup a Recurring Payment</a></td>
    <td>createAccountDebitMandate</td>
    <td>array $accountIdentifier, DebitMandate $debitMandate, $callBackUrl = null</td>
  </tr>

  <tr>
    <td>Obtain a Service Provider Balance</td>
    <td><a href="/docs/recurringPayment/viewAccountBalance.Readme.md">Get an Account Balance</a></td>
    <td>viewAccountBalance</td>
    <td>array $accountIdentifier</td>
  </tr>

  <tr>
    <td>Retrieve Payments for a Service Provider</td>
    <td><a href="/docs/recurringPayment/viewAccountTransactions.Readme.md">Retrieve a Set of Transactions for an Account</a></td>
    <td>viewAccountTransactions</td>
    <td>array $accountIdentifier, array $filter=null</td>
  </tr>

  <tr>
    <td>Check for Service Availability</td>
    <td><a href="/docs/recurringPayment/viewServiceAvailability.Readme.md">Check for Service Availability</a></td>
    <td>viewServiceAvailability</td>
    <td>NA</td>
  </tr>

  <tr>
    <td>Retrieve a Missing API Response</td>
    <td><a href="/docs/recurringPayment/viewResponse.Readme.md">Retrieve a Missing Response</a></td>
    <td>viewResponse</td>
    <td>string $clientCorrelationId, Object $objRef=null</td>
  </tr>
</tbody>
</table>

### Account Linking

<table>
<thead>
  <tr>
    <th>Scenarios</th>
    <th>API</th>
    <th>Function</th>
    <th>Parameters</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td>Setup an Account Link</td>
    <td><a href="/docs/accountLinking/createAccountLink.Readme.md">Establish an Account to Account Link</a></td>
    <td>createAccountLink</td>
    <td>array $accountIdentifier, Link $link</td>
  </tr>
  <tr>
    <td>Perform a Transfer for a Linked Account</td>
    <td><a href="/docs/accountLinking/createTransferTransaction.Readme.md">Use a Link to make a Transfer</a></td>
    <td>createTransferTransaction</td>
    <td>Transaction $transaction, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td rowspan="3">Perform a Transfer using an Account Link via the Polling Method</td>
    <td><a href="/docs/accountLinking/createTransferTransaction.Readme.md">Use a Link to make a Transfer</a></td>
    <td>createTransferTransaction</td>
    <td>Transaction $transaction, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td><a href="docs/accountLinking/viewRequestState.Readme.md">Poll to Determine the Request State</a></td>
    <td>viewRequestState</td>
    <td>string $serverCorrelationId</td>
  </tr>
  <tr>
    <td><a href="docs/accountLinking/viewTransaction.Readme.md">Retrieve a Transaction</a></td>
    <td>viewTransaction</td>
    <td>string $transactionReference</td>
  </tr>
  <tr>
    <td>Perform a Transfer Reversal</td>
    <td><a href="/docs/accountLinking/createReversal.Readme.md">Perform a Transaction Reversal</a></td>
    <td>createReversal</td>
    <td>string $transactionReference, Reversal $reversal=null, string $callBackUrl=null</td>
  </tr>
  <tr>
    <td>Obtain a Financial Service Provider Balance</td>
    <td><a href="/docs/accountLinking/viewAccountBalance.Readme.md">Get an Account Balance</a></td>
    <td>viewAccountBalance</td>
    <td>array $accountIdentifier</td>
  </tr>
   <tr>
    <td>Retrieve Transfers for a Financial Service Provider</td>
    <td><a href="/docs/accountLinking/viewAccountTransactions.Readme.md">Retrieve a Set of Transactions for an Account</a></td>
    <td>viewAccountTransactions</td>
    <td>array $accountIdentifier, array $filter=null</td>
  </tr>
  <tr>
    <td>Check for Service Availability</td>
    <td><a href="/docs/accountLinking/viewServiceAvailability.Readme.md">Check for Service Availability</a></td>
    <td>viewServiceAvailability</td>
    <td>NA</td>
  </tr>
  <tr>
    <td rowspan="2">Retrieve a Missing API Response</td>
    <td><a href="/docs/accountLinking/viewResponse.Readme.md">Retrieve a Missing Response</a></td>
    <td>viewResponse</td>
    <td>string $clientCorrelationId, Object $objRef=null</td>
  </tr>
</tbody>
</table>

### Bill Payments

<table>
<thead>
  <tr>
    <th>Scenarios</th>
    <th>API</th>
    <th>Function</th>
    <th>Parameters</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td>Successful Retrieval of Bills</td>
    <td><a href="/docs/billPayment/viewAccountBills.Readme.md">Retrieve a Set of Bills</a></td>
    <td>viewAccountBills</td>
    <td>array $accountIdentifier, array $filter = null</td>
  </tr>
  <tr>
    <td rowspan="2">Make a Successful Bill Payment with Callback</td>
    <td><a href="/docs/billPayment/createBillTransaction.Readme.md">Create a Bill Transaction</a></td>
    <td>createBillTransaction</td>
    <td>Transaction $transaction, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td><a href="/docs/billPayment/createBillPayment.Readme.md">Make a Bill Payment</a></td>
    <td>createBillPayment</td>
    <td>array $accountIdentifier, string $billReference, BillPay $billPay, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td rowspan="3">Make a Bill Payment with Polling</td>
    <td><a href="/docs/billPayment/createBillPayment.Readme.md">Make a Bill Payment</a></td>
    <td>createBillPayment</td>
    <td>array $accountIdentifier, string $billReference, BillPay $billPay, string $callBackUrl = null</td>
  </tr>
   <tr>
    <td><a href="/docs/billPayment/viewRequestState.Readme.md">Poll to Determine the Request State</a></td>
    <td>viewRequestState</td>
    <td>string $serverCorrelationId</td>
  </tr>
  <tr>
    <td><a href="/docs/billPayment/viewBillPayment.Readme.md">Retrieve Bill Payments for a Given Bill</a></td>
    <td>viewBillPayment</td>
    <td>array $accountIdentifier, string $billReference, array $filter=null</td>
  </tr>
   <tr>
    <td>Retrieval of Bill Payments</td>
    <td><a href="/docs/billPayment/viewBillPayment.Readme.md">Retrieve a Set of Bill Payments</a></td>
    <td>viewBillPayment</td>
    <td>array $accountIdentifier, string $billReference, array $filter=null</td>
  </tr>
  <tr>
    <td>Check for Service Availability</td>
    <td><a href="/docs/billPayment/viewServiceAvailability.Readme.md">Check for Service Availability</a></td>
    <td>viewServiceAvailability</td>
    <td>NA</td>
  </tr>
  <tr>
    <td>Retrieve a Missing API Response</td>
    <td><a href="/docs/billPayment/viewBillPayment.Readme.md">Retrieve a Missing Response</a></td>
    <td>viewResponse</td>
    <td>string $clientCorrelationId, Object $objRef=null</td>
  </tr>
</tbody>
</table>

### Agent Services

<table>
<thead>
  <tr>
    <th>Scenarios</th>
    <th>API</th>
    <th>Function</th>
    <th>Parameters</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td>Agent-initiated Cash-out</td>
    <td><a href="docs/agentService/createWithdrawalTransaction.Readme.md">Agent Initiated Cash-Out</a></td>
    <td>createWithdrawalTransaction</td>
    <td>Transaction $transaction, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td rowspan="3">Agent-initiated Cash-out using the Polling Method</td>
    <td><a href="docs/agentService/createWithdrawalTransaction.Readme.md">Agent Initiated Cash-out</a></td>
    <td>createWithdrawalTransaction</td>
    <td>Transaction $transaction, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td><a href="docs/agentService/viewRequestState.Readme.md">Poll to Determine the Request State</a></td>
    <td>viewRequestState</td>
    <td>string $serverCorrelationId</td>
  </tr>
  <tr>
    <td><a href="docs/agentService/viewTransaction.Readme.md">Retrieve a Transaction</a></td>
    <td>viewTransaction</td>
    <td>string $transactionReference</td>
  </tr>
  <tr>
    <td>Customer-initiated Cash-out</td>
    <td><a href="docs/agentService/createWithdrawalTransaction.Readme.md">Customer Initiated Cash-Out</a></td>
    <td>createWithdrawalTransaction</td>
    <td>Transaction $transaction, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td rowspan="3">Customer Cash-out at an ATM using an Authorisation Code</td>
    <td><a href="docs/agentService/createAuthorisationCode.Readme.md">Obtain an Authorisation Code</a></td>
    <td>createAuthorisationCode</td>
    <td>array $accountIdentifier, AuthorisationCode $authorisationCode</td>
  </tr>
  <tr>
    <td><a href="docs/agentService/createWithdrawalTransaction.Readme.md">ATM Initiated Cash-Out</a></td>
    <td>createWithdrawalTransaction</td>
    <td>Transaction $transaction, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td><a href="docs/agentService/viewAuthorisationCode.Readme.md">Retrieve Authorisation Code</a></td>
    <td>viewAuthorisationCode</td>
    <td>string $accountIdentifier, string $authorisationCode</td>
  </tr>
  <tr>
    <td rowspan="2">Agent-initiated Customer Cash-in</td>
    <td><a href="docs/agentService/viewAccountName.Readme.md">Retrieve the Name of the Depositing Customer</a></td>
    <td>viewAccountName</td>
    <td>array $accountIdentifier</td>
  </tr>
  <tr>
    <td><a href="docs/agentService/createDepositTransaction.Readme.md">Agent Initiated Cash-in</a></td>
    <td>createDepositTransaction</td>
    <td>Transaction $transaction, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td>Cash-out Reversal</td>
    <td><a href="docs/agentService/createReversal.Readme.md">Perform a Transaction Reversal</a></td>
    <td>createReversal</td>
    <td>string $transactionReference, Reversal $reversal=null, string $callBackUrl=null</td>
  </tr>
  <tr>
    <td>Register a Customer Mobile Money Account</td>
    <td><a href="docs/agentService/createAccount.Readme.md">Create a Mobile Money Account</a></td>
    <td>createAccount</td>
    <td>Account $account, string $callBackUrl = null</td>
  </tr>
  <tr>
    <td rowspan="2">Verify the KYC of a Customer</td>
    <td><a href="docs/agentService/viewAccount.Readme.md">Retrieve Account Information</a></td>
    <td>viewAccount</td>
    <td>array $accountIdentifier</td>
  </tr>
  <tr>
    <td><a href="docs/agentService/updateAccountIdentity.Readme.md">Update KYC Verification Status</a></td>
    <td>updateAccountIdentity</td>
    <td>array $accountIdentifier, String identityId, array $patchData, string $callBackUrl=null</td>
  </tr>
  <tr>
    <td>Obtain an Agent Balance</td>
    <td><a href="docs/agentService/viewAccountBalance.Readme.md">Obtain an Agent Balance</a></td>
    <td>viewAccountBalance</td>
    <td>array $accountIdentifier</td>
  </tr>
  <tr>
    <td>Retrieve Transactions for an Agent</td>
    <td><a href="docs/agentService/viewAccountTransactions.Readme.md">Retrieve a Set of Transactions for an Account</a></td>
    <td>viewAccountTransactions</td>
    <td>array $accountIdentifier, array $filter=null</td>
  </tr>
  <tr>
    <td>Check for Service Availability</td>
    <td><a href="docs/agentService/viewServiceAvailability.Readme.md">Check for Service Availability</a></td>
    <td>viewServiceAvailability</td>
    <td>NA</td>
  </tr>
  <tr>
  <td>Retrieve a Missing API Response</td>
    <td><a href="docs/agentService/viewResponse.Readme.md">Retrieve a Missing Response</a></td>
    <td>viewResponse</td>
    <td>string $clientCorrelationId, Object $objRef=null</td>
  </tr>
</tbody>
</table>

## Tests

The `tests` folder contains the test cases. These are logically divided in unit and integration tests. Integration tests require an active `consumer key`, `consumer secret` and `api key`.

1. Install [Composer](https://getcomposer.org/download/)
2. From the root of the sdk-php project, run `composer install --dev` to install the dependencies
3. Copy `config.env.sample` to `config.env` and replace the template values by actual values

### Unit tests

These tests are located in `tests/Unit` and are responsible for ensuring each class is behaving as expected, without considering the rest of the system. Unit tests heavily leverage mocking and are an essential part of the testing harness.

To run unit tests,

```shell
composer run unit-tests
```

To run tests individually (be sure not to be pointing to an integration test file):

```shell
composer run unit-tests path/to/class/file
```

### Integration tests

These tests are located in `tests/Integration` and are responsible for ensuring a proper communication with server/simulator. With the integration tests, we ensure all communications between the SDK and the server/simulator are behaving accordingly.

To run the integration tests,

```shell
composer run integration-tests
```

To run tests individually (be sure not to be pointing to an unit test file):

```shell
composer run integration-tests path/to/class/file
```

### Execute all tests (unit + integration)

```shell
composer run tests
```

## Samples

The sample code snippets are all completely independent and self-contained. You can analyze them to get an understanding of how a particular method can be implemented in your application. Sample code snippets can be found [here](/sample). Steps to run the sample code snippets are as follows:

-   Clone this repository:

```
git clone git@github.com:gsmainclusivetechlab/mmapi-php-sdk.git
cd mmapi-php-sdk
```

-   Create config.env file for API credentials:

```
cp config.env.sample config.env
```

-   Set the API credentials in the config.env file:

e.g.

```
    consumer_key = <your_consumer_key_here>
    consumer_secret = <your_consumer_secret_here>
    api_key = <your_api_key_here>
    callback_url = <your_callback_url_here>
```

-   Run each sample directly from the command line. For example:

```
php sample/MerchantPayment/InitiatePayment.php
```
