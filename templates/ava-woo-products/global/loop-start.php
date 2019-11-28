<?php
/**
 * Products loop start template
 */

$settings = $this->get_settings();

$classes = array(
	'ava-woo-products',
	'ava-woo-products--' . $this->get_attr( 'presets' ),
	'col-row',
	ava_woo_builder_tools()->gap_classes( $this->get_attr( 'columns_gap' ), $this->get_attr( 'rows_gap' ) ),
);

$equal = $this->get_attr( 'equal_height_cols' );

if ( $equal ) {
	$classes[] = 'ava-equal-cols';
}

$popup_enable = ! empty( $settings['ava_woo_builder_cart_popup'] ) ? esc_attr( $settings['ava_woo_builder_cart_popup'] ) : false;
$popup_id     = ! empty( $settings['ava_woo_builder_cart_popup_template'] ) ? esc_attr( $settings['ava_woo_builder_cart_popup_template'] ) : '';

?>

<div class="<?php echo implode( ' ', $classes ); ?>" <?php do_action( 'ava-woo-builder/popup-generator/after-added-to-cart/cart-popup', $popup_enable, $popup_id ); ?>>