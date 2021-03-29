<?php
/**
 * Plugin Name: Normalize
 * Description: Disables probably unnecessary WordPress features, and a little changes behaviour.
 * Version: 2.0.0
 * Author: Innocode
 * Author URI: https://innocode.com
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

define( 'INNOCODE_NORMALIZE_VERSION', '2.0.0' );
define( 'INNOCODE_NORMALIZE_FILE', __FILE__ );

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

require_once __DIR__ . '/src/normalize.php';
