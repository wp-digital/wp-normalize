<?php
/**
 * Plugin Name: Normalize
 * Description: Disables probably unnecessary WordPress features, and a little changes behaviour.
 * Version: 1.3.1
 * Author: Innocode
 * Author URI: https://innocode.com
 * Tested up to: 5.4
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

require_once __DIR__ . '/src/normalize.php';
