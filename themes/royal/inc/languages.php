<?php
// Localization
function royal_localization( ) {
	load_theme_textdomain( 'royal', get_template_directory( ) . '/languages' );
}

add_action( 'after_setup_theme', 'royal_localization' );
