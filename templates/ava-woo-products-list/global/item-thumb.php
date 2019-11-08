<?php
/**
 * Loop item thumbnail
 */

$size = $this->get_attr( 'thumb_size' );
$thumbnail = ava_woo_builder_template_functions()->get_product_thumbnail( $size );

if ( 'yes' !== $this->get_attr( 'show_image' ) || null === $thumbnail ) {
	return;
}
?>

<div class="ava-woo-product-thumbnail"><?php
	do_action('ava-woo-builder/templates/products-list/before-item-thumbnail');
	echo $thumbnail;
	do_action('ava-woo-builder/templates/products-list/after-item-thumbnail');
	?></div>