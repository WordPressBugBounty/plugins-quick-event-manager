<?php

/**
 * Quick Event Manager
 *
 * @author    Bright Plugins
 * @copyright 2025 Bright Plugins
 * @license   GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: Quick Event Manager
 * Plugin URI: https://brightplugins.com/
 * Description: A quick and easy to use Event Manager
 * Version: 9.16
 * Requires at least: 5.6
 * Requires PHP: 7.4
 * Author: Bright Plugins
 * Author URI: https://brightplugins.com/
 * Text Domain: quick-event-manager
 * License: GPLv3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 */

 /*
    Quick Event Manager is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    any later version.

    Quick Event Manager is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Quick Event Manager. If not, see http://www.gnu.org/licenses/gpl-3.0.txt.
*/
namespace Quick_Event_Manager\Plugin;

use Quick_Event_Manager\Plugin\Control\Plugin;
use Quick_Event_Manager\Plugin\Control\Freemius_Config;
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
/**
 * Print full stack trace when WordPress triggers an error
 * Specifically captures _doing_it_wrong() calls related to text domains
 */
define( 'QUICK_EVENT_MANAGER_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'QUICK_EVENT_MANAGER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'QUICK_EVENT_MANAGER_PLUGIN_FILE', plugin_basename( __FILE__ ) );
define( 'QUICK_EVENT_MANAGER_PLUGIN_NAME', 'quick-event-manager' );
define( 'QUICK_EVENT_MANAGER_PLUGIN_VERSION', '9.15' );
// Include the autoloaders so we can dynamically include the classes.
require_once QUICK_EVENT_MANAGER_PLUGIN_DIR . 'control/autoloader.php';
require_once QUICK_EVENT_MANAGER_PLUGIN_DIR . 'vendor/autoload.php';
/** @var \Freemius $qem_fs Freemius global object. */
global $qem_fs;
$freemius = new Freemius_Config();
$freemius->init();
if ( !function_exists( 'Quick_Event_Manager\\Plugin\\run_quick_event_manager' ) ) {
    function run_quick_event_manager() {
        /** @var \Freemius $qem_fs Freemius global object. */
        global $qem_fs;
        // Signal that SDK was initiated.
        do_action( 'quick_event_manager_fs_loaded' );
        register_activation_hook( __FILE__, array('\\Quick_Event_Manager\\Plugin\\Control\\Activator', 'activate') );
        register_deactivation_hook( __FILE__, array('\\Quick_Event_Manager\\Plugin\\Control\\Deactivator', 'deactivate') );
        $qem_fs->add_action( 'after_uninstall', array('\\Quick_Event_Manager\\Plugin\\Control\\Uninstall', 'uninstall') );
        $plugin = new Plugin('quick-event-manager', QUICK_EVENT_MANAGER_PLUGIN_VERSION, $qem_fs);
        $plugin->run();
    }

    run_quick_event_manager();
} else {
    $qem_fs->set_basename( true, __FILE__ );
}