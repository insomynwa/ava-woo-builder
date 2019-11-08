<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Ava_Woo_Builder_Compatibility' ) ) {

	/**
	 * Define Ava_Woo_Builder_Compatibility class
	 */
	class Ava_Woo_Builder_Compatibility {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Constructor for the class
		 */
		public function init() {
			// WPML String Translation plugin exist check
			if ( defined( 'WPML_ST_VERSION' ) ) {
				add_filter( 'wpml_elementor_widgets_to_translate', array( $this, 'add_translatable_nodes' ) );
				add_filter( 'ava-woo-builder/current-template/template-id', array( $this, 'ava_woo_builder_modify_template_id' ) );
			}
		}


		function ava_woo_builder_modify_template_id( $template_id ) {
			// WPML String Translation plugin exist check
			return apply_filters( 'wpml_object_id', $template_id, ava_woo_builder_post_type()->slug(), true );
		}

		/**
		 * Load required files.
		 *
		 * @return void
		 */
		public function load_files() {
		}

		/**
		 * Add ava elements translation nodes
		 *
		 * @param array
		 */
		public function add_translatable_nodes( $nodes_to_translate ) {

			$nodes_to_translate[ 'ava-woo-products' ] = array(
				'conditions' => array( 'widgetType' => 'ava-woo-products' ),
				'fields'     => array(
					array(
						'field'       => 'sale_badge_text',
						'type'        => esc_html__( 'Ava Woo Products Grid: Set sale badge text', 'ava-woo-builder' ),
						'editor_type' => 'LINE',
					),
				),
			);

			$nodes_to_translate[ 'ava-woo-categories' ] = array(
				'conditions' => array( 'widgetType' => 'ava-woo-categories' ),
				'fields'     => array(
					array(
						'field'       => 'count_before_text',
						'type'        => esc_html__( 'Ava Woo Categories Grid: Count Before Text', 'ava-woo-builder' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'count_after_text',
						'type'        => esc_html__( 'Ava Woo Categories Grid: Count After Text', 'ava-woo-builder' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'desc_after_text',
						'type'        => esc_html__( 'Ava Woo Categories Grid: Trimmed After Text', 'ava-woo-builder' ),
						'editor_type' => 'LINE',
					),
				),
			);

			$nodes_to_translate[ 'ava-woo-taxonomy-tiles' ] = array(
				'conditions' => array( 'widgetType' => 'ava-woo-taxonomy-tiles' ),
				'fields'     => array(
					array(
						'field'       => 'count_before_text',
						'type'        => esc_html__( 'Ava Woo Taxonomy Tiles: Count Before Text', 'ava-woo-builder' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'count_after_text',
						'type'        => esc_html__( 'Ava Woo Taxonomy Tiles: Count After Text', 'ava-woo-builder' ),
						'editor_type' => 'LINE',
					),
				),
			);

			$nodes_to_translate[ 'ava-single-attributes' ] = array(
				'conditions' => array( 'widgetType' => 'ava-single-attributes' ),
				'fields'     => array(
					array(
						'field'       => 'block_title',
						'type'        => esc_html__( 'Ava Woo Single Attributes: Title Text', 'ava-woo-builder' ),
						'editor_type' => 'LINE',
					),
				),
			);

			$nodes_to_translate[ 'ava-woo-builder-archive-sale-badge' ] = array(
				'conditions' => array( 'widgetType' => 'ava-woo-builder-archive-sale-badge' ),
				'fields'     => array(
					array(
						'field'       => 'block_title',
						'type'        => esc_html__( 'Ava Woo Archive Sale Badge: Sale Badge Text', 'ava-woo-builder' ),
						'editor_type' => 'LINE',
					),
				),
			);

			$nodes_to_translate[ 'ava-woo-builder-archive-category-count' ] = array(
				'conditions' => array( 'widgetType' => 'ava-woo-builder-archive-category-count' ),
				'fields'     => array(
					array(
						'field'       => 'archive_category_count_before_text',
						'type'        => esc_html__( 'Ava Woo Archive Category Count: Count Before Text', 'ava-woo-builder' ),
						'editor_type' => 'LINE',
					),
				),
			);

			$nodes_to_translate[ 'ava-woo-builder-archive-category-count' ] = array(
				'conditions' => array( 'widgetType' => 'ava-woo-builder-archive-category-count' ),
				'fields'     => array(
					array(
						'field'       => 'archive_category_count_after_text',
						'type'        => esc_html__( 'Ava Woo Archive Category Count: Count After Text', 'ava-woo-builder' ),
						'editor_type' => 'LINE',
					),
				),
			);

			$nodes_to_translate[ 'ava-woo-builder-products-navigation' ] = array(
				'conditions' => array( 'widgetType' => 'ava-woo-builder-products-navigation' ),
				'fields'     => array(
					array(
						'field'       => 'prev_text',
						'type'        => esc_html__( 'Ava Woo Shop Products Navigation: The previous page link text', 'ava-woo-builder' ),
						'editor_type' => 'LINE',
					),
				),
			);

			$nodes_to_translate[ 'ava-woo-builder-products-navigation' ] = array(
				'conditions' => array( 'widgetType' => 'ava-woo-builder-products-navigation' ),
				'fields'     => array(
					array(
						'field'       => 'next_text',
						'type'        => esc_html__( 'Ava Woo Shop Products Navigation: The next page link text', 'ava-woo-builder' ),
						'editor_type' => 'LINE',
					),
				),
			);

			$nodes_to_translate[ 'ava-woo-builder-products-pagination' ] = array(
				'conditions' => array( 'widgetType' => 'ava-woo-builder-products-pagination' ),
				'fields'     => array(
					array(
						'field'       => 'prev_text',
						'type'        => esc_html__( 'Ava Woo Shop Products Pagination: The previous page link text', 'ava-woo-builder' ),
						'editor_type' => 'LINE',
					),
				),
			);

			$nodes_to_translate[ 'ava-woo-builder-products-pagination' ] = array(
				'conditions' => array( 'widgetType' => 'ava-woo-builder-products-pagination' ),
				'fields'     => array(
					array(
						'field'       => 'next_text',
						'type'        => esc_html__( 'Ava Woo Shop Products Pagination: The next page link text', 'ava-woo-builder' ),
						'editor_type' => 'LINE',
					),
				),
			);

			return $nodes_to_translate;
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}

}

/**
 * Returns instance of Ava_Woo_Builder_Compatibility
 *
 * @return object
 */
function ava_woo_builder_compatibility() {
	return Ava_Woo_Builder_Compatibility::get_instance();
}
