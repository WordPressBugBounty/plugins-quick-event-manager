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

use Quick_Event_Manager\Plugin\Control\Plugin;

class FrontEnd {

	private $plugin_name;
	private $version;
	/**
	 * @param \Freemius $freemius Object for freemius.
	 */
	private $freemius;

	public function __construct( $plugin_name, $version, $freemius ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->freemius    = $freemius;
	}

	public function hooks() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		//	add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_filter( 'fwas_registered_forms', array( $this, 'register_forms' ), 10, 1 );


	}

	public function register_forms( $forms ) {
		$forms['qem_guest'] =
			array(
				'name'             => 'QEM Guest events',
				'selectors'        => '.qem-guest-event-form',
				'protection_level' => 1,
			);

		return $forms;
	}


	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name . '-user-style', QUICK_EVENT_MANAGER_PLUGIN_URL . 'ui/user/css/style.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name . '-user-script', QUICK_EVENT_MANAGER_PLUGIN_URL . 'ui/user/js/frontend.js', array(
			'wp-api',
			'wp-api-fetch'
		), $this->version, true );
		// localize
		$register = qem_get_stored_register();
		$data    = array(
			'register' => $register,
		);
		if ( Plugin::can_use_premium_code__premium_only() ) {
			$event = qem_stored_guest();
			$data['guest_max_file_size'] = $event['imagesize'];
			/* translate strings
			<h3 class="qem-tw-text-lg qem-tw-font-medium qem-tw-mb-4">Image Size Exceeded</h3>
                <p class="qem-tw-mb-4">The selected image exceeds the maximum allowed size (${(MAX_FILE_SIZE/1024/1024).toFixed(1)}MB). Would you like to resize it?</p>
                <div class="qem-tw-flex qem-tw-justify-end qem-tw-space-x-3">
                    <button id="qem-resize-cancel" class="qem-tw-px-4 qem-tw-py-2 qem-tw-border qem-tw-rounded qem-tw-text-gray-600">Cancel</button>
                    <button id="qem-resize-confirm" class="qem-tw-px-4 qem-tw-py-2 qem-tw-bg-blue-500 qem-tw-text-white qem-tw-rounded">Resize Image</button>
			*/
			$data['guest_max_file_size_message'] = esc_html__( 'Image Size Exceeded', 'quick-event-manager' );
			// translators: %s is the size in MB
			$data['guest_max_file_size_message_text'] = sprintf( esc_html__( 'The selected image exceeds the maximum allowed size (%sMB). Would you like to resize it?', 'quick-event-manager' ), number_format($data['guest_max_file_size']/1024/1024, 2) );
			$data['guest_max_file_size_message_cancel'] = esc_html__( 'Cancel', 'quick-event-manager' );
			$data['guest_max_file_size_message_confirm'] = esc_html__( 'Resize Image', 'quick-event-manager' );
		}
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
