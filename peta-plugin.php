<?php
/*
* Plugin Name: PETA Code Challenge Plugin
* Plugin URI: https://www.peta.prg
* Description: Code Challenge for PETA - develop a WP plugin to fetch recently posts & display as widget on home admin view.
* Version: 1.0
* Author: Catherine Jarocki
* Author URI: https://github.com.cjaro




* Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function petaplugin_add_dashboard_widgets() {

	wp_add_dashboard_widget(
                 'peta_plugin_widget',         // widget slug
                 'PETA Plugin Dashboard Widget',         // title
                 'petaplugin_dashboard_widget_function' // display function
        );
}
add_action( 'wp_dashboard_setup', 'petaplugin_add_dashboard_widgets' );

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function petaplugin_dashboard_widget_function() {

	// Display whatever it is you want to show.
	echo "Hello World, I'm a great Dashboard Widget";
}
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
	echo '<p>Manage PETA Plugin\'s Settings</p>';
	echo '</div>';
}
?>
