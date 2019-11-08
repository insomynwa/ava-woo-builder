<?php
/**
 * Tabs template
 */
echo '<div class="ava-single-tabs__wrap">';
	printf( '<div class="ava-single-tabs__loading">%s</div>', __( 'Loading...', 'ava-woo-builder' ) );
	woocommerce_output_product_data_tabs();
echo '</div>';
