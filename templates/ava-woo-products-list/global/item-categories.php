<?php
/**
 * Loop item categories
 */

$categories = ava_woo_builder_template_functions()->get_product_categories_list();

if ( 'yes' !== $this->get_attr( 'show_cat' ) ) {
	return;
}
?>

<div class="ava-woo-product-categories"><?php echo $categories; ?></div>