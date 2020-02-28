<?php

/**
 * Categories shortcode class
 */
class Ava_Woo_Categories_Shortcode extends Ava_Woo_Builder_Shortcode_Base {

	/**
	 * Shortocde tag
	 *
	 * @return string
	 */
	public function get_tag() {
		return 'ava-woo-categories';
	}

	/**
	 * Shortocde attributes
	 *
	 * @return array
	 */
	public function get_atts() {

		$columns = ava_woo_builder_tools()->get_select_range( 6 );

		return apply_filters( 'ava-woo-builder/shortcodes/ava-woo-categories/atts', array(
			'presets'             => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Category Presets', 'ava-woo-builder' ),
				'default' => 'preset-1',
				'options' => array(
					'preset-1' => esc_html__( 'Preset 1', 'ava-woo-builder' ),
					'preset-2' => esc_html__( 'Preset 2', 'ava-woo-builder' ),
					'preset-3' => esc_html__( 'Preset 3', 'ava-woo-builder' ),
					'preset-4' => esc_html__( 'Preset 4', 'ava-woo-builder' ),
					'preset-5' => esc_html__( 'Preset 5', 'ava-woo-builder' ),
				),
			),
			'columns'            => array(
				'type'       => 'select',
				'responsive' => true,
				'label'      => esc_html__( 'Columns', 'ava-woo-builder' ),
				'default'    => 3,
				'options'    => $columns,
			),
			'columns_tablet'     => array(
				'default' => 2,
			),
			'columns_mobile'     => array(
				'default' => 1,
			),
			'equal_height_cols'  => array(
				'label'        => esc_html__( 'Equal Columns Height', 'ava-woo-builder' ),
				'type'         => 'switcher',
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'true',
				'default'      => '',
			),
			'columns_gap'        => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Add gap between columns', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'rows_gap'           => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Add gap between rows', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'number'             => array(
				'type'      => 'number',
				'label'     => esc_html__( 'Categories Number', 'ava-woo-builder' ),
				'default'   => 3,
				'min'       => - 1,
				'max'       => 1000,
				'step'      => 1,
				'separator' => 'before'
			),
			'hide_empty'         => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Hide Empty', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => '',
			),
			'hide_subcategories' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Hide Subcategories', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => array(
					'show_by' => array( 'all', 'cat_ids' ),
				),
			),
			'hide_default_cat'   => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Hide Uncategorized', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => array(
					'show_by' => array( 'all' ),
				),
			),
			'show_by'            => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Show by', 'ava-woo-builder' ),
				'default' => 'all',
				'options' => array(
					'all'        => esc_html__( 'All', 'ava-woo-builder' ),
					'parent_cat' => esc_html__( 'Parent Category', 'ava-woo-builder' ),
					'cat_ids'    => esc_html__( 'Categories IDs', 'ava-woo-builder' ),
				),
			),
			'parent_cat_ids'     => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Set parent category ID', 'ava-woo-builder' ),
				'default'   => '',
				'condition' => array(
					'show_by' => array( 'parent_cat' ),
				),
			),
			'direct_descendants'   => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show only direct descendants.', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition' => array(
					'show_by' => array( 'parent_cat' ),
				),
			),
			'cat_ids'            => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Set comma seprated IDs list (10, 22, 19 etc.)', 'ava-woo-builder' ),
				'label_block'=> true,
				'default'   => '',
				'condition' => array(
					'show_by' => array( 'cat_ids' ),
				),
			),
			'order'              => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Order by', 'ava-woo-builder' ),
				'default' => 'asc',
				'options' => array(
					'asc'  => esc_html__( 'ASC', 'ava-woo-builder' ),
					'desc' => esc_html__( 'DESC', 'ava-woo-builder' ),
				),
			),
			'sort_by'            => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Sort by', 'ava-woo-builder' ),
				'default' => 'name',
				'options' => array(
					'name'  => esc_html__( 'Name', 'ava-woo-builder' ),
					'id'    => esc_html__( 'IDs', 'ava-woo-builder' ),
					'count' => esc_html__( 'Count', 'ava-woo-builder' ),
				),
			),
			'thumb_size'         => array(
				'type'      => 'select',
				'label'     => esc_html__( 'Featured Image Size', 'ava-woo-builder' ),
				'default'   => 'woocommerce_thumbnail',
				'options'   => ava_woo_builder_tools()->get_image_sizes(),
				'separator' => 'before'
			),
			'show_title'         => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Categories Title', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'title_html_tag'         => array(
				'type'      => 'select',
				'label'     => esc_html__( 'Title HTML Tag', 'ava-woo-builder' ),
				'default'   => 'h5',
				'options'   => ava_woo_builder_tools()->get_available_title_html_tags(),
				'condition' => array(
					'show_title' => array( 'yes' ),
				),
			),
			'show_count'         => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Products Count', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'count_before_text'  => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Count Before Text', 'ava-woo-builder' ),
				'default'   => '(',
				'condition' => array(
					'show_count' => array( 'yes' ),
				),
			),
			'count_after_text'   => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Count After Text', 'ava-woo-builder' ),
				'default'   => ')',
				'condition' => array(
					'show_count' => array( 'yes' ),
				),
			),
			'desc_length'        => array(
				'type'      => 'number',
				'label'     => esc_html__( 'Description Words Count', 'ava-woo-builder' ),
				'description'     => esc_html__( 'Input -1 to show all description and 0 to hide', 'ava-woo-builder' ),
				'min' => -1,
				'default'   => 10,
			),
			'desc_after_text'    => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Trimmed After Text', 'ava-woo-builder' ),
				'default'   => '...',
			),
		) );
	}

	/**
	 * Get type template
	 *
	 * @param  [type] $name [description]
	 *
	 * @return [type]       [description]
	 */
	public function get_category_preset_template() {
		return ava_woo_builder()->get_template( $this->get_tag() . '/global/presets/' . $this->get_attr( 'presets' ) . '.php' );
	}

	/**
	 * Query categories by attributes
	 *
	 * @return object
	 */
	public function query() {
		$defaults = apply_filters(
			'ava-woo-builder/shortcodes/ava-woo-categories/query-args',
			array(
				'post_status'  => 'publish',
				'hierarchical' => 1
			)
		);

		$cat_args = array(
			'number'     => intval( $this->get_attr( 'number' ) ),
			'orderby'    => $this->get_attr( 'sort_by' ),
			'hide_empty' => $this->get_attr( 'hide_empty' ),
			'order'      => $this->get_attr( 'order' ),
		);

		if ( $this->get_attr( 'hide_subcategories' ) ) {
			$cat_args['parent'] = 0;
		}

		if ( $this->get_attr( 'hide_default_cat' ) ) {
			$cat_args['exclude'] = get_option( 'default_product_cat', 0 );
		}

		switch ( $this->get_attr( 'show_by' ) ) {
			case 'parent_cat':
				$direct_descendants = ( 'yes' === $this->get_attr( 'direct_descendants' ) ) ? true : false;

				if( $direct_descendants ){
					$cat_args['parent'] = $this->get_attr( 'parent_cat_ids' );
				} else {
					$cat_args['child_of'] = $this->get_attr( 'parent_cat_ids' );
				}
				break;
			case 'cat_ids' :
				$cat_args['include'] = $this->get_attr( 'cat_ids' );
				break;
			default:
				break;
		}

		$cat_args = wp_parse_args( $cat_args, $defaults );

		$product_categories = get_terms( 'product_cat', $cat_args );

		return $product_categories;
	}

	/**
	 * Categories shortocde function
	 *
	 * @param  array $atts Attributes array.
	 *
	 * @return string
	 */
	public function _shortcode( $content = null ) {
		$query = $this->query();

		if ( empty( $query ) || is_wp_error( $query ) ) {
			echo sprintf( '<h3 class="ava-woo-categories__not-found">%s</h3>', esc_html__( 'Categories not found', 'ava-woo-builder' ) );

			return false;
		}

		$loop_start = $this->get_template( 'loop-start' );
		$loop_item  = $this->get_template( 'loop-item' );
		$loop_end   = $this->get_template( 'loop-end' );

		ob_start();

		/**
		 * Hook before loop start template included
		 */
		do_action( 'ava-woo-builder/shortcodes/ava-woo-categories/loop-start' );

		include $loop_start;

		foreach ( $query as $category ) {
			setup_postdata( $category );

			/**
			 * Hook before loop item template included
			 */
			do_action( 'ava-woo-builder/shortcodes/ava-woo-categories/loop-item-start' );

			include $loop_item;

			/**
			 * Hook after loop item template included
			 */
			do_action( 'ava-woo-builder/shortcodes/ava-woo-categories/loop-item-end' );

		}

		include $loop_end;

		/**
		 * Hook after loop end template included
		 */
		do_action( 'ava-woo-builder/shortcodes/ava-woo-categories/loop-end' );

		wp_reset_postdata();

		return ob_get_clean();

	}

}
