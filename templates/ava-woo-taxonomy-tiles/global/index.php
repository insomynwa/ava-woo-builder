<?php
/**
 * Taxonomy item template
 */

$settings     = $this->get_settings();
$title        = ava_woo_builder_tools()->trim_text( $taxonomy->name, $settings['title_length'], 'word', '...' );
$description  = ava_woo_builder_tools()->trim_text( $taxonomy->description, $settings['desc_length'], 'symbols', '...' );
$count_before = $settings['count_before_text'];
$count_after  = $settings['count_after_text'];
$thumbnail_key = apply_filters( 'ava-woo-builder/ava-woo-taxonomy-tiles/tax_thumbnail', 'thumbnail_id', $taxonomy );

?>
<div class="ava-woo-taxonomy-item">
	<div class="ava-woo-taxonomy-item__box" <?php $this->__get_tax_bg( $taxonomy, $thumbnail_key ); ?>>
		<div class="ava-woo-taxonomy-item__box-content"> <div class="ava-woo-taxonomy-item__box-inner"><?php
			if ( '' !== $title ) {
				echo sprintf( '<div class="ava-woo-taxonomy-item__box-title">%s</div>', $title );
			}

			if ( 'yes' === $settings['show_taxonomy_count'] ) {
				echo sprintf( '<div class="ava-woo-taxonomy-item__box-count">%2$s%1$s%3$s</div>', $taxonomy->count, $count_before, $count_after );
			}

			if ( '' !== $description ) {
				echo sprintf( '<div class="ava-woo-taxonomy-item__box-description">%s</div>', $description );
			}
		?></div></div>
		<a href="<?php echo esc_url( get_category_link( $taxonomy->term_id ) ) ?>" class="ava-woo-taxonomy-item__box-link"></a>
	</div>
</div>