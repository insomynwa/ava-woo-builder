<?php
/**
 * Categories loop start template
 */

$classes = array(
	'ava-woo-categories',
	'ava-woo-categories--' . $this->get_attr( 'presets' ),
	'col-row',
	ava_woo_builder_tools()->gap_classes( $this->get_attr( 'columns_gap' ), $this->get_attr( 'rows_gap' ) ),
);

$equal = $this->get_attr( 'equal_height_cols' );

if ( $equal ) {
	$classes[] = 'ava-equal-cols';
}
?>

<div class="<?php echo implode( ' ', $classes ); ?>">