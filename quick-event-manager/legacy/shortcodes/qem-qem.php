<?php

use Quick_Event_Manager\Plugin\Control\Plugin;

function qem_event_shortcode_esc( $atts, $widget ) {
	global $qem_fs;
	$remaining = $all = $i = $monthnumber = $archive = $yearnumber = $daynumber   = $notthisyear = '';
	$atts     = shortcode_atts( array(
		'id'               => '',
		'posts'            => '99',
		'links'            => 'checked',
		'daterange'        => 'current',
		'size'             => '',
		'headersize'       => 'headtwo',
		'settings'         => 'checked',
		'vanillawidget'    => 'checked',
		'images'           => '',
		'category'         => '',
		'categoryplaces'   => '',
		'order'            => '',
		'fields'           => '',
		'listlink'         => '',
		'listlinkanchor'   => '',
		'listlinkurl'      => '',
		'cb'               => '',
		'y'                => '',
		'vw'               => '',
		'categorykeyabove' => '',
		'categorykeybelow' => '',
		'usecategory'      => '',
		'event'            => '',
		'popup'            => '',
		'fullevent'        => 'summary',
		'fullpopup'        => '',
		'calendar'         => '',
		'thisisapopup'     => false,
		'listplaces'       => true,
		'fulllist'         => false,
		'eventfull'        => '',
		'widget'           => '',
		'grid'             => '',
		'tag'              => '',
	), $atts, 'qem' );
	global $post;
	$category = $atts['category'];
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- front end user selection of category - no update processing or security implication
	if ( isset( $_GET['category'] ) ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- front end user selection of category - no update processing or security implication
		$category = sanitize_text_field($_GET['category']);
	}
	$display        = event_get_stored_display();
	$atts['popup']  = qem_get_element( $display, 'linkpopup', false );
	$atts['widget'] = $widget;

	if ( $display['fullpopup'] && qem_get_element( $display, 'linkpopup', false ) ) {
		$atts['fullpopup'] = 'checked';
	}

	if ( $atts['fullevent'] == 'on' || qem_get_element( $display, 'fullevent', false ) ) {
		$atts['fulllist'] = true;
	}

	$cal    = qem_get_stored_calendar();
	$addons = qem_get_addons();
	$style  = qem_get_stored_style();
	if ( ! $atts['listlinkurl'] ) {
		$atts['listlinkurl'] = qem_get_element( $display, 'back_to_url', false );
	}
	if ( ! $atts['listlinkanchor'] ) {
		$atts['listlinkanchor'] = $display['back_to_list_caption'];
	}
	if ( $atts['listlink'] ) {
		$atts['listlink'] = 'checked';
	}
	if ( $atts['cb'] ) {
		$display['cat_border'] = 'checked';
	}
	$output_escaped = '';
	$content_escaped = '';
	if ( qem_get_element( $display, 'event_descending', false ) || $atts['order'] == 'asc' ) {
		$args = array(
			'post_type'      => 'event',
			'orderby'        => 'meta_value_num',
			'meta_key'       => 'event_date',
			'posts_per_page' => - 1,
		);
	} else {
		$args = array(
			'post_type'      => 'event',
			'orderby'        => 'meta_value_num',
			'meta_key'       => 'event_date',
			'order'          => 'asc',
			'posts_per_page' => - 1,
		);
	}
	if ( Plugin::can_use_premium_code__premium_only() ) {
		if ( qem_get_element( $addons, 'pagination', false ) ) {
			$compare = '>=';
			$order = 'asc';
			if ( $atts['id'] == 'archive' ) {
				$compare =  '<';
				$order = 'desc';
					}
			$args = array(
				'post_type'      => 'event',
				'orderby'        => 'meta_value_num',
				'meta_key'       => 'event_date',
				'order'          => $order,
				'posts_per_page' => $atts['posts'],
				'paged'          => get_query_var( 'paged', 1 ),
				'meta_query'     => array(
					array(
						'key'     => 'event_date',
						'value'   => time(),
						'compare' => $compare,
					),
				),
			);
		}
		if ( $atts['tag'] ) {
			if ( $atts['tag'] == 'slug' ) {
				// get the current page or post slug
				$slug        = sanitize_post_field( 'post_name', get_post( get_the_ID() )->post_name, get_the_ID(), 'display' );
				$args['tag'] = $slug;
			} else {
				$args['tag'] = $atts['tag'];
			}
		}
	}


	$the_query   = new WP_Query( $args );
	$event_found = false;
	$today       = strtotime( date( 'Y-m-d' ) );
	$catlabel    = str_replace( ',', ', ', $category );
	$currentyear = date( 'Y' );
	if ( $atts['usecategory'] ) {
		$atts['cb'] = 'checked';
	}

	if ( $display['categorydropdown'] ) {
		$content_escaped .= qem_kses_post_svg_form(qem_category_dropdown( $display ));
	}

	if ( ! $widget && $display['cat_border'] && ( $display['showkeyabove'] || $atts['categorykeyabove'] ) ) {
		$content_escaped .= qem_wp_kses_post(qem_category_key( $cal, $style, '' ));
	}
	if ( $widget && $atts['usecategory'] && $atts['categorykeyabove'] ) {
		$content_escaped .= qem_wp_kses_post(qem_category_key( $cal, $style, '' ));
	}
	if ( $category && $display['showcategory'] ) {
		$content_escaped .= '<h2>' . esc_html($display['showcategorycaption'] . ' ' . $catlabel) . '</h2>';
	}

	if ( qem_get_element( $display, 'eventmasonry', false ) == 'masonry' && ! $atts['widget'] ) {
		$atts['grid'] = 'masonry';
	}

	if ( $atts['grid'] == 'masonry' ) {
		$content_escaped .= '<div id="qem">';
	}

	if ( $atts['id'] == 'all' ) {
		$all = 'all';
	}
	if ( $atts['id'] == 'current' ) {
		$monthnumber = date( 'n' );
	}
	$nextweek = 0;
	if ( $atts['id'] == 'nextweek' ) {
		$nextweek = strtotime( "+7 day", $today );
	}
	if ( $atts['id'] == 'remaining' ) {
		$remaining = date( 'n' );
	}
	if ( $atts['id'] == 'archive' ) {
		$archive = 'archive';
	}
	if ( $atts['id'] == 'notthisyear' ) {
		$notthisyear = 'checked';
	}
	if ( is_numeric( $atts['id'] ) ) {
		$monthnumber = $atts['id'];
	}
	if ( is_numeric( $atts['id'] ) && strlen( $atts['id'] ) == 4 ) {
		$yearnumber = $atts['id'];
	}
	if ( $atts['id'] == 'calendar' ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- front end user selection of category - no update processing or security implication
		if ( isset( $_GET['qemmonth'] ) ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- front end user selection of category - no update processing or security implication
			$monthnumber = sanitize_text_field($_GET['qemmonth']);
		} else {
			$monthnumber = date( 'n' );
		}
	}
	$thisyear     = date( 'Y' );
	$thismonth    = date( "M" );
	$currentmonth = date( "M" );
	if ( $atts['id'] == 'today' ) {
		$daynumber  = date( "d" );
		$todaymonth = $thismonth;
	}
	if ( strpos( $atts['id'], 'D' ) !== false ) {
		$daynumber = filter_var( $atts['id'], FILTER_SANITIZE_NUMBER_INT );
	}
	if ( strpos( $atts['id'], 'M' ) !== false ) {
		$dm          = explode( "D", $atts['id'] );
		$monthnumber = filter_var( $dm[0], FILTER_SANITIZE_NUMBER_INT );
		$daynumber   = filter_var( $dm[1], FILTER_SANITIZE_NUMBER_INT );
	}

	if ( $category ) {
		$category = explode( ',', $category );
	}
	if ( $atts['event'] ) {
		$eventid = explode( ',', $atts['event'] );
	}

	if ( $the_query->have_posts() ) {
		if ( $cal['connect'] ) {
			$content_escaped .= '<p><a href="' . esc_url($cal['calendar_url']) . '">' . esc_html($cal['calendar_text']) . '</a></p>';
		}
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$unixtime = get_post_meta( $post->ID, 'event_date', true );
			if ( ! $unixtime ) {
				$unixtime = time();
			}
			$enddate          = get_post_meta( $post->ID, 'event_end_date', true );
			$hide_event       = get_post_meta( $post->ID, 'hide_event', true );
			$day              = date( "d", $unixtime );
			$monthnow         = date( "n", $unixtime );
			$eventmonth       = date( "M", $unixtime );
			$eventmonthnumber = date( "m", $unixtime );
			$month            = ( $display['monthtype'] == 'short' ? date_i18n( "M", $unixtime ) : date_i18n( "F", $unixtime ) );
			$year             = date( "Y", $unixtime );

			$monthheading = $display['monthheadingorder'] == 'ym' ? $year . ' ' . $month : $month . ' ' . $year;

			if ( $atts['y'] ) {
				$thisyear   = $atts['y'];
				$yearnumber = 0;
			}

			if ( $atts['event'] ) {
				$atts['id'] = 'event';
				$event      = $post->ID;
				$eventbyid  = ( in_array( $event, $eventid ) ? 'checked' : '' );
			}

			if (Plugin::can_use_premium_code__premium_only()) {
				if ( defined( 'WP_DEBUG' ) && true == WP_DEBUG ) {

					/*
					 * @TODO this selected part was put in to help understand overly complex if statement rules
					 * in future may replace it
					 */
					$selected = false;
					if ( $all ) {
						$selected = true;
					}
					// Event by ID
					if ( $atts['event'] && $eventbyid ) {
						$selected = true;
					}
					// Archive Events
					if ( $archive && $unixtime < $today && $enddate < $today ) {
						$selected = true;
					}
					// All if no ID
					if ( $atts['id'] == '' && ( $unixtime >= $today || $enddate >= $today || $display['event_archive'] == 'checked' ) ) {
						$selected = true;
					}
					// Today only
					if ( $daynumber == $day && $todaymonth == $eventmonth && $thisyear == $year ) {
						$selected = true;
					}
					// Day and Month
					if ( $daynumber == $day && $monthnumber == $eventmonthnumber && $thisyear == $year ) {
						$selected = true;
					}
					// Next 7 days
					if ( $nextweek && $unixtime >= $today && $unixtime <= $nextweek ) {
						$selected = true;
					}
					// This month
					if ( ! $daynumber && $monthnumber && $monthnow == $monthnumber && $thisyear == $year ) {
						$selected = true;
					}
					// Rest of the month
					if ( $remaining && $monthnow == $remaining && $thisyear == $year && ( $unixtime >= $today || $enddate >= $today ) ) {
						$selected = true;
					}
					// This year
					if ( $yearnumber && $yearnumber == $year ) {
						$selected = true;
					}
					// Not this year
					if ( $notthisyear && $currentyear > $year ) {
						$selected = true;
					}
				}
			}


			if ( $i < $atts['posts'] ) {
				if (//All Events
					( ( $all ||
					    // Event by ID
					    $atts['event'] && $eventbyid ) ||
					  // Archive Events
					  ( $archive && $unixtime < $today && $enddate < $today ) ||
					  // All if no ID
					  ( $atts['id'] == '' && ( $unixtime >= $today || $enddate >= $today || $display['event_archive'] == 'checked' ) ) ||
					  // Today only
					  ( $daynumber == $day && $todaymonth == $eventmonth && $thisyear == $year ) ||
					  // Day and Month
					  ( $daynumber == $day && $monthnumber == $eventmonthnumber && $thisyear == $year ) ||
					  // Next 7 days
					  ( $nextweek && $unixtime >= $today && $unixtime <= $nextweek ) ||
					  // This month
					  ( ! $daynumber && $monthnumber && $monthnow == $monthnumber && $thisyear == $year ) ||
					  // Rest of the month
					  ( $remaining && $monthnow == $remaining && $thisyear == $year && ( $unixtime >= $today || $enddate >= $today ) ) ||
					  // This year
					  ( $yearnumber && $yearnumber == $year ) ||
					  // Not this year
					  ( $notthisyear && $currentyear > $year )
					) &&
					// This category
					( in_category( $category ) || ! $category )
				) {
					if ( ! $atts['grid'] && $display['monthheading'] && ( $currentmonth || $month != $thismonth || $year != $thisyear ) ) {
						$content_escaped      .= '<h2>' . esc_html($monthheading). '</h2>';
						$thismonth    = $month;
						$thisyear     = $year;
						$currentmonth = '';
					}
					if ( ! $hide_event ) {
						$content_escaped .= qem_event_construct_esc( $atts ) . "\r\n";
					}
					$event_found = true;
					$i ++;
				}
			}
		}

		if ( $atts['grid'] == 'masonry' ) {
			$content_escaped .= '</div>';
		}
		if ( ! $widget && $display['cat_border'] && ( $display['showkeybelow'] || $atts['categorykeyabove'] ) ) {
			$content_escaped .= qem_wp_kses_post(qem_category_key( $cal, $style, '' ));
		}
		if ( $widget && $atts['usecategory'] && $atts['categorykeyabove'] ) {
			$content_escaped .= qem_wp_kses_post(qem_category_key( $cal, $style, '' ));
		}
		if ( $atts['listlink'] ) {
			$content_escaped .= '<p><a href="' . esc_url($atts['listlinkurl'] ). '">' . esc_html($atts['listlinkanchor']) . '</a></p>';
		}

		$output_escaped .= $content_escaped;
		if (Plugin::can_use_premium_code__premium_only()) {
			if ( ! $atts['widget'] ) {
				$output_escaped .= qem_wp_kses_post(wp_qemnavi( array( 'query' => $the_query, 'echo' => false ) ));
			}
		}
	}
	if ( ! $event_found ) {
		$output_escaped .= "<h2>" . qem_wp_kses_post($display['noevent']) . "</h2>";
	}
	wp_reset_postdata();
	wp_reset_query();

	return $output_escaped;
}

function qem_category_dropdown( $display ) {
	$args    = array( 'exclude' => 1 );
	$arr     = get_categories( $args );
	$width   = $display['categorydropdownwidth'] ? ' style="width:100%"' : '';
	$content = '<form>
    <div class="qem-register"' . $width . '>
    <select onchange="this.form.submit()" name="category">
    <option>' . $display['categorydropdownlabel'] . '</option>';
	foreach ( $arr as $option ) {
		$thecat   = $option->name;
		$selected = '';

		if ( isset( $_REQUEST['category'] ) && ( $_REQUEST['category'] == $thecat ) ) {
			$selected = 'selected';
		}

		$content .= '<option value="' . $thecat . '" ' . $selected . '>' . $thecat . '</option>';
	}
	$content .= '</select>
    </div></form>';

	return $content;
}