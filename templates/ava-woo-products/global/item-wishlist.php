<?php
/**
 * Loop item tags
 */

$settings = $this->get_settings();

if( isset( $settings['show_wishlist'] ) ) {
	if ( 'yes' === $settings['show_wishlist'] ) {
		do_action( 'ava-woo-builder/templates/ava-woo-products/wishlist-button', $settings );
	}
}