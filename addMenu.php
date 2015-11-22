<?php
add_action( 'admin_menu', 'register_menu_page' );

function register_menu_page() {
   $page_title = 'MonarchPress Settings';
   $menu_title = 'MonarchPress';
   $capability = 'manage_options';
   $menu_slug = 'monarchpress/monarchPressMenu.php';
   $position = 7.7;
   add_menu_page ( $page_title, $menu_title, $capability, $menu_slug, '', '', $position );
}

function my_plugin_menu() {
   add_options_page( 'My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', 'my_plugin_options' );
}

function my_plugin_options() {
   if ( !current_user_can( 'manage_options' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
   }
   echo '<div class="wrap">';
   echo '<p>Here is where the form would go if I actually had options.</p>';
   echo '</div>';
}
?>
