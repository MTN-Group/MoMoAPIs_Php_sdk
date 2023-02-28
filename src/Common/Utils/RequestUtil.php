<?php

namespace momopsdk\Common\Utils;

use stdClass;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Utils\AuthUtil;
use momopsdk\Common\Models\Response;
use momopsdk\Common\Constants\ProductUniqueIdentifier;

/**
 * Class RequestUtil
 * @package momopsdk\Common\Utils
 */
class RequestUtil
{
    /**
     * Token Identifier
     * @var string
     */
    public $tokenIdentifier = null;
    /**
     * cURL request method
     *
     * @var string
     */
    protected $_method = 'GET';

    /**
     * Currently accepted cURL request method types
     *
     * @var array
     */
    protected $_methods = ['POST', 'GET', 'PATCH'];

    /**
     * cURL URL
     *
     * @var string
     */
    protected $_url = '';

    /**
     * cURL data params
     *
     * @var mixed
     */
    protected $_params = [];

    /**
     * cURL url params
     *
     * @var mixed
     */
    protected $_urlParams = [];

    /**
     * cURL options
     *
     * @var array
     */
    protected $_options = [];

    /**
     * cURL user agent
     *
     * @var array
     */
    protected $_agent = 'ground(ctrl) engine';

    /**
     * Content Type
     *
     * @var array
     */
    protected $_contentType = false;

    /**
     * Auth token
     *
     * @var array
     */
    protected $_referenceId = null;

    /**
     * Curl Handle
     *
     * @var mixed
     */
    protected $_curlHandle = null;

    /**
     * Subscription Key
     */
    protected $subscriptionKey;

    /**
     * GET request
     *
     * @param   string  $url
     * @param   array   $params
     * @param   array   $options
     * @return  mixed
     */
    public static function get($url = '', $params = [], $options = [])
    {
        return self::make($url, $params, $options, 'GET');
    }

    /**
     * POST request
     *
     * @param   string  $url
     * @param   array   $params
     * @param   array   $options
     * @return  mixed
     */
    public static function post($url = '', $params = [], $options = [])
    {
        return self::make($url, $params, $options, 'POST');
    }

    /**
     * PATCH request
     *
     * @param   string  $url
     * @param   array   $params
     * @param   array   $options
     * @return  mixed
     */
    public static function patch($url = '', $params = [], $options = [])
    {
        return self::make($url, $params, $options, 'PATCH');
    }

    /**
     * Make request
     *
     * @param   string  $url
     * @param   array   $params
     * @param   array   $options
     * @param   string  $method
     * @return  Curl
     */
    public static function make(
        $url = '',
        $params = [],
        $options = [],
        $method = null
    ) {
        return new self($url, $params, $options, $method);
    }

    public function __construct(
        $url = '',
        $params = [],
        $options = [],
        $method = null
    ) {
        // Set request method
        if ($method) {
            $this->_method = $method;
        }

        // Explode the URL to get the URL params
        $url_split = explode('?', $url);

        // Request URL is everything before the ? (if it exists)
        $this->_url = $url_split[0];

        // If there were URL params, add it to the params array
        $this->_params = (array) $params;

        // Set the passed options
        $this->_options($options);
    }

    /**
     * Add multiple params
     *
     * @param   array   $keys
     * @return  Curl
     */
    public function params($keys = [])
    {
        $this->_params = array_merge($this->_params, (array) $keys);

        return $this;
    }

    /**
     * Add a single param
     *
     * @param   string  $key
     * @param   string  $value
     * @return  Curl
     */
    public function param($key = '', $value = '')
    {
        if (!empty($key) && is_string($key)) {
            $key = [
                $key => (string) $value
            ];
        }

        return $this->params($key);
    }

    /**
     * Add multiple options
     *
     * @param   array   $options
     * @return  Curl
     */
    public function options($options = [])
    {
        $this->_options($options);

        return $this;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * Add single option
     *
     * @param   string  $key
     * @param   string  $value
     * @return  Curl
     */
    public function option($key = '', $value = '')
    {
        if (!is_null($value)) {
            $this->_option($key, $value);
        }

        return $this;
    }

    /**
     * Request method
     *
     * @param   string  $method
     * @return  Curl
     */
    public function method($method = null)
    {
        $this->_method = $method;

        return $this;
    }

    /**
     * User agent
     *
     * @param   string  $agent
     * @return  Curl
     */
    public function agent($agent = '')
    {
        if ($agent) {
            return $this->option('CURLOPT_USERAGENT', $agent);
        }

        return $this;
    }

    /**
     * Proxy helper
     *
     * @param   string  $url
     * @param   int     $port
     * @return  Curl
     */
    public function proxy($url = '', $port = 80)
    {
        return $this->options([
            'CURLOPT_HTTPPROXYTUNNEL' => true,
            'CURLOPT_PROXY' => $url . ':' . $port
        ]);
    }

    /**
     * Custom header helper
     *
     * @param   string  $header
     * @param   string  $content
     * @return  Curl
     */
    public function httpHeader($header, $content = null)
    {
        if ($header == Header::CONTENT_TYPE) {
            $this->_contentType = true;
        }

        $header = $content ? $header . ': ' . $content : $header;
        return $this->option(CURLOPT_HTTPHEADER, $header);
    }

    /**
     * SSL helper
     *
     * @param   bool    $verify_peer
     * @param   int     $verify_host
     * @param   string  $path_to_cert
     * @return  Curl
     */
    public function ssl(
        $verify_peer = true,
        $verify_host = 2,
        $path_to_cert = null
    ) {
        if ($verify_peer) {
            $options = [
                'CURLOPT_SSL_VERIFYPEER' => true,
                'CURLOPT_SSL_VERIFYHOST' => $verify_host,
                'CURLOPT_CAINFO' => $path_to_cert
            ];
        } else {
            $options = [
                'CURLOPT_SSL_VERIFYPEER' => false
            ];
        }

        return $this->options($options);
    }

    /**
     * Execute request
     *
     * @return  Curl
     * @throws  MobileMoneyException
     */
    public function build()
    {
        // cURL is not enabled
        if (!$this->_isEnabled()) {
            throw new \momopsdk\Common\Exceptions\MobileMoneyException(
                __CLASS__ .
                    ': PHP was not built with cURL enabled. Rebuild PHP with --with-curl to use cURL.'
            );
        }

        // Request method
        $method = $this->_method ? strtoupper($this->_method) : 'GET';

        // Unrecognized request method?
        if (!in_array($method, $this->_methods)) {
            throw new \momopsdk\Common\Exceptions\MobileMoneyException(
                __CLASS__ . ': Unrecognized request method of ' . $this->_method
            );
        }

        return $this->_execute($method);
    }

    public function setUrlParams($params)
    {
        $this->_urlParams = $params;
        return $this;
    }

    public function setReferenceId($referenceId)
    {

        $this->_referenceId = $referenceId;
        return $this;
    }

    private function buildUrl($endpoint)
    {
        $baseUrl = MobileMoney::getBaseUrl();
        if ($this->_urlParams) {
            $endpoint = strtr($endpoint, $this->_urlParams);
        }
        return $baseUrl . $endpoint;
    }

    private function buildAuthHeaders()
    {
        AuthUtil::buildHeader($this, $this->_params);
    }

    /**
     * Alias for call();
     *
     * @return  Curl
     */
    public function execute()
    {
        return $this->build();
    }

    /**
     * Execute request
     *
     * @param   string  $method
     * @return  Curl
     */
    private function _execute($method)
    {
        // Method specific options
        switch ($method) {
            case 'GET':
                // Append GET params to URL
                $this->_url .= http_build_query($this->_params)
                    ? '?' . http_build_query($this->_params)
                    : '';

                // Set options
                $this->option('CURLOPT_HTTPGET', 1);
                break;

            case 'POST':
                // Set options
                $this->options([
                    'CURLOPT_CUSTOMREQUEST' => 'POST',
                    'CURLOPT_POSTFIELDS' => $this->_params[0]
                ]);
                if (!$this->_contentType) {
                    $this->option(
                        'CURLOPT_HTTPHEADER',
                        Header::CONTENT_TYPE . ': application/json'
                    );
                }
                break;

            case 'PATCH':
                // Set options
                $this->options([
                    'CURLOPT_CUSTOMREQUEST' => 'PATCH',
                    'CURLOPT_POSTFIELDS' => $this->_params[0]
                ]);
                if (!$this->_contentType) {
                    $this->option(
                        'CURLOPT_HTTPHEADER',
                        Header::CONTENT_TYPE . ': application/json'
                    );
                }
                break;
            default:
                throw new \momopsdk\Common\Exceptions\MobileMoneyException(
                    "Unknown Request Method: $method"
                );
                break;
        }

        if (
            $this->_url != API::DISBURSEMENT_ACCESS_TOKEN &&
            $this->_url != API::REMITTANCE_ACCESS_TOKEN &&
            $this->_url != API::COLLECTION_ACCESS_TOKEN &&
            $this->_url != API::CREATE_USER &&
            $this->_url != API::GET_USER_INFORMATION &&
            $this->_url != API::GET_API_KEY &&
            $this->_url != API::DISBURSEMENT_OAUTH2ACCESS_TOKEN &&
            $this->_url != API::REMITTANCE_OAUTH2ACCESS_TOKEN &&
            $this->_url != API::COLLECTION_OAUTH2ACCESS_TOKEN
        ) {
            $sProductName = explode('/', $this->_url)[1];
            switch ($sProductName) {
                case 'disbursement':
                    $this->tokenIdentifier = 'DISBURSEMENT';
                    # code...
                    break;
                case 'remittance':
                    $this->tokenIdentifier = 'REMITTANCE';
                    # code...
                    break;
                case 'collection':
                    $this->tokenIdentifier = 'COLLECTION';
                    # code...
                    break;
                default:
                    # code...
                    break;
            }
            $this->buildAuthHeaders();
        }

        if ($this->_referenceId) {
            $this->option(
                'CURLOPT_HTTPHEADER',
                Header::X_REFERENCE_ID . ': ' . $this->_referenceId
            );
        }
        if (!array_key_exists(CURLOPT_VERBOSE, $this->_options)) {
            $this->option('CURLOPT_VERBOSE', true);
        }
        // Set timeout option if it isn't already set
        if (!array_key_exists(CURLOPT_TIMEOUT, $this->_options)) {
            $this->option('CURLOPT_TIMEOUT', 30);
        }

        // Set returntransfer option if it isn't already set
        if (!array_key_exists(CURLOPT_RETURNTRANSFER, $this->_options)) {
            $this->option('CURLOPT_RETURNTRANSFER', true);
        }

        // Set user agent option if it isn't already set
        if (!array_key_exists(CURLOPT_USERAGENT, $this->_options)) {
            $this->option('CURLOPT_USERAGENT', $this->_agent);
        }

        // Enable Response Header
        if (!array_key_exists(CURLOPT_HEADER, $this->_options)) {
            $this->option('CURLOPT_HEADER', 1);
        }

        // Only set follow location if not running securely
        if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
            // Ok, follow location is not set already so lets set it to true
            if (!array_key_exists(CURLOPT_FOLLOWLOCATION, $this->_options)) {
                $this->option('CURLOPT_FOLLOWLOCATION', true);
            }
        }

        // Initialize cURL request
        // Check if URL contains base url if not build url with base url

        if (strpos($this->_url, 'http') !== false) {
            $ch = curl_init($this->_url);
        } else {
            $ch = curl_init($this->buildUrl($this->_url));
        }

        // Can't set the options in batch
        if (!function_exists('curl_setopt_array')) {
            foreach ($this->_options as $key => $value) {
                curl_setopt($ch, $key, $value);
            }
        }

        // Set options in batch
        else {
            curl_setopt_array($ch, $this->_options);
        }

        $this->_curlHandle = $ch;

        return $this;
    }

    public function call()
    {
        $ch = $this->_curlHandle;
        $output = curl_exec($ch);

        $outputData = $this->getResponseHeaders($output);
        $response = new Response();
        $response
            ->setResult($outputData['Data'])
            ->setInfo(curl_getinfo($ch))
            ->setHttpCode(curl_getinfo($ch, CURLINFO_HTTP_CODE))
            ->setError(curl_error($ch))
            ->setErrorCode(curl_errno($ch))
            ->setReferenceId($this->_referenceId)
            ->setHeaders($outputData['Headers'])
            ->setRequestObj($this);
        curl_close($ch);
        return $response;
    }

    /**
     * Add multiple options
     *
     * @param   array   $options
     */
    protected function _options($options = [])
    {
        foreach ((array) $options as $key => $value) {
            $this->_option($key, $value);
        }
    }

    protected function getResponseHeaders($response)
    {
        $lines = explode("\n", $response);
        $out = [];
        $headers = true;

        foreach ($lines as $l) {
            $l = trim($l);

            if ($headers && !empty($l)) {
                if (strpos($l, 'HTTP') !== false) {
                    $p = explode(' ', $l);
                    $out['Headers']['Status'] = trim($p[1]);
                } else {
                    $p = explode(':', $l);
                    $out['Headers'][$p[0]] = trim($p[1]);
                }
            } elseif (!empty($l)) {
                $out['Data'] = $l;
            }

            if (empty($l)) {
                $headers = false;
            }
        }
        return $out;
    }

    /**
     * Add single option
     *
     * @param   string  $key
     * @param   string  $value
     * @throws  MobileMoneyException
     */
    protected function _option($key = '', $value = '')
    {
        if (is_string($key) && !is_numeric($key)) {
            $const = strtoupper($key);
            if (defined($const)) {
                $key = constant(strtoupper($key));
            } else {
                throw new \momopsdk\Common\Exceptions\MobileMoneyException(
                    'Curl: Constant [' . $const . '] not defined.'
                );
            }
        }

        // Custom header
        if ($key == CURLOPT_HTTPHEADER) {
            $this->_options[$key][] = $value;
        }

        // Not a custom header
        else {
            $this->_options[$key] = $value;
        }
    }

    /**
     * Get query string from URL
     *
     * @param   $uri
     * @return  array
     */
    protected function _queryString($uri)
    {
        $query_data = [];

        $query_array = html_entity_decode(parse_url($uri, PHP_URL_QUERY));

        if (!empty($query_array)) {
            $query_array = explode('&', $query_array);

            foreach ($query_array as $val) {
                $x = explode('=', $val);

                $query_data[$x[0]] = $x[1];
            }
        }

        return $query_data;
    }

    /**
     * Check if cURL is enabled
     *
     * @return  bool
     */
    protected function _isEnabled()
    {
        return function_exists('curl_init');
    }

    public function setSubscriptionKey($sSubscriptionKey)
    {
        $this->subscriptionKey = $sSubscriptionKey;
        return $this;
    }

    public function getSubscriptionKey()
    {
        return $this->subscriptionKey;
    }

    public function setTokenType($tokenType)
    {
        $this->tokenType = $tokenType;
        return $this;
    }

    public function getTokenType()
    {
        return $this->tokenType;
    }
}
