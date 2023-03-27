# momoapi-php-sdk

The MOMOAPI SDK for PHP enables PHP developers to easily work with [MTN Mobile Money API](https://momodeveloper.mtn.com/api-documentation).

The SDK provides separate use cases to handle necessary MOMOAPI functionality including Collections,Disbursements,Remittance and Sandbox User Provisioning(For sandbox). Each use case exposes use case scenarios
to customize your application integrations as needed. The SDK also includes a Samples, so you can test interactions before integration.

## Index

This document contains the following sections:

-   [Requirements](#requirements)
-   [Getting Started](#getting-started)
    -   [Installation](#installation)
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
-   [Folder Permissions](#folder-permissions)

## Requirements

-   PHP 5.4+
-   cURL PHP Extension
-   JSON PHP Extension

## Getting Started

### Installation

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
3.  `$env['momo_api_key']` the API key of the user (can be obtained from partner gateway or sandbox user provisioning APIs).

Other optional functions available for `MobileMoney` class are:

-   `setCallbackUrl()` - URL for your application where you want MobileMoney API to push data. This is optional; if you wish to specify different callback urls for different use cases, you can pass the callback url with each request seperately. Otherwise you can use `setCallbackUrl()` to set and `getCallbackUrl()` function to get the callback url.

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
use momopsdk\Common\Models\DepositModel;
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

In the above code the variables `$sDisbursementSubKey` is the subscription key of disbursement product that is getting from the user profile and `$targetEnvironment` is the target environment. In sandbox environment use `sandbox`.

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
    <td>getAccountBalance</td>
    <td>string $sCollectionSubKey, string $targetEnvironment</td>
  </tr>
  <tr>
    <td>Get Account Balance In Specific Currency</td>
    <td><a href="docs/Collection/GetAccountBalanceInSpecificCurrency.readme.md">Get Account Balance In Specific Currency</a></td>
    <td>getAccountBalanceInSpecificCurrency</td>
    <td>string $sSubsKey, string $sTargetEnvironment, string $sCurrency</td>
  </tr>
  <tr>
    <td>Get Basic User Info</td>
    <td><a href="docs/Collection/GetBasicUserInfo.readme.md">Get Basic User Info</a></td>
    <td>getBasicUserinfo</td>
    <td>string $accountHolderMSISDN, string $sCollectionSubKey, string $targetEnvironment</td>
  </tr>
  <tr>
    <td>Get User Info With Consent</td>
    <td><a href="docs/Collection/GetUserInfoWithConsent.readme.md">Get User Info With Consent</a></td>
    <td>getUserInfoWithConsent</td>
    <td>string $sCollectionSubKey, string $targetEnvironment</td>
  </tr>
  <tr>
    <td>Request To Pay</td>
    <td><a href="docs/Collection/RequestToPay.readme.md">Request To Pay</a></td>
    <td>requestToPay</td>
    <td>Transaction $transaction, string $sCollectionSubKey, string $targetEnvironment, string $callBackUrl=null, string $contentType=null</td>
  </tr>
  <tr>
    <td>Request To Pay Delivery Notification</td>
    <td><a href="docs/Collection/RequestToPayDeliveryNotification.readme.md">Request To Pay Delivery Notification</a></td>
    <td>requestToPayDeliveryNotification</td>
    <td>string $referenceId, string $notificationMessage, string $sCollectionSubKey, string $targetEnvironment,DeliveryNotification $deliveryNotification, string $callbackUrl, string $contentType</td>
  </tr>
  <tr>
    <td>Request To Pay Transaction Status</td>
    <td><a href="docs/Collection/RequestToPayTransactionStatus.readme.md">Request To Pay Transaction Status</a></td>
    <td>requestToPayTransactionStatus</td>
    <td>string $referenceId, string $sCollectionSubKey, string $targetEnvironment</td>
  </tr>
  <tr>
    <td>Request To Withdraw Transaction Status</td>
    <td><a href="docs/Collection/RequestToWithdrawStatus.readme.md">Request To Withdraw Transaction Status</a></td>
    <td>requestToWithdrawTransactionStatus</td>
    <td>string $referenceId, string $sCollectionSubKey, string $targetEnvironment</td>
  </tr>
  <tr>
    <td>Request To Withdraw V1</td>
    <td><a href="docs/Collection/RequestToWithdrawV1.readme.md">Request To Withdraw V1</a></td>
    <td>requestToWithdrawV1</td>
    <td>Transaction $transaction, string $sCollectionSubKey, string $targetEnvironment, string $sCallbackUrl, string $sContentType</td>
  </tr>
  <tr>
    <td>Request To Withdraw V2</td>
    <td><a href="docs/Collection/RequestToWithdrawV2.readme.md">Request To Withdraw V2</a></td>
    <td>requestToWithdrawV2</td>
    <td>Transaction $transaction, string $sCollectionSubKey, string $targetEnvironment, string $sCallbackUrl, string $sContentType</td>
  </tr>
  <tr>
    <td>Validate Account Holder Status</td>
    <td><a href="docs/Collection/ValidateAccountHolder.readme.md">Validate Account Holder Status</a></td>
    <td>validateAccountHolderStatus</td>
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
    <td>Deposit V1</td>
    <td><a href="docs/Disbursement/DepositV1.readme.md">Deposit V1 </a></td>
    <td>depositV1</td>
    <td>DepositModel $oReqDataObject, string $sDisbursementSubKey, string targetEnvironment, string $callbackUrl</td>
  </tr>
  <tr>
    <td>Deposit V2</td>
    <td><a href="docs/Disbursement/DepositV2.readme.md">Deposit V2</a></td>
    <td>depositV2</td>
    <td>DepositModel $oReqDataObject, string $sDisbursementSubKey, string targetEnvironment, string $callbackUrl</td>
  </tr>
  <tr>
    <td>Get Account Balance</td>
    <td><a href="docs/Disbursement/GetAccountBalance.readme.md">Get Account Balance</a></td>
    <td>getAccountBalance</td>
    <td>string $sDisbursementSubKey, string $targetEnvironment</td>
  </tr>
  <tr>
    <td>Get Account Balance In Specific Currency</td>
    <td><a href="docs/Disbursement/GetAccountBalanceInSpecificCurrency.readme.md">Get Account Balance In Specific Currency</a></td>
    <td>getAccountBalanceInSpecificCurrency</td>
    <td>string $sDisbursementSubKey, string $targetEnvironment, 'EUR'</td>
  </tr>
  <tr>
    <td>Get Basic User Info</td>
    <td><a href="docs/Disbursement/GetBasicUserInfo.readme.md">Get Basic User Info</a></td>
    <td>getBasicUserinfo</td>
    <td>string $accountHolderMSISDN, string $sDisbursementSubKey, string $targetEnvironment</td>
  </tr>
  <tr>
    <td>Get Deposit Status</td>
    <td><a href="docs/Disbursement/GetDepositStatus.readme.md">Get Deposit Status</a></td>
    <td>getDepositStatus</td>
    <td>string $sDisbursementSubKey, string $targetEnvironment, string $sRefId</td>
  </tr>
  <tr>
    <td>GetRefundStatus</td>
    <td><a href="docs/Disbursement/GetRefundStatus.readme.md">GetRefundStatus</a></td>
    <td>getRefundStatus</td>
    <td>string $sDisbursementSubKey, string $targetEnvironment, string $sRefId</td>
  </tr>
  <tr>
    <td>Get Transfer Status</td>
    <td><a href="docs/Disbursement/GetTransferStatus.readme.md">Get Transfer Status</a></td>
    <td>getTransferStatus</td>
    <td>string $sDisbursementSubKey, string $targetEnvironment, string $sRefId</td>
  </tr>
  <tr>
    <td>Get User Info With Consent</td>
    <td><a href="docs/Disbursement/GetUserInfoWithConsent.readme.md">Get User Info With Consent</a></td>
    <td>getUserInfoWithConsent</td>
    <td> string $sDisbursementSubKey, string $targetEnvironment</td>
  </tr>
  <tr>
    <td>Refund V1</td>
    <td><a href="docs/Disbursement/RefundV1.readme.md">Refund V1</a></td>
    <td>refundV1</td>
    <td>RefundModel $oReqDataObject, string $sDisbursementSubKey, string $targetEnvironment, string $callbackUrl</td>
  </tr>
  <tr>
    <td>Refund V2</td>
    <td><a href="docs/Disbursement/RefundV2.readme.md">Refund V2</a></td>
    <td>refundV2</td>
    <td>RefundModel $oReqDataObject, string $sDisbursementSubKey, string $targetEnvironment, string $callbackUrl</td>
  </tr>
  <tr>
    <td>Request To Pay Delivery Notification</td>
    <td><a href="docs/Disbursement/RequestToPayDeliveryNotification.readme.md">Request To Pay Delivery Notification</a></td>
    <td>requestToPayDeliveryNotification</td>
    <td>string $referenceId, string $notificationMessage, string $sDisbursementSubKey, string $targetEnvironment, DeliveryNotification $deliveryNotification, string $language, string $contentType</td>
  </tr>
  <tr>
    <td>Transfer</td>
    <td><a href="docs/Disbursement/Transfer.readme.md">Transfer</a></td>
    <td>transfer</td>
    <td>DepositModel $oReqDataObject, string $sDisbursementSubKey, string $targetEnvironment, string $callbackUrl</td>
  </tr>
  <tr>
    <td>Validate Account Holder Status</td>
    <td><a href="docs/Disbursement/ValidateAccountHolderStatus.readme.md">Validate Account Holder Status</a></td>
    <td>validateAccountHolderStatus</td>
    <td></td>
  </tr>
</tbody>
</table>

### Remittance

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
    <td><a href="/docs/Remittance/GetAccountBalance.readme.md">Get Account Balance</a></td>
    <td>getAccountBalance</td>
    <td>string $sRemittanceSubKey, string $targetEnvironment</td>
  </tr>
  <tr>
    <td>Get Basic User Info</td>
    <td><a href="/docs/Remittance/GetBasicUserInfo.readme.md">Get Basic User Info</a></td>
    <td>getBasicUserinfo</td>
    <td>string $accountHolderMSISDN, string $sRemittanceSubKey, string $targetEnvironment</td>
  </tr>
  <tr>
    <td>Get Transfer Status</td>
    <td><a href="/docs/Remittance/GetTransferStatus.readme.md">Get Transfer Status</a></td>
    <td>getTransferStatus</td>
    <td>string $sRemittanceSubKey, string $targetEnvironment, string $sRefId</td>
  </tr>
  <tr>
    <td>Get User Info With Consent</td>
    <td><a href="/docs/Remittance/GetUserInfoWithConsent.readme.md">Get User Info With Consent</a></td>
    <td>getUserInfoWithConsent</td>
    <td>string $sRemittanceSubKey, string $targetEnvironment</td>
  </tr>

 <tr>
    <td>Request To Pay Delivery Notification</td>
    <td><a href="/docs/Remittance/RequestToPayDeliveryNotification.readme.md">Request To Pay Delivery Notification</a></td>
    <td>requestToPayDeliveryNotification</td>
    <td>string $referenceId, string $notificationMessage, string $sRemittanceSubKey, string $targetEnvironment, DeliveryNotification $deliveryNotification, string $language, string $contentType</td>
  </tr>
  <tr>
    <td>Transfer</td>
    <td><a href="/docs/Remittance/Transfer.readme.md">Transfer</a></td>
    <td>transfer</td>
    <td>DepositModel $oReqDataObject, string $sRemittanceSubKey, string $targetEnvironment, string $callbackUrl</td>
  </tr>
  <tr>
  <tr>
    <td>Validate Account Holder Status</td>
    <td><a href="/docs/Remittance/ValidateAccountHolderStatus.readme.md">Validate Account Holder Status</a></td>
    <td>validateAccountHolderStatus</td>
    <td>string $validateAccountHolderStatus, string $accountHolderIdType, string $sRemittanceSubKey, string $targetEnvironment</td>
  </tr>
</tbody>
</table>

### Sandbox User Provisioning

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
    <td>Create user</td>
    <td><a href="/docs/SandboxUserProvisioning/CreateApiUser.readme.md">Create Api User</a></td>
    <td>createUser</td>
    <td>array $aData, string $sCollectionSubKey</td>
  </tr>
  <tr>
    <td>Get User Details</td>
    <td><a href="/docs/SandboxUserProvisioning/GetApiUserDetails.readme.md">Get User Details</a></td>
    <td>getUserDetails</td>
    <td>string $sCollectionSubKey, string $sRefId</td>
  </tr>
  <tr>
    <td>Create API key</td>
    <td><a href="/docs/SandboxUserProvisioning/GetApiKey.readme.md">Create API key</a></td>
    <td>createApiKey</td>
    <td>string $sCollectionSubKey, string $sRefId</td>
  </tr>
</tbody>
</table>


## Tests

The `tests` folder contains the test cases. These are logically divided in unit and integration tests. Integration tests require an active `user id`, `api key`, `subscription keys`. To run tests provide necessary permission to the system user in the root folder to create the cache file. Auth cache will be created in the path `/var/auth.cache`. 

1. Install [Composer](https://getcomposer.org/download/)
2. From the root of the sdk-php project, run `composer install --dev` to install the dependencies
3. Copy `config.env.sample` to `config.env` and replace the template values by actual values

### Unit tests

These tests are located in `tests/Unit` and are responsible for ensuring each class is behaving as expected, without considering the rest of the system. Unit tests heavily leverage mocking and are an essential part of the testing harness.

To run unit tests,

```shell
composer run unit-test
```

To run tests individually (be sure not to be pointing to an integration test file):

```shell
composer run unit-test path/to/class/file
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

The sample code snippets are all completely independent and self-contained. You can analyze them to get an understanding of how a particular method can be implemented in your application. Sample code snippets can be found [here](/Sample). Steps to run the sample code snippets are as follows:

-   Clone this repository:

```
git clone git@github.com:gsmainclusivetechlab/momoapi-php-sdk.git
cd momoapi-php-sdk
```

-   Create config.env file for API credentials:

```
cp config.env.sample config.env
```

-   Set the API credentials in the config.env file:

e.g.

```
    reference_id = <User Id here>
    collection_subscription_key = <Collection subscription key obtained from user profile>
    disbursement_subscription_key = <Disbursement subscription key obtained from user profile>
    remittance_subscription_key = <Remittance subscription key obtained from user profile>
    momo_api_key = <User API key>
    target_environment = <Your Target environment here>
```

-   Run each sample directly from the command line. For example:

```
php -f Sample/Disbursements/DepositV1.php
```

## Folder Permissions

If needed, provide permission to the server user in the root folder of the SDK inorder to create authorization cache file. Authorization cache would be created in path 'var/auth.cache'.