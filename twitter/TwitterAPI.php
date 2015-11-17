<?php

/**
 * Twitter API.
 *
 * @author Corey O'Donnell <rcoreyodonnell@gmail.com>
 * @version 1.0
 */
class TwitterAPI
{
    /**
     * @var string
     */
    private $oauth_access_token;
    /**
     * @var string
     */
    private $oauth_access_token_secret;
    /**
     * @var string
     */
    private $consumer_key;
    /**
     * @var string
     */
    private $consumer_secret;
    /**
     * @var string
     */
    private $getParams;

    /**
     * Create the object for the TwitterAPI and it requires an array of settings.
     * The settings require the config file.
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        extract($settings);

        $this->oauth_access_token = $oauth_access_token;
        $this->oauth_access_token_secret = $oauth_access_token_secret;
        $this->consumer_key = $consumer_key;
        $this->consumer_secret = $consumer_secret;
    }

    /**
     * Set getParams string.
     *
     * @param string $string
     *
     * @return object
     */
    public function setParams($string)
    {

        $getParams = preg_replace('/^\?/', '', explode('&', $string));
        $params = array();
        foreach ($getParams as $field)
        {
            if ($field !== '')
            {
                list($key, $value) = explode('=', $field);
                $params[$key] = $value;
            }
        }
        $this->getParams = '?' . http_build_query($params);

        return $this;
    }

    /**
     * Method to generate the base string for cURL.
     *
     * @param  string $baseURI
     * @param  string $method
     * @param  array $params
     *
     * @return string
     */
    private function buildBaseString($baseURI, $method, $params)
    {
        $return = array();
        ksort($params);
        foreach($params as $key => $value)
        {
            $return[] = rawurlencode($key) . '=' . rawurlencode($value);
        }

        return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $return));
    }

    /**
     * Build the Oauth object for the v1.1 Twitter API.
     *
     * @param  string $url
     * @return object
     */
    public function buildOauth($url)
    {

        $consumer_key = $this->consumer_key;
        $consumer_secret = $this->consumer_secret;
        $oauth_access_token = $this->oauth_access_token;
        $oauth_access_token_secret = $this->oauth_access_token_secret;

        $oauth = array(
            'oauth_consumer_key' => $consumer_key,
            'oauth_nonce' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token' => $oauth_access_token,
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0'
        );

        $getParams = $this->getParams();

        if (!is_null($getParams))
        {
            $getParams = str_replace('?', '', explode('&', $getParams));
            foreach ($getParams as $g)
            {
                $split = explode('=', $g);
                /** In case a null is passed through **/
                if (isset($split[1]))
                {
                    $oauth[$split[0]] = urldecode($split[1]);
                }
            }
        }
        $requestMethod = 'GET';
        $base_info = $this->buildBaseString($url, $requestMethod, $oauth);
        $composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
        $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $oauth['oauth_signature'] = $oauth_signature;

        $this->url = $url;
        $this->requestMethod = $requestMethod;
        $this->oauth = $oauth;

        return $this;
    }

    /**
     * Method to generate authorization header for cURL.
     *
     * @param  array  $oauth
     * @return string
     */
    private function buildAuthorizationHeader(array $oauth)
    {
        $return = 'Authorization: OAuth ';
        $values = array();

        foreach($oauth as $key => $value)
        {
            if (in_array($key, array('oauth_consumer_key', 'oauth_nonce', 'oauth_signature',
                'oauth_signature_method', 'oauth_timestamp', 'oauth_token', 'oauth_version'))) {
                $values[] = "$key=\"" . rawurlencode($value) . "\"";
            }
        }

        $return .= implode(', ', $values);
        return $return;
    }

    /**
     * Get getParams string.
     *
     * @return string $this->getParams
     */
    public function getParams()
    {
        return $this->getParams;
    }

    /**
     * Perform the request to the Twitter API.
     *
     * @return string
     */
    public function performRequest()
    {
        $curlOptions = array();
        $header =  array($this->buildAuthorizationHeader($this->oauth), 'Expect:');
        $getParams = $this->getParams();
        $options = array(
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_HEADER => false,
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
        ) + $curlOptions;
        if ($getParams !== '')
        {
            $options[CURLOPT_URL] .= $getParams;
        }
        $feed = curl_init();
        curl_setopt_array($feed, $options);
        $json = curl_exec($feed);
        if (($error = curl_error($feed)) !== '')
        {
            curl_close($feed);
            throw new \Exception($error);
        }
        curl_close($feed);
        return $json;
    }
}


?>