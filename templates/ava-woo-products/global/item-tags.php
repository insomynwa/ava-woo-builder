<?php
/**
 * Loop item tags
 */

$tags = ava_woo_builder_template_functions()->get_product_tags_list();

if ( 'yes' !== $this->get_attr( 'show_tag' ) || false === $tags ) {
	return;
}
?>

<div class="ava-woo-product-tags"><?php echo $tags; ?></div>