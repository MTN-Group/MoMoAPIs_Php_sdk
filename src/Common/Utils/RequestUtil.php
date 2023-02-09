<?php

namespace momopsdk\Common\Utils;

use stdClass;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Utils\AuthUtil;
use momopsdk\Common\Models\Response;

class RequestUtil
{
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
    protected $_methods = ['POST', 'GET'];

    /**
     * cURL options
     *
     * @var array
     */
    protected $_options = [];

    /**
     * cURL data params
     *
     * @var mixed
     */
    protected $_params = [];

    /**
     * cURL URL
     *
     * @var string
     */
    protected $_url = '';

    /**
     * cURL url params
     *
     * @var mixed
     */
    protected $_urlParams = [];

    /**
     * Content Type
     *
     * @var array
     */
    protected $_contentType = false;

    /**
     * Curl Handle
     *
     * @var mixed
     */
    protected $_curlHandle = null;

    /**
     * Auth token
     *
     * @var array
     */
    protected $_referenceId = null;

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

    /**
     * Check if cURL is enabled
     *
     * @return  bool
     */
    protected function _isEnabled()
    {
        return function_exists('curl_init');
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
            default:
                throw new \momopsdk\Common\Exceptions\MobileMoneyException(
                    "Unknown Request Method: $method"
                );
                break;
        }

        if ($this->_url != API::ACCESS_TOKEN) {
            $this->buildAuthHeaders();
        }

        if ($this->_clientCorrelationId) {
            $this->option(
                'CURLOPT_HTTPHEADER',
                Header::X_CORELLATION_ID . ': ' . $this->_clientCorrelationId
            );
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

    private function buildAuthHeaders()
    {
        AuthUtil::buildHeader($this, $this->_params);
    }

    public function setReferenceId($referenceId)
    {
        $this->_referenceId = $referenceId;
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
}