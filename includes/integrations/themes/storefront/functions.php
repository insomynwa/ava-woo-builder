<?php
/**
 * Storefront integration
 */

add_action( 'elementor/page_templates/canvas/before_content', 'ava_woo_storefront_open_canvas_wrap', -999 );
add_action( 'ava-woo-builder/blank-page/before-content',      'ava_woo_storefront_open_canvas_wrap', -999 );

add_action( 'elementor/page_templates/canvas/after_content', 'ava_woo_storefront_close_canvas_wrap', 999 );
add_action( 'ava-woo-builder/blank-page/after_content',      'ava_woo_storefront_close_canvas_wrap', 999 );

add_action( 'elementor/widgets/widgets_registered', 'ava_woo_storefront_fix_wc_hooks' );

add_action( 'wp_enqueue_scripts', 'ava_woo_storefront_enqueue_styles' );

/**
 * Fix WooCommerce hooks for storefront
 *
 * @return [type] [description]
 */
function ava_woo_storefront_fix_wc_hooks() {
	remove_action( 'woocommerce_before_shop_loop_item_title',  'woocommerce_show_product_loop_sale_flash', 10 );
	add_filter( 'storefront_product_thumbnail_columns', 'ava_woo_storefront_thumbnails_columns' );
}

/**
 * Open .site-main wrapper for products
 * @return [type] [description]
 */
function ava_woo_storefront_open_canvas_wrap() {
	if ( ! is_singular( array( ava_woo_builder_post_type()->slug(), 'product' ) ) ) {
		return;
	}

	echo '<div class="site-main">';
}

/**
 * Close .site-main wrapper for products
 * @return [type] [description]
 */
function ava_woo_storefront_close_canvas_wrap() {

	if ( ! is_singular( array( ava_woo_builder_post_type()->slug(), 'product' ) ) ) {
		return;
	}

	echo '</div>';
}



function ava_woo_storefront_thumbnails_columns( $columns ){
	$columns = 6;

	return $columns;
}

/**
 * Enqueue Storefront integration stylesheets.
 *
 * @since 1.0.0
 * @access public
 * @return void
 */
function ava_woo_storefront_enqueue_styles() {
	wp_enqueue_style(
		'ava-woo-builder-storefront',
		ava_woo_builder()->plugin_url( 'includes/integrations/themes/storefront/assets/css/style.css' ),
		false,
		ava_woo_builder()->get_version()
	);
}