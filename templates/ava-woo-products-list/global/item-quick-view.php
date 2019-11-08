<?php
/**
 * Loop item tags
 */

$settings = $this->get_settings();

if( isset( $settings['show_quickview'] ) ){
	if ( 'yes' === $settings['show_quickview'] ) {
		do_action( 'ava-woo-builder/templates/ava-woo-products-list/quickview-button', $settings );
	}
}
