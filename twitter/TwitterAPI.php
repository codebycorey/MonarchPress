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
}


?>