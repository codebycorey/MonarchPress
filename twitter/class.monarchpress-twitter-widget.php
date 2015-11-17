<?php
ini_set('display_errors', 1);

require_once('config/config.php');
require_once('TwitterAPI.php');




/**
 * Wordpress Widget that displays tweets.
 *
 * @package MonarchPress
 * @author Corey O'Donnell <rcoreyodonnell@gmail.com>
 * @version 1.0
 */
class MonarchPress_Twitter_Widget extends WP_Widget {

    function __construct()
    {
        $options = array(
            'description' => 'Display and cache tweets',
            'name' => 'Display Tweets'
        );
        parent::__construct('MonarchPress_Twitter_Widget', '', $options);
    }

    public function form($instance)
    {
        extract($instance);
        ?>
        <p>
            <label for="<? echo $this->get_field_id('title');?>">Title: </label>
            <input type="text" class="widefat"
                   id="<? echo $this->get_field_id('title');?>"
                   name="<? echo $this->get_field_name('title')?>"
                   value="<? if(isset($title)) echo esc_attr($title);?>">
        </p>

        <p>
            <label for="<? echo $this->get_field_id('username');?>">Twitter Username: </label>
            <input type="text" class="widefat"
                   id="<? echo $this->get_field_id('username');?>"
                   name="<? echo $this->get_field_name('username')?>"
                   value="<? if(isset($username)) echo esc_attr($username);?>">
        </p>

        <p>
            <label for="<? echo $this->get_field_id('tweet_count');?>">Number of Tweets to Retrieve: </label>
            <input type="number" class="widefat" style="width: 50px;"
                   id="<? echo $this->get_field_id('tweet_count');?>"
                   name="<? echo $this->get_field_name('tweet_count')?>"
                   min="1"
                   max="10"
                   value="<? echo !empty($tweet_count) ? $tweet_count : 5; ?>">
        </p>

        <?php
    }

    public function widget($args, $instance)
    {
        extract($args);
        extract($instance);

        $data = $this->twitter($tweet_count, $username);
    }

    private function twitter($tweet_count, $username)
    {

        if (empty($username)) return false;

        $this->fetch_tweets($tweet_count, $username);
    }

    private function fetch_tweets($tweet_count, $username)
    {
        $settings = array(
            'oauth_access_token' => OAUTH_ACCESS_TOKEN,
            'oauth_access_token_secret' => OAUTH_ACCESS_TOKEN_SECRET,
            'consumer_key' => CONSUMER_KEY,
            'consumer_secret' => CONSUMER_SECRET
        );

        $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

        $paramfield = "?screen_name=$username";

        $twitter = new TwitterAPI($settings);
        $twitter->setParams($paramfield)
                ->buildOauth($url)
                ->performRequest();
        print_r($twitter->performRequest());

        return $twitter;
    }

}

add_action('widgets_init', 'register_monarchpress_twitter_widget');
function register_monarchpress_twitter_widget()
{
    register_widget('MonarchPress_Twitter_Widget');
}





?>