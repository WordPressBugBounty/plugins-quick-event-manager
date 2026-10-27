<?php
// Builds the ICS files
function qem_ics_button( $id, $label ) {
	$cal_ics_svg = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             x="0px" y="0px" viewBox="0 0 512 512"
             width="24px" height="24px"
             xml:space="preserve">
<path d="M160,240v32c0,8.844-7.156,16-16,16h-32c-8.844,0-16-7.156-16-16v-32c0-8.844,7.156-16,16-16h32  C152.844,224,160,231.156,160,240z M144,352h-32c-8.844,0-16,7.156-16,16v32c0,8.844,7.156,16,16,16h32c8.844,0,16-7.156,16-16v-32  C160,359.156,152.844,352,144,352z M272,224h-32c-8.844,0-16,7.156-16,16v32c0,8.844,7.156,16,16,16h32c8.844,0,16-7.156,16-16v-32  C288,231.156,280.844,224,272,224z M272,352h-32c-8.844,0-16,7.156-16,16v32c0,8.844,7.156,16,16,16h32c8.844,0,16-7.156,16-16v-32  C288,359.156,280.844,352,272,352z M400,224h-32c-8.844,0-16,7.156-16,16v32c0,8.844,7.156,16,16,16h32c8.844,0,16-7.156,16-16v-32  C416,231.156,408.844,224,400,224z M400,352h-32c-8.844,0-16,7.156-16,16v32c0,8.844,7.156,16,16,16h32c8.844,0,16-7.156,16-16v-32  C416,359.156,408.844,352,400,352z M112,96h32c8.844,0,16-7.156,16-16V16c0-8.844-7.156-16-16-16h-32c-8.844,0-16,7.156-16,16v64  C96,88.844,103.156,96,112,96z M512,128v320c0,35.344-28.656,64-64,64H64c-35.344,0-64-28.656-64-64V128c0-35.344,28.656-64,64-64  h16v16c0,17.625,14.359,32,32,32h32c17.641,0,32-14.375,32-32V64h160v16c0,17.625,14.375,32,32,32h32c17.625,0,32-14.375,32-32V64  h16C483.344,64,512,92.656,512,128z M480,192c0-17.625-14.344-32-32-32H64c-17.641,0-32,14.375-32,32v256c0,17.656,14.359,32,32,32  h384c17.656,0,32-14.344,32-32V192z M368,96h32c8.844,0,16-7.156,16-16V16c0-8.844-7.156-16-16-16h-32c-8.844,0-16,7.156-16,16v64  C352,88.844,359.156,96,368,96z"/>
            ';
    $url = admin_url( 'admin-ajax.php?action=qem_download_ics&id=' . (int) $id );
	return '<h4><a  style="display: inline-flex;align-items: center; margin-right: 10px;" href="' .
	       esc_url($url) . '" target="_blank">' . $cal_ics_svg
	       . '<span style="margin-left: 3px;">' . esc_html( $label ) . '</span>' . '</a></h4>';

}

function qem_download_ics() {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Public, read-only download of a published event; no state change, so no nonce is used (see note below).
	$id   = isset( $_GET['id'] ) ? (int) $_GET['id'] : 0;
	$post = $id ? get_post( $id ) : null;

	/**
	 * Only serve ICS for an existing and published event - otherwise return a 404.
	 */
	if ( ! $post || 'event' !== $post->post_type || 'publish' !== $post->post_status ) {
		status_header( 404 );
		wp_die( esc_html__( 'Event not found', 'quick-event-manager' ) );
	}

	header( 'Content-Type: text/calendar' );
	header( 'Content-Description: File Transfer' );
	header( 'Content-Disposition: filename="' . sanitize_file_name( $post->post_title ) . '.ics"' );

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Output is pre-escaped per RFC 5545 inside qem_ics()
	echo qem_ics( $post );
	exit;
}

/**
 * Escape a value for use in an ICS text field per RFC 5545 section 3.3.11.
 * Backslash must be escaped first, then the other special characters.
 */
function qem_ics_escape_text( $value ) {
	// it avoids false positives with '0' while preserving valid values
	if ( null === $value || '' === $value ) {
		return '';
	}

	$value = (string) $value;

	// 1. The backslash MUST be escaped first
	$value = str_replace( '\\', '\\\\', $value );

	// 2. Normalize any real line breaks (CRLF, CR, or LF) to the literal '\n'
	$value = str_replace( array( "\r\n", "\r", "\n" ), '\\n', $value );

	// 3. Escape structural syntax characters
	$value = str_replace( ';', '\\;', $value );
	$value = str_replace( ',', '\\,', $value );

	return $value;
}

function qem_ics( $post ) {
	// @TODO this will use local time but if your calandar is different to site it will be wrong
	// add Z to dates and convert to UTC
	$display    = event_get_stored_display();
	$summary    = $post->post_title;
	$eventstart = get_post_meta( $post->ID, 'event_date', true );
	if ( ! $eventstart ) {
		$eventstart = time();
	}
	$start       = get_post_meta( $post->ID, 'event_start', true );
	$date        = gmdate( 'Ymd\T', $eventstart );
	$time        = qem_time( $start );
	$time        = gmdate( 'His', $time );
	$datestart   = $date . $time;
	$dateend     = get_post_meta( $post->ID, 'event_end_date', true );
	$address     = get_post_meta( $post->ID, 'event_address', true );
	$url         = get_permalink( $post->ID );
	$description = get_post_meta( $post->ID, 'event_desc', true );
	$filename    = $post->post_title . '.ics';
	if ( ! $dateend ) {
		$dateend = $eventstart;
		$finish  = get_post_meta( $post->ID, 'event_finish', true );
		$date    = gmdate( 'Ymd\T', $eventstart );
		$time    = qem_time( $finish );
		$time    = gmdate( 'His', $time );
		$dateend = $date . $time;
	} else {
		$finish  = get_post_meta( $post->ID, 'event_finish', true );
		$date    = gmdate( 'Ymd\T', $dateend );
		$time    = qem_time( $finish );
		$time    = gmdate( 'His', $time );
		$dateend = $date . $time;
	}

	$eol = "\r\n";

	$ics  = 'BEGIN:VCALENDAR' . $eol;
	$ics .= 'VERSION:2.0' . $eol;
	$ics .= 'PRODID:-//hacksw/handcal//NONSGML v1.0//EN' . $eol;
	$ics .= 'CALSCALE:GREGORIAN' . $eol;
	$ics .= 'BEGIN:VEVENT' . $eol;
	$ics .= 'UID:' . sanitize_key( uniqid() ) . $eol;
	$ics .= 'DTSTAMP:' . dateToCal( time() ) . $eol;
	$ics .= 'DTSTART:' . sanitize_text_field( $datestart ) . $eol;
	$ics .= 'DTEND:' . sanitize_text_field( $dateend ) . $eol;
	$ics .= 'LOCATION:' . qem_ics_escape_text( wp_strip_all_tags( $address ) ) . $eol;
	$ics .= 'DESCRIPTION:' . qem_ics_escape_text( wp_strip_all_tags( $description ) ) . $eol;
	$ics .= 'URL;VALUE=URI:' . esc_url_raw( $url ) . $eol;
	$ics .= 'SUMMARY:' . qem_ics_escape_text( wp_strip_all_tags( $summary ) ) . $eol;
	$ics .= 'END:VEVENT' . $eol;
	$ics .= 'END:VCALENDAR';

	return $ics;
}