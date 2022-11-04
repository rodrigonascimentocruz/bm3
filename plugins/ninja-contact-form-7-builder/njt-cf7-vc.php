<?php
/*
 * Plugin Name: Moana - Contact Form Seven CF7 Builder
 * Plugin URI: http://ninjateam.org
 * Description: Build your Contact Form 7 with an easiest way using WPBakery Page Builder.
 * Version: 1.5.7
 * Author: NinjaTeam
 * Author URI: http://ninjateam.org
 */

define('CF7_VC_DIR', realpath(plugin_dir_path(__FILE__)));
define('CF7_VC_URL', plugins_url('', __FILE__));
define('CF7_VC_FILE', __FILE__);
define('CF7_VC_LANG_PREFIX', 'cf7_vc');

require_once CF7_VC_DIR . '/autoload.php';

require_once CF7_VC_DIR . '/functions.php';

NjtCf7Vc::instance();
