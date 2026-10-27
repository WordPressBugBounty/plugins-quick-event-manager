<?php
function qem_ajax_calendar() {
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped, WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- qem_show_calendar_esc() escapes its own return value; public read-only AJAX calendar nav (no state change); atts sanitized via qem_sanitize_text_or_array_field().
	echo qem_show_calendar_esc( isset( $_POST['atts'] ) ? qem_sanitize_text_or_array_field( wp_unslash( $_POST['atts'] ) ) : '' );
	exit;
}

// Generates the months

function qem_calendar_months( $cal ) {
	$month = date_i18n( "n" );
	$year  = date_i18n( "Y" );

	$actual_link = qem_actual_link();
	$parts       = explode( "&", $actual_link );
	$actual_link = $parts['0'];
	$link        = ( strpos( $actual_link, '?' ) ? '&' : '?' );
	$reload      = ( $cal['jumpto'] ? '#qem_calreload' : '' );

	$content = '<p>' . $cal['monthscaption'] . '</p>
        <p class="clearfix">';
	for ( $i = $month; $i <= 12; $i ++ ) {
		$monthname = date_i18n( "M", mktime( 0, 0, 0, $i, 10 ) );
		$content   .= '<span class="qem-category qem-month"><a href="' . $actual_link . $link . 'qemmonth=' . $i . '&amp;qemyear=' . $year . $reload . '">' . $monthname . '</a></span>';
	}
	$year  = $year + 1;
	$month = $month - 1;
	for ( $i = 1; $i <= $month; $i ++ ) {
		$monthname = date_i18n( "M", mktime( 0, 0, 0, $i, 10 ) );
		$content   .= '<span class="qem-category qem-month"><a href="' . $actual_link . $link . 'qemmonth=' . $i . '&amp;qemyear=' . $year . $reload . '">' . $monthname . '</a></span>';
	}
	$content .= '</p>';

	return $content;
}

function remove_empty( $array ) {
	return array_filter( $array, '_remove_empty_internal' );
}

function _remove_empty_internal( $value ) {
	return ! empty( $value ) || $value === 0;
}