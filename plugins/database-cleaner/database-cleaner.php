<?php
/*
Plugin Name: Database Cleaner and Optimizer (Built for 2022+)
Plugin URI: https://meowapps.com
Description: Clean and optimize your database, for real! Lot of features, handle oversized databases, built on latest WP and PHP evolutions.
Version: 0.5.1
Author: Jordy Meow
Author URI: https://meowapps.com
Text Domain: database-cleaner

Dual licensed under the MIT and GPL licenses:
http://www.opensource.org/licenses/mit-license.php
http://www.gnu.org/licenses/gpl.html
*/

define( 'DBCLNR_VERSION', '0.5.1' );
define( 'DBCLNR_PREFIX', 'dbclnr' );
define( 'DBCLNR_DOMAIN', 'database-cleaner' );
define( 'DBCLNR_ENTRY', __FILE__ );
define( 'DBCLNR_PATH', dirname( __FILE__ ) );
define( 'DBCLNR_URL', plugin_dir_url( __FILE__ ) );

require_once( 'classes/init.php' );

?>
