# Get the User Info with consent

1.	`getUserInfoWithConsent($sRemittanceSubKey, $targetEnvironment).This operation is used to claim a consent by the account holder for the requested scopes.`
2. `Request data prepared using DepositModel.`

> `End user will get 200 as response on success. `

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Remittance\Remittance;
use momopsdk\Common\Constants\MobileMoney;

try {

    $bcAuthorizeFormData = "login_hint=ID:msisdn/msisdn&scope=profile&access_type=online";
    $Oauth2TokenFormData = "grant_type=urn:openid:params:grant-type:ciba&auth_req_id={auth_req_id}";
    MobileMoney::setBcAuthorizeFormData($bcAuthorizeFormData);
    MobileMoney::setOauth2TokenFormData($Oauth2TokenFormData);
    $request = Remittance::getUserInfoWithConsent($sRemittanceSubKey, $targetEnvironment);

    $response = $request->execute();
    print_r($response);
} catch (Throwable $e) {
    print_r($e);
}

```

### Example Output
`200 OK`

```php

momopsdk\Common\Models\UserDetail Object
(
    [result] => stdClass Object
        (
            [sub] => 0
            [name] => Sand Box
            [given_name] => Sand
            [family_name] => Box
            [birthdate] => 1976-08-13
            [locale] => sv_SE
            [gender] => MALE
            [updated_at] => 1678954231
        )

    [httpCode] => 200
)

```

