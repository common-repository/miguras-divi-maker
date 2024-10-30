<?php
/*
* Plugin Name: DIVI Maker
* Plugin URI: http://miguras.com/divi_maker
* Description: Add custom modules and options to DIVI
* Version: 1.2
* Author: Miguras
* Author URI: http://miguras.com
* License: GPLv2 or later
* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
*/

// Create a helper function for easy SDK access.
function mdm_fs() {
    global $mdm_fs;

    if ( ! isset( $mdm_fs ) ) {
        // Include Freemius SDK.
        require_once dirname(__FILE__) . '/freemius/start.php';

        $mdm_fs = fs_dynamic_init( array(
            'id'                  => '2659',
            'slug'                => 'miguras-divi-maker',
            'type'                => 'plugin',
            'public_key'          => 'pk_be520e7ac9167b768e2c85abe6506',
            'is_premium'          => false,
            'has_addons'          => false,
            'has_paid_plans'      => false,
            'menu'                => array(
                'first-path'     => 'plugins.php',
                'support'        => false,
            ),
        ) );
    }

    return $mdm_fs;
}

// Init Freemius.
mdm_fs();
// Signal that SDK was initiated.
do_action( 'mdm_fs_loaded' );

/*========================== REQUIRED FILES ===========================*/

if(file_exists(plugin_dir_path( __FILE__ ) . 'create-module.php')){
  require_once(plugin_dir_path( __FILE__ ) . 'create-module.php');
}

$module_files = glob( plugin_dir_path( __FILE__ ) . '/includes/modules/*/*.php' );

// Load custom Divi Builder modules
foreach ( $module_files as $module_file ) {
		require_once $module_file;
}


?>
