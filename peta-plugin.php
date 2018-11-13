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
function petaplugin_register_plugin_styles() {
	wp_register_style( 'peta-plugin', plugins_url( 'peta-plugin/peta-plugin.css' ) );
	wp_enqueue_style( 'peta-plugin' );
}

// Register style sheet.
add_action( 'wp_enqueue_scripts', 'petaplugin_register_plugin_styles' );

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
    echo "Hello <strong>" . $user->user_firstname . " " . $user->user_lastname . "</strong>, this is the PETA code challenge custom widget.";

    /*
    * WP REST API tinkering
    */
    // Get the JSON
    // I'm using this https://v2.wp-api.org/reference/posts/ and I think that if I keep picking away it'll come aorund. I think using the 'status' and 'date' params will produce the best path forward.

    $posts1 = json_decode(file_get_contents('http://www.brandpoint.com/wp-json/wp/v2/posts?filter[posts_per_page]=10&filter[orderby]=date'));
    echo "Posts from Site 1 (" . $posts1->id . "):<br>";
    foreach ( $posts1 as $post1 ) {
      echo '<a href="'.$post1->link.'">'.$post1->title->rendered.'</a>' . '<div class="pp-btns-div">
        <button class="pp-btn-appr">Approve</button>
        <button class="pp-btn-deny">Deny</button>
        </div>' . '<br>';
    }
    echo "<br><br>";
    $posts2 = json_decode(file_get_contents('http://www.aimclearblog.com/wp-json/wp/v2/posts?filter[posts_per_page]=10&filter[orderby]=date'));

    foreach ( $posts2 as $post2 ) {
      echo '<a href="'.$post2->link.'">'.$post2->title->rendered.'</a>' . '<div class="pp-btns-div">
        <button class="pp-btn-appr">Approve</button>
        <button class="pp-btn-deny">Deny</button>
        </div>' . '<br>';
    }
    echo "<br><br>";
    $posts3 = json_decode(file_get_contents('http://www.diedrichrpm.com/wp-json/wp/v2/posts?filter[posts_per_page]=10&filter[orderby]=date'));
  echo "Posts from Site 3 (" . $posts3->id . "):<br>";
    foreach ( $posts3 as $post3 ) {
      echo '<a href="'.$post3->link.'">'.$post3->title->rendered.'</a>' . '<div class="pp-btns-div">
        <button class="pp-btn-appr">Approve</button>
        <button class="pp-btn-deny">Deny</button>
        </div>' . '<br>';
    }
  //   $json = file_get_contents('https://www.brandpoint.com/wp-json/wp/v2/posts');
  //   // Convert the JSON to an array of posts
  //   $posts = json_decode($json);
  //   foreach ($posts as $p) {
  //       echo '<p>Title: ' . $p->title . '</p>';
  //       echo '<p>Date:  ' . date('F jS', strtotime($p->date)) . '</p>';
  //       // Output the featured image (if there is one)
  //       echo $p->featured_image ? '<img src="' . $p->featured_image->guid . '">' : '';
  //   }
   }
/** step 1 - create menu option */
add_action( 'admin_menu', 'peta_plugin_menu' );

/** Step 1. */
function peta_plugin_menu() {
	add_options_page( 'PETA Plugin Options', 'PETA Code Challenge Plugin', 'manage_options', 'my-unique-identifier', 'peta_plugin_options' );
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


?>
