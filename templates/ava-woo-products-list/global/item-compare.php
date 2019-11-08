<?php
/**
 * Loop item tags
 */

$settings = $this->get_settings();

if ( isset( $settings['show_compare'] ) ){
	if ( 'yes' === $settings['show_compare'] ) {
		do_action( 'ava-woo-builder/templates/ava-woo-products-list/compare-button', $settings );
	}
}