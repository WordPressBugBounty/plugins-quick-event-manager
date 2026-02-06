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


namespace Quick_Event_Manager\Plugin\Core;

/**
 * used for shared data
 */
class Utilities {

	/**
	 * @var
	 */
	protected static $instance;


	public function __construct() {
	}

	/**
	 * @return Utilities
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function get_check_digit__premium_only( $number = "" ) {

		$weight = array(
			2,
			3,
			4,
			5,
			6,
			7,
			2,
			3,
			4,
			5,
			6,
			7,
			2,
			3,
			4,
			5,
			6,
			7,
			2,
			3,
			4,
			5,
			6,
			7
		);

		/* For convenience, reverse the string and work left to right. */
		$reversedBseVal = strrev( $number );
		for ( $i = 0, $sum = 0; $i <  strlen( $reversedBseVal ); $i ++ ) {
			/* Calculate product and accumulate. */
			$sum += (int) substr( $reversedBseVal, $i, 1 ) * $weight[ $i ];
		}

		/* Determine check digit, and concatenate to base value. */
		$remainder = $sum % 11;
		switch ( $remainder ) {
			case 0:
				$result = 'X';
				break;
			case 1:
				$result = "0";
				break;

			default:
				$checkDigit = 11 - $remainder;
				$result     = "{$checkDigit}";
				break;
		}

		return $result;
	}

	public function is_valid_check_digit__premium_only( $string ) {
		// get last character
		$last = ( strtoupper( substr( $string, - 1 ) ) );
		// get the rest
		$rest = substr( $string, 0, - 1 );
		// strip non-numeric characters
		$rest = preg_replace( '/[^0-9]/', '', $rest );
		// calculate the check digit
		$check_digit = $this->get_check_digit__premium_only( $rest );

		// compare it to the last character
		return $check_digit == $last;
	}

	public function get_formatted_ticket__premium_only() {
		$ticket = $this->get_ticket__premium_only();
		$check_digit = $this->get_check_digit__premium_only( $ticket );

		$ticket = substr( $ticket, 0, 10 );
		$ticket = str_pad( $ticket, 10, "0", STR_PAD_LEFT );
		$ticket = substr( $ticket, 0, 3 ) . "-" . substr( $ticket, 3, 4 ) . "-" . substr( $ticket, 7, 3 );
		// add check digit
		$ticket .= '-' . $check_digit;

		return $ticket;
	}

	public function get_ticket__premium_only( $length = 10 ) {
		$characters       = '0123456789';
		$charactersLength = strlen( $characters );
		$randomString     = '';
		for ( $i = 0; $i < $length; $i ++ ) {
			$randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
		}

		return $randomString;
	}
    /* used by external shortcode */
	public function get_display_settings() {
		$display = get_option( 'qem_display' );
		if ( ! is_array( $display ) ) {
			$display = array();
		}
		$default = array(
			'read_more'             => esc_html__( 'Find out more...', 'quick-event-manager' ),
			'noevent'               => esc_html__( 'No event found', 'quick-event-manager' ),
			'event_image'           => '',
			'usefeatured'           => 'checked',
			'monthheading'          => '',
			'back_to_list_caption'  => esc_html__( 'Return to Event list', 'quick-event-manager' ),
			'image_width'           => 300,
			'event_image_width'     => 300,
			'event_archive'         => '',
			'map_width'             => 200,
			'max_width'             => 40,
			'map_height'            => 200,
			'useics'                => '',
			'uselistics'            => '',
			'useicsbutton'          => esc_html__( 'Download Event to Calendar', 'quick-event-manager' ),
			'usetimezone'           => '',
			'timezonebefore'        => esc_html__( 'Timezone:', 'quick-event-manager' ),
			'timezoneafter'         => esc_html__( 'time', 'quick-event-manager' ),
			'show_map'              => '',
			'map_and_image'         => 'checked',
			'localization'          => '',
			'monthtype'             => 'short',
			'monthheadingorder'     => 'my',
			'categorydropdown'      => false,
			'categorydropdownlabel' => esc_html__( 'Select a Category', 'quick-event-manager' ),
			'categorydropdownwidth' => false,
			'categorylocation'      => 'title',
			'showcategory'          => '',
			'recentposts'           => '',
			'lightboxwidth'         => 60,
			'fullpopup'             => 'checked',
			'linktocategory'        => 'checked',
			'showuncategorised'     => '',
			'keycaption'            => esc_html__( 'Event Categories:', 'quick-event-manager' ),
			'showkeyabove'          => '',
			'showkeybelow'          => '',
			'showcategorycaption'   => esc_html__( 'Current Category:', 'quick-event-manager' ),
			'cat_border'            => 'checked',
			'catallevents'          => '',
			'catalleventscaption'   => esc_html__( 'Show All', 'quick-event-manager' )
		);
		$display = array_merge( $default, $display );

		return $display;
	}

	public function get_date_format() {
		$fmt = get_option( 'date_format' );
		return apply_filters('qem_date_format', $fmt);
	}

	public function get_time_format() {
		$fmt = get_option( 'time_format' );
		return apply_filters('qem_time_format', $fmt);
	}


}
