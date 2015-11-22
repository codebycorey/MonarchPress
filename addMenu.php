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

?>
