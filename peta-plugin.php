<?php
/*
* Plugin Name: PETA Code Challenge Plugin
* Plugin URI: https://www.peta.prg
* Description: Code Challenge for PETA - develop a WP plugin to fetch recently posts & display as widget on home admin view.
* Version: 1.0
* Author: Catherine Jarocki
* Author URI: https://github.com.cjaro
*/


/** step 1 - create menu option */
add_action( 'admin_menu', 'peta_plugin_menu' );

/** Step 1. */
function peta_plugin_menu() {
	add_options_page( 'My Plugin Options', 'PETA Code Challenge Plugin', 'manage_options', 'my-unique-identifier', 'peta_plugin_options' );
}

/** Step 3. */
function peta_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo '<p>Here is where the form would go if I actually had options.</p>';
	echo '</div>';
}
?>
