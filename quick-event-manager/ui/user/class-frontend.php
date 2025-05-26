<?php

/**
 * @copyright (c) 2020.
 * @author            Alan Fuller (support@fullworks)
 * @licence           GPL V3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link                  https://fullworks.net
 *
 * This file is part of  a Fullworks plugin.
 *
 *   This plugin is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     This plugin is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with  this plugin.  https://www.gnu.org/licenses/gpl-3.0.en.html
 */
namespace Quick_Event_Manager\Plugin\UI\User;

class FrontEnd {
    private $plugin_name;

    private $version;

    /**
     * @param \Freemius $freemius Object for freemius.
     */
    private $freemius;

    public function __construct( $plugin_name, $version, $freemius ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->freemius = $freemius;
    }

    public function hooks() {
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_styles') );
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts') );
        //	add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
        add_filter(
            'fwas_registered_forms',
            array($this, 'register_forms'),
            10,
            1
        );
    }

    public function register_forms( $forms ) {
        $forms['qem_guest'] = array(
            'name'             => 'QEM Guest events',
            'selectors'        => '.qem-guest-event-form',
            'protection_level' => 1,
        );
        return $forms;
    }

    public function enqueue_styles() {
        wp_enqueue_style(
            $this->plugin_name . '-user-style',
            QUICK_EVENT_MANAGER_PLUGIN_URL . 'ui/user/css/style.css',
            array(),
            $this->version,
            'all'
        );
    }

    public function enqueue_scripts() {
        wp_enqueue_script(
            $this->plugin_name . '-user-script',
            QUICK_EVENT_MANAGER_PLUGIN_URL . 'ui/user/js/frontend.js',
            array('wp-api', 'wp-api-fetch'),
            $this->version,
            true
        );
        // localize
        $register = qem_get_stored_register();
        $data = array(
            'register' => $register,
        );
        wp_localize_script( $this->plugin_name . '-user-script', 'qem_data', $data );
    }

    public function admin_enqueue_scripts() {
        global $current_screen;
        // if $current_screen->base contains 'qem' or quick-event-manager enqueue the scripts
        if ( false !== strpos( $current_screen->base, 'qem' ) || false !== strpos( $current_screen->base, 'quick-event-manager' ) ) {
            $this->enqueue_styles();
            $this->enqueue_scripts();
        }
    }

}
