<?php
/**
 * Loop item price
 */

$rating = ava_woo_builder_template_functions()->get_product_rating();

if ( 'yes' !== $this->get_attr( 'show_rating' ) || '' === $rating ) {
	return;
}
?>

<div class="ava-woo-product-rating"><?php echo $rating; ?></div>