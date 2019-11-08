<?php
/**
 * Archive category item template
 */
?>
<li <?php wc_product_cat_class( '', $category ); ?>><?php
	$template = apply_filters( 'ava-woo-builder/current-template/template-id', ava_woo_builder_integration_woocommerce()->get_current_archive_category_template() );

	echo ava_woo_builder()->parser->get_template_content( $template );
?></li>