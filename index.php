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

    public function form()
    {

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
