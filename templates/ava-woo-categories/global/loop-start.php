<?php
/**
 * Categories loop start template
 */

$settings         = $this->get_settings();
$classes          = array(
	'ava-woo-categories',
	'ava-woo-categories--' . $this->get_attr( 'presets' ),
	ava_woo_builder_tools()->gap_classes( $this->get_attr( 'columns_gap' ), $this->get_attr( 'rows_gap' ) ),
);
$equal            = $this->get_attr( 'equal_height_cols' );
$carousel_enabled = filter_var( $settings['carousel_enabled'], FILTER_VALIDATE_BOOLEAN );

$carousel_enabled ? array_push( $classes, 'swiper-wrapper' ) : array_push( $classes, 'col-row' );

if ( $equal ) {
	$classes[] = 'ava-equal-cols';
}
?>

<div class="<?php echo implode( ' ', $classes ); ?>">