# Get information about the user created in the sandbox environment

1.	`getBasicUserinfo($accountHolderMSISDN) creates a GET request to end point /collection/v1_0/accountholder/msisdn/{accountHolderMSISDN}/basicuserinfo and returns the informations about the user. The accountHolderMSISDN will be the partyId of the payer user.`

> `End user will get basic user info of the user.`

### Usage/Examples

```php

<?php
require_once __DIR__ . './../bootstrap.php';

use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Collection\Collection;

try {

    /**
     * Construct request object and set desired parameters
     */
    $accountHolderMSISDN = '0248888736';
    $request = Collection::getBasicUserinfo($accountHolderMSISDN);

    /**
     *Execute the request
     */
    $response = $request->execute();
    print_r($response);
} catch (MobileMoneyException $ex) {

    print_r($ex->getMessage());
    print_r($ex->getErrorObj());
}
```

### Example Output
`202 Accepted`
```php
momopsdk\Common\Models\CallbackResponse Object
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
            [updated_at] => 1676878958
        )

    [httpCode] => 200
    [referenceId] =>
    [hydratorStrategies:protected] =>
    [availableCount:protected] =>
)

```