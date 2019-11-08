<?php
/**
 * Categories loop item layout 3
 */

?>

<?php include $this->get_template( 'item-thumb' ); ?>
<div class="ava-woo-categories-content">
	<div class="ava-woo-categories-title__wrap"><?php
	  include $this->get_template( 'item-title' );
	  include $this->get_template( 'item-count' );
	  ?></div><?php
	include $this->get_template( 'item-description' );
	?></div>