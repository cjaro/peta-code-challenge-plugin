<?php
/*
* Plugin Name: PETA Code Challenge Plugin
* Plugin URI: https://www.peta.prg
* Description: Code Challenge for PETA - develop a WP plugin to fetch recent posts & display as widget on home admin view.
* Version: 1.0
* Author: Catherine Jarocki
* Author URI: https://github.com.cjaro
*/
?>

<style>
.peta-plugin-options{
  display: flex;
  flex-direction: column;
}
.peta-plugin-options li{
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center
}
.pp-post-li{
  border-bottom: 1px solid #ddd;
    border-top: 1px solid #ddd;
  margin: 3px;
  padding: 3px;
}
.pp-date-div, .pp-post-li a, .pp-btns-div{
  width: 33%;
}
</style>

<?php

// Register style sheet.
add_action( 'wp_enqueue_scripts', 'register_petaplugin_styles' );

/**
 * Register style sheet.
 */
function register_petaplugin_styles() {
	wp_register_style( 'peta-plugin', plugins_url( 'peta-plugin/peta-plugin.css' ) );
	wp_enqueue_style( 'peta-plugin' );
}

/*
* Adding widget to dashboard
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

	// Display posts by logged in user.
  $user = wp_get_current_user();
    echo "Hello <strong>" . $user->user_firstname . " " . $user->user_lastname . "</strong>, this is the PETA code challenge custom widget (this is where the gathered posts will go). You can, for instance, list all the posts you've published:<br><br>";

    // The Query
$the_query = new WP_Query( apply_filters( 'widget_posts_args', array(
    'posts_per_page' => 10,
    'post_status' => 'publish',
    'author' => $user->ID
) ) );

// The Loop
if ( $the_query->have_posts() ) {
    echo '<div class="peta-plugin-options">';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
        echo '<li class="pp-post-li">' . '<a href="'. get_permalink() . '">' . get_the_title() . '</a>' . '<div class="pp-date-div">' . get_the_date('F j, Y') . ' </div> '. '
        <div class="pp-btns-div">
        <button class="pp-btn-appr">Approve</button>
        <button class="pp-btn-deny">Deny</button>
        </div></li>';
    }
    echo '</div>';
} else {
    // no posts found
}
/* Restore original Post Data */
wp_reset_postdata();

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
	echo '<p>' . petaplugin_dashboard_widget_function() . '</p>';
	echo '</div>';
}

/*
* RSS Work
*/
add_action('init', 'petaPluginRSS');
function petaPluginRSS(){
        add_feed('feedname', 'petapluginRSSFunc');
        global $wp_rewrite;
$wp_rewrite->flush_rules();
}
function petapluginRSSFunc(){
        get_template_part('rss', 'feedname');
}
?>
