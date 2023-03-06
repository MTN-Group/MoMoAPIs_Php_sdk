<?php

namespace momopsdk\Common\Cache;

use momopsdk\Common\Models\AuthToken;
use momopsdk\Common\Constants\MobileMoney;

abstract class AuthorizationCache
{
    public static $CACHE_PATH = '/../../../var/auth.cache';

    /**
     * A pull method which would read the persisted data based on clientId.
     * If clientId is not provided, an array with all the tokens would be passed.
     *
     * @param array|null $config
     * @param string $clientId
     * @return mixed|null
     */
    public static function pull($clientId, $authType)
    {
        $tokens = null;
        $cachePath = self::cachePath();
        if (file_exists($cachePath)) {
            // Read from the file
            $cachedToken = file_get_contents($cachePath);
            if ($cachedToken) {
                $tokens = json_decode($cachedToken, true);
                if (
                    $clientId &&
                    is_array($tokens) &&
                    array_key_exists($clientId, $tokens)
                ) {
                    $obj = new AuthToken;
                    if (isset($tokens[$clientId][$authType])) {
                        $obj->setAuthToken($tokens[$clientId][$authType]['authToken'])
                            ->setExpiresIn($tokens[$clientId][$authType]['expiresIn'])
                            ->setCreatedAt($tokens[$clientId][$authType]['createdAt'])
                            ->setTokenIdentifier($tokens[$clientId][$authType]['clientId'])
                            ->setTokenType($authType);
                    }
                    return $obj;
                    // If client Id is found, just send in that data only
                    return new AuthToken((object) $tokens[$clientId]);
                } elseif ($clientId) {
                    // If client Id is provided, but no key in persisted data found matching it.
                    return null;
                }
            }
        }
        return $tokens;
    }

    /**
     * Persists the data into a cache file provided in $CACHE_PATH
     *
     * @param array|null $config
     * @param      $clientId
     * @param      $accessToken
     * @param      $tokenCreateTime
     * @param      $tokenExpiresIn
     * @throws \Exception
     */
    public static function push(AuthToken $authObj, $clientId, $authType)
    {
        $cachePath = self::cachePath();
        if (
            !is_dir(dirname($cachePath)) &&
            !mkdir(dirname($cachePath), 0755, true)
        ) {
            throw new \momopsdk\Common\Exceptions\MobileMoneyException(
                "Failed to create directory at: $cachePath"
            );
        }

        // Reads all the existing persisted data
        $tokens = self::pull($clientId, $authType);
        $tokens = $tokens ? $tokens : [];
        
        if (!is_array($tokens)) {
            $token = [];
            $token[$clientId][$authType] = [
                'clientId' => $tokens->tokenIdentifier,
                'authToken' => $authObj->getAuthToken(),
                'createdAt' => $authObj->getCreatedAt(),
                'expiresIn' => $authObj->getExpiresIn()
            ];
            $tokens = $token;
        }
        if (is_array($tokens)) {
            $tokens[$clientId][$authType] = [
                'clientId' => $clientId,
                'authToken' => $authObj->getAuthToken(),
                'createdAt' => $authObj->getCreatedAt(),
                'expiresIn' => $authObj->getExpiresIn()
            ];
        }
        if (!file_put_contents($cachePath, json_encode($tokens))) {
            throw new \momopsdk\Common\Exceptions\MobileMoneyException(
                'Failed to write cache'
            );
        }
    }

    /**
     * Returns the cache file path
     *
     * @param $config
     * @return string
     */
    public static function cachePath()
    {
        $cachePath = MobileMoney::getCachePath();
        return empty($cachePath) ? __DIR__ . self::$CACHE_PATH : $cachePath;
    }
}
