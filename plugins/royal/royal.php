<?php
/*
Plugin Name: Royal Theme Features
Description: Core features for the Royal theme.
Version: 1.0
Author: AthenaStudio
Author URI: https://themeforest.net/user/athenastudio
License: GNU General Public License version 3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Text Domain: royal
*/

if ( ! function_exists( 'add_action' ) ) {
	echo 'Hi there! I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'ROYAL_PLUGIN_VERSION', '1.0' );
define( 'ROYAL_PLUGIN_DIR',      plugin_dir_path( __FILE__ ) );

// Localization
function royalPluginLocalization( ) {
	load_plugin_textdomain( 'royal', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

add_action( 'plugins_loaded', 'royalPluginLocalization' );

// Include features
require_once ROYAL_PLUGIN_DIR . 'shortcodes/class.shortcodes.php';
require_once ROYAL_PLUGIN_DIR . 'posts/class.posts.php';
require_once ROYAL_PLUGIN_DIR . 'options/class.options.php';
include ROYAL_PLUGIN_DIR . 'inc/twitter.php';

