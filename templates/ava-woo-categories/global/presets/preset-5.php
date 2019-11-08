<?php
/**
 * Categories loop item layout 5
 */

?>

<div class="ava-woo-categories-thumbnail__wrap"><?php include $this->get_template( 'item-thumb' ); ?></div>
<div class="ava-woo-categories-content">
	<div class="ava-woo-category-content__inner">
	  <?php
	  include $this->get_template( 'item-title' );
	  include $this->get_template( 'item-description' );
	  ?>
	</div>
	<div class="ava-woo-category-count__wrap"><?php include $this->get_template( 'item-count' ); ?></div>
</div>