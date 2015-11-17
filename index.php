<?php
/*
Plugin Name: Monarch Press
Plugin URI:
Description: TODO
Author: Green Team
Version: 0.1
Author URI: http://www.cs.odu.edu/~411green/
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

    public function widget()
    {

    }

}

add_action('widgets_init', 'register_monarchpress_twitter_widget');
function register_monarchpress_twitter_widget()
{
    register_widget('MonarchPress_Twitter_Widget');
}



?>
