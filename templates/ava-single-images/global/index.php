<?php
/**
 * Images template
 */
echo '<div class="ava-single-images__wrap">';
	printf( '<div class="ava-single-images__loading">%s</div>', __( 'Loading...', 'ava-woo-builder' ) );
	woocommerce_show_product_images();
echo '</div>';
