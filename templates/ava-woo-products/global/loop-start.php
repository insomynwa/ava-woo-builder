<?php
/**
 * Products loop start template
 */

$classes = array(
	'ava-woo-products',
	'ava-woo-products--' . $this->get_attr( 'presets' ),
	'col-row',
	ava_woo_builder_tools()->gap_classes( $this->get_attr( 'columns_gap' ), $this->get_attr( 'rows_gap' ) ),
);

$equal = $this->get_attr( 'equal_height_cols' );

if ( $equal ) {
	$classes[] = 'ava-equal-cols';
}

?>

<div class="<?php echo implode( ' ', $classes ); ?>">