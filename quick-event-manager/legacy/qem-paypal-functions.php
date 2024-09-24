<?php

// Check for IPN payment
function qem_check_ipnblock(  $payment, $item  ) {
    if ( qem_get_element( $payment, 'paypal', false ) && qem_get_element( $payment, 'ipn', false ) && qem_get_element( $payment, 'ipnblock', false ) && $item['ipn'] && $item['ipn'] != 'Paid' ) {
        return true;
    } else {
        return false;
    }
}

function qem_ipn() {
    global $qem_fs;
    // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- no nonce needed PayPal callback will handle
    if ( !isset( $_GET['qem_ipn'] ) ) {
        return;
    }
    $payment = qem_get_stored_payment();
    if ( !qem_get_element( $payment, 'ipn', false ) ) {
        return;
    }
    if ( !defined( "QEMFW_DEBUG" ) ) {
        define( "QEMFW_DEBUG", 0 );
    }
    if ( !defined( "QEMFW_LOG_FILE" ) ) {
        define( "QEMFW_LOG_FILE", "./ipn.log" );
    }
    if ( !isset( $_GET['debug'] ) ) {
        $raw_post_data = file_get_contents( 'php://input' );
        $raw_post_array = explode( '&', $raw_post_data );
        $myPost = array();
        foreach ( $raw_post_array as $keyval ) {
            $keyval = explode( '=', $keyval );
            if ( count( $keyval ) == 2 ) {
                $myPost[$keyval[0]] = urldecode( $keyval[1] );
            }
        }
        // see https://developer.paypal.com/docs/ipn/integration-guide/ht-ipn/#do-it
        $req = 'cmd=_notify-validate';
        if ( function_exists( 'get_magic_quotes_gpc' ) ) {
            $get_magic_quotes_exists = true;
        }
        foreach ( $myPost as $key => $value ) {
            $value = urlencode( $value );
            $req .= "&{$key}={$value}";
        }
        if ( qem_get_element( $payment, 'sandbox', false ) ) {
            $paypal_url = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
        } else {
            $paypal_url = "https://ipnpb.paypal.com/cgi-bin/webscr";
        }
        $response = wp_remote_post( $paypal_url, array(
            'timeout' => 30,
            'body'    => $req,
        ) );
        if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
            if ( QEMFW_DEBUG == true ) {
                error_log( date( '[Y-m-d H:i e] ' ) . "Can't connect to PayPal to validate IPN message: Indetermined" . PHP_EOL, 3, QEMFW_LOG_FILE );
            }
            return;
        }
        $status = wp_remote_retrieve_body( $response );
        if ( QEMFW_DEBUG == true ) {
            error_log( date( '[Y-m-d H:i e] ' ) . "HTTP request of validation request:  for IPN payload: {$req}" . print_r( wp_remote_retrieve_headers( $response ), true ) . PHP_EOL, 3, QEMFW_LOG_FILE );
            error_log( date( '[Y-m-d H:i e] ' ) . "HTTP response of validation request: {$status}" . PHP_EOL, 3, QEMFW_LOG_FILE );
        }
    } else {
        $status = 'VERIFIED';
    }
    if ( 'VERIFIED' == $status ) {
        // phpcs:ignore WordPress.Security.NonceVerification.Missing -- No action, nonce is not required as from PayPal
        $custom = sanitize_text_field( $_REQUEST['custom'] );
        $args = array(
            'post_type'      => 'event',
            'posts_per_page' => -1,
        );
        query_posts( $args );
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                $id = get_the_id();
                $message = get_option( 'qem_messages_' . $id );
                if ( $message ) {
                    $count = count( $message );
                    for ($i = 0; $i < $count; $i++) {
                        if ( $message[$i]['ipn'] == $custom ) {
                            $message[$i]['ipn'] = 'Paid';
                            $auto = qem_get_stored_autoresponder();
                            $register = get_custom_registration_form( $id );
                            $addons = qem_get_addons();
                            $payment = qem_get_stored_payment();
                            $values = array(
                                'yourname'        => ( isset( $message[$i]['yourname'] ) ? $message[$i]['yourname'] : '' ),
                                'youremail'       => ( isset( $message[$i]['youremail'] ) ? $message[$i]['youremail'] : '' ),
                                'yourtelephone'   => ( isset( $message[$i]['yourtelephone'] ) ? $message[$i]['yourtelephone'] : '' ),
                                'yourmessage'     => ( isset( $message[$i]['yourmessage'] ) ? $message[$i]['yourmessage'] : '' ),
                                'yourplaces'      => ( isset( $message[$i]['yourplaces'] ) ? $message[$i]['yourplaces'] : '' ),
                                'yourblank1'      => ( isset( $message[$i]['yourblank1'] ) ? $message[$i]['yourblank1'] : '' ),
                                'yourdropdown'    => ( isset( $message[$i]['yourdropdown'] ) ? $message[$i]['yourdropdown'] : '' ),
                                'yourselector'    => ( isset( $message[$i]['yourselector'] ) ? $message[$i]['yourselector'] : '' ),
                                'yournumber1'     => ( isset( $message[$i]['yournumber1'] ) ? $message[$i]['yournumber1'] : '' ),
                                'morenames'       => ( isset( $message[$i]['morenames'] ) ? $message[$i]['morenames'] : '' ),
                                'ignore'          => ( isset( $message[$i]['ignore'] ) ? $message[$i]['ignore'] : '' ),
                                'donation_amount' => ( isset( $message[$i]['donation_amount'] ) ? $message[$i]['donation_amount'] : '' ),
                            );
                            if ( $message[$i]['products'] && !empty( $message[$i]['products'] ) ) {
                                preg_match_all( '/x (\\d+)/', $message[$i]['products'], $matches );
                                $numbers = $matches[1];
                                for ($n = 0; $n < 4; $n++) {
                                    $key = 'qtyproduct' . $n;
                                    // if there is a match for this index, use it, otherwise default to 0
                                    $values[$key] = ( isset( $numbers[$n] ) ? $numbers[$n] : 0 );
                                }
                            }
                            $date = get_post_meta( $id, 'event_date', true );
                            $enddate = get_post_meta( $id, 'event_end_date', true );
                            $date = date_i18n( "d M Y", $date );
                            $enddate = date_i18n( "d M Y", $enddate );
                            $start = get_post_meta( $id, 'event_start', true );
                            $finish = get_post_meta( $id, 'event_finish', true );
                            if ( $auto['enable'] && $message[$i]['youremail'] && $auto['whenconfirm'] == 'afterpayment' ) {
                                $content = qem_build_event_message( $values, $register );
                                qem_send_confirmation(
                                    $auto,
                                    $values,
                                    $content,
                                    $register,
                                    $id
                                );
                            }
                            if ( $auto['whenconfirm'] == 'afterpayment' ) {
                                qem_admin_notification(
                                    $id,
                                    $register,
                                    $addons,
                                    $values,
                                    $auto,
                                    $enddate,
                                    $date,
                                    $start,
                                    $finish,
                                    $payment
                                );
                            }
                            update_option( 'qem_messages_' . $id, $message );
                        }
                    }
                }
            }
        }
    }
}
