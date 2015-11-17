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
     * Set getParams string, example: '?screen_name=J7mbo'
     *
     * @param string $string Get key and value pairs as string
     *
     * @throws \Exception
     *
     * @return \TwitterAPIExchange Instance of self for method chaining
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
     * Build the Oauth object using params set in construct and additionals
     * passed to this method. For v1.1, see: https://dev.twitter.com/docs/api/1.1
     *
     * @param string $url           The API url to use. Example: https://api.twitter.com/1.1/search/tweets.json
     * @param string $requestMethod Either POST or GET
     *
     * @throws \Exception
     *
     * @return \TwitterAPIExchange Instance of self for method chaining
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
     * Get getParams string (simple getter)
     *
     * @return string $this->getParams
     */
    public function getParams()
    {
        return $this->getParams;
    }


    /**
     * Perform the actual data retrieval from the API
     *
     * @param boolean $return      If true, returns data. This is left in for backward compatibility reasons
     * @param array   $curlOptions Additional Curl options for this request
     *
     * @throws \Exception
     *
     * @return string json If $return param is true, returns json data.
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