<?php
ini_set('display_errors', 1);

require_once('config/config.php');
require_once('TwitterAPI.php');



add_shortcode('twitter', function($atts, $content) {
    $atts = shortcode_atts(
        array(
            'username' => 'ODUMonarchPress',
            'content' => !empty($content) ? $content: 'Follow me on Twitter!',
            'show_tweets' => false,
            'tweet_reset_time' => 10,
            'num_tweets' => 5
        ), $atts
    );

    extract($atts);

    if ($show_tweets) {
        $tweets = fetch_tweets($num_tweets, $username, $tweet_reset_time);
    }
    return 'hi';
});

function fetch_tweets($num_tweets, $username, $tweet_reset_time)
{

}

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
        // var_dump($data)
        if (false !== $data && isset($data->tweets)) {
            echo $before_widget;
                echo $before_title;
                    echo $title;
                echo $after_title;

            echo '<ul><li>' . implode('</li><li>', $data->tweets). '</li></ul>';
            echo $after_widget;
        }
    }

    private function twitter($tweet_count, $username)
    {

        if (empty($username)) return false;

        $tweets = get_transient('recent_tweets_widget');

        if (!$tweets ||
            $tweets->username !== $username ||
            $tweets->tweet_count !== $tweet_count) {
            return $this->fetch_tweets($tweet_count, $username);
        }

        return $tweets;
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
        $tweets = $twitter->setParams($paramfield)
                          ->buildOauth($url)
                          ->performRequest();
        $tweets = json_decode($tweets);
        // TODO : Code for error

        $data = new stdClass();
        $data->username = $username;
        $data->tweet_count = $tweet_count;
        $data->tweets = array();

        foreach($tweets as $tweet) {
            if ($tweet_count-- === 0) break;
            $data->tweets[] = $this->filter_tweet($tweet->text);
        }

        set_transient('recent_tweets_widget', $data, 60* 5);

        return $data;
    }

    private function filter_tweet($tweet)
    {
        $tweet = preg_replace('/(http[^\s]+)/im', '<a href="$1">$1</a>', $tweet);
        $tweet = preg_replace('/@([^\s]+)/i', '<a href="http://twitter.com/$1">@$1</a>', $tweet);
        return $tweet;

    }

}

add_action('widgets_init', 'register_monarchpress_twitter_widget');
function register_monarchpress_twitter_widget()
{
    register_widget('MonarchPress_Twitter_Widget');
}





?>