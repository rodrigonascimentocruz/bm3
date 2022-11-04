<?php	
/** Functions file for Royal Child Theme **/

/* Enqueue parent styles */
function theme_enqueue_styles() {	
	wp_enqueue_style( 'royal-child-style', get_stylesheet_directory_uri() . '/style.css' );
}

add_action('wp_enqueue_scripts', 'theme_enqueue_styles', 11);
?>
