<?php
/**
 * Products list loop start template
 */

$settings = $this->get_settings();

$classes = array(
	'ava-woo-products-list',
);

$layout = $this->get_attr( 'products_layout' );

if ( $layout ) {
	$classes[] = 'products-layout-' . $layout;
}

$popup_enable = ! empty( $settings['ava_woo_builder_cart_popup'] ) ? esc_attr( $settings['ava_woo_builder_cart_popup'] ) : false;
$popup_id     = ! empty( $settings['ava_woo_builder_cart_popup_template'] ) ? esc_attr( $settings['ava_woo_builder_cart_popup_template'] ) : '';

?>

<ul class="<?php echo implode( ' ', $classes ); ?>" <?php do_action( 'ava-woo-builder/popup-generator/after-added-to-cart/cart-popup', $popup_enable, $popup_id ); ?>>