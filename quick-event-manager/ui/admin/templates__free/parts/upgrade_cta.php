<?php
/**
 * @var mixed $data Custom data for the template.
 */

use Quick_Event_Manager\Plugin\Control\Plugin;


//'<img style="max-width: 100%;border-radius: 10px;" src="' . QEMBP_ADMIN_ASSETS . '/img/qem-banner-pro.png' . '">';

$output = '
<div class="qemupgrade"><a href="' . esc_url( Plugin::UPGRADE_LINK ) . '">
        <h3 style="font-size: 1.1em;">'
          /* translators: %s: Price per month. */
          . sprintf( esc_html__( 'Upgrade Quick Event Manager from just %s per year', 'quick-event-manager' ), '$49' ) . '<sup>*</sup></h3>
        <p>' . esc_html__( 'Upgrading gives you access the  CSV uploader, a range of registration reports and downloads, Mailchimp subscriber, Guest Event creator, and Stripe Checkout.', 'quick-event-manager' ) . ' </p>
        <p>' . esc_html__( 'Click to find out more', 'quick-event-manager' ) . '</p>
    </a>
</div>';

$data->template_loader->set_output( $output );
