<?php
/**
 * Avada integration
 */

add_action( 'elementor/page_templates/canvas/before_content', 'ava_woo_avada_open_canvas_wrap', - 999 );
add_action( 'ava-woo-builder/blank-page/before-content', 'ava_woo_avada_open_canvas_wrap', - 999 );

add_action( 'elementor/page_templates/canvas/after_content', 'ava_woo_avada_close_canvas_wrap', 999 );
add_action( 'ava-woo-builder/blank-page/after_content', 'ava_woo_avada_close_canvas_wrap', 999 );

add_action( 'wp_enqueue_scripts', 'ava_woo_avada_enqueue_styles' );

add_action( 'elementor/widgets/widgets_registered', 'ava_woo_avada_fix_wc_hooks' );

/**
 * Fix WooCommerce hooks for avada
 *
 * @return [type] [description]
 */
function ava_woo_avada_fix_wc_hooks() {
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}

/**
 * Open .site-main wrapper for products
 * @return [type] [description]
 */
function ava_woo_avada_open_canvas_wrap() {
	if ( ! is_singular( array( ava_woo_builder_post_type()->slug(), 'product' ) ) ) {
		return;
	}

	echo '<div class="site-main">';
}

/**
 * Close .site-main wrapper for products
 * @return [type] [description]
 */
function ava_woo_avada_close_canvas_wrap() {

	if ( ! is_singular( array( ava_woo_builder_post_type()->slug(), 'product' ) ) ) {
		return;
	}

	echo '</div>';
}

/**
 * Enqueue Avada integration stylesheets.
 *
 * @since 1.0.0
 * @access public
 * @return void
 */
function ava_woo_avada_enqueue_styles() {
	wp_enqueue_style(
		'ava-woo-builder-avada',
		ava_woo_builder()->plugin_url( 'includes/integrations/themes/avada/assets/css/style.css' ),
		false,
		ava_woo_builder()->get_version()
	);
}