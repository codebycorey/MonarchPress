<?php
/*
Plugin Name: Monarch Press
Plugin URI:
Description: TODO
Author: Green Team
Version: 0.1
Author URI: http://www.cs.odu.edu/~411green/
*/

define( 'MONARCHPRESS__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'MONARCHPRESS__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( MONARCHPRESS__PLUGIN_DIR . 'twitter/class.monarchpress-twitter-widget.php' );

?>
