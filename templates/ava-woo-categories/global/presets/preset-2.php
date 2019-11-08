<?php
/**
 * Categories loop item layout 2
 */


?>

<?php include $this->get_template( 'item-thumb' ); ?>
<div class="ava-woo-categories-content"><?php
	include $this->get_template( 'item-title' );
	include $this->get_template( 'item-description' );
	?><div class="ava-woo-category-count__wrap"><?php include $this->get_template( 'item-count' ); ?></div>
</div>
