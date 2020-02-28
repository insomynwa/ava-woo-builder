<?php

/**
 * Products shortcode class
 */
class Ava_Woo_Products_Shortcode extends Ava_Woo_Builder_Shortcode_Base {

	/**
	 * Shortocde tag
	 *
	 * @return string
	 */
	public function get_tag() {
		return 'ava-woo-products';
	}

	/**
	 * Shortocde attributes
	 *
	 * @return array
	 */
	public function get_atts() {

		$columns = ava_woo_builder_tools()->get_select_range( 6 );

		return apply_filters( 'ava-woo-builder/shortcodes/ava-woo-products/atts', array(
			'presets'               => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Product Presets', 'ava-woo-builder' ),
				'default' => 'preset-1',
				'options' => array(
					'preset-1'  => esc_html__( 'Preset 1', 'ava-woo-builder' ),
					'preset-2'  => esc_html__( 'Preset 2', 'ava-woo-builder' ),
					'preset-3'  => esc_html__( 'Preset 3', 'ava-woo-builder' ),
					'preset-4'  => esc_html__( 'Preset 4', 'ava-woo-builder' ),
					'preset-5'  => esc_html__( 'Preset 5', 'ava-woo-builder' ),
					'preset-6'  => esc_html__( 'Preset 6', 'ava-woo-builder' ),
					'preset-7'  => esc_html__( 'Preset 7 ', 'ava-woo-builder' ),
					'preset-8'  => esc_html__( 'Preset 8 ', 'ava-woo-builder' ),
					'preset-9'  => esc_html__( 'Preset 9 ', 'ava-woo-builder' ),
					'preset-10' => esc_html__( 'Preset 10', 'ava-woo-builder' ),
				),
			),
			'columns'               => array(
				'type'       => 'select',
				'responsive' => true,
				'label'      => esc_html__( 'Columns', 'ava-woo-builder' ),
				'default'    => 3,
				'options'    => $columns,
			),
			'columns_tablet'        => array(
				'default' => 2,
			),
			'columns_mobile'        => array(
				'default' => 1,
			),
			'equal_height_cols'     => array(
				'label'        => esc_html__( 'Equal Columns Height', 'ava-woo-builder' ),
				'type'         => 'switcher',
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'true',
				'default'      => '',
			),
			'columns_gap'           => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Add gap between columns', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'rows_gap'              => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Add gap between rows', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'use_current_query'     => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Use Current Query', 'ava-woo-builder' ),
				'description'  => esc_html__( 'This option works only on the shop archive page, and allows you to display products for current categories, tags and taxonomies.', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => '',
				'separator' => 'before'
			),
			'number'                => array(
				'type'      => 'number',
				'label'     => esc_html__( 'Products Number', 'ava-woo-builder' ),
				'default'   => 3,
				'min'       => - 1,
				'max'       => 1000,
				'step'      => 1,
			),
			'products_query'        => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Query products by', 'ava-woo-builder' ),
				'default' => 'all',
				'options' => $this->get_products_query_type(),
				'condition' => array(
					'use_current_query!' => 'yes'
				)
			),
			'products_ids'          => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Set comma separated IDs list (10, 22, 19 etc.)', 'ava-woo-builder' ),
				'label_block'=> true,
				'default'   => '',
				'condition' => array(
					'products_query' => array( 'ids' ),
					'use_current_query!' => 'yes'
				),
			),
			'products_cat'          => array(
				'type'        => 'select2',
				'label'       => esc_html__( 'Category', 'ava-woo-builder' ),
				'default'     => '',
				'multiple'    => true,
				'label_block' => true,
				'options'     => $this->get_product_categories(),
				'condition'   => array(
					'products_query'     => array( 'category' ),
					'use_current_query!' => 'yes',
				),
			),
			'products_tag'          => array(
				'type'        => 'select2',
				'label'       => esc_html__( 'Tag', 'ava-woo-builder' ),
				'default'     => '',
				'multiple'    => true,
				'label_block' => true,
				'options'     => $this->get_product_tags(),
				'condition'   => array(
					'products_query'     => array( 'tag' ),
					'use_current_query!' => 'yes'
				),
			),
			'products_order'        => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Order by', 'ava-woo-builder' ),
				'default' => 'default',
				'options' => array(
					'default'    => esc_html__( 'Date', 'ava-woo-builder' ),
					'price'      => esc_html__( 'Price', 'ava-woo-builder' ),
					'rand'       => esc_html__( 'Random', 'ava-woo-builder' ),
					'sales'      => esc_html__( 'Sales', 'ava-woo-builder' ),
					'rated'      => esc_html__( 'Top rated', 'ava-woo-builder' ),
					'menu_order' => esc_html__( 'Menu Order', 'ava-woo-builder' ),
					'current'    => esc_html__( 'Current', 'ava-woo-builder' ),
				),
				'condition' => array(
					'use_current_query!' => 'yes'
				)
			),
			'show_title'            => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Products Title', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before'
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
			'title_trim_type' => array(
				'type'      => 'select',
				'label'     => esc_html__( 'Title Trim Type', 'ava-woo-builder' ),
				'default'   => 'word',
				'options'   => array(
					'word'    => 'Words',
					'letters' => 'Letters',
				),
				'condition' => array(
					'show_title' => array( 'yes' ),
				),
			),
			'title_length'          => array(
				'type'      => 'number',
				'label'     => esc_html__( 'Title Words/Letters Count', 'ava-woo-builder' ),
				'min'       => 1,
				'default'   => 10,
				'condition' => array(
					'show_title' => array( 'yes' )
				)
			),
			'thumb_size'            => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Featured Image Size', 'ava-woo-builder' ),
				'default' => 'woocommerce_thumbnail',
				'options' => ava_woo_builder_tools()->get_image_sizes(),
			),
			'show_badges'           => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Badges', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'sale_badge_text'       => array(
				'type'        => 'text',
				'label'       => esc_html__( 'Set sale badge text', 'ava-woo-builder' ),
				'default'     => esc_html__( 'Sale!', 'ava-woo-builder' ),
				'description' => esc_html__( 'Use %percentage_sale% and %numeric_sale% macros to display a withdrawal of discounts as a percentage or numeric of the initial price.', 'ava-woo-builder' ),
				'condition'   => array(
					'show_badges' => array( 'yes' ),
				),
			),
			'show_stock_status'     => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Product Stock Status', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => '',
			),
			'in_stock_status_text'  => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Set In Stock Status Text', 'ava-woo-builder' ),
				'default'   => esc_html__( 'In Stock', 'ava-woo-builder' ),
				'condition' => array(
					'show_stock_status' => array( 'yes' ),
				),
			),
			'on_backorder_status_text'  => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Set On Backorder Status Text', 'ava-woo-builder' ),
				'default'   => esc_html__( 'On Backorder', 'ava-woo-builder' ),
				'condition' => array(
					'show_stock_status' => array( 'yes' ),
				),
			),
			'out_of_stock_status_text' => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Set Out of Stock Status Text', 'ava-woo-builder' ),
				'default'   => esc_html__( 'Out of Stock', 'ava-woo-builder' ),
				'condition' => array(
					'show_stock_status' => array( 'yes' ),
				),
			),
			'show_excerpt'          => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Product Excerpt', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'presets!' => array( 'preset-4' )
				)
			),
			'excerpt_trim_type' => array(
				'type'      => 'select',
				'label'     => esc_html__( 'Excerpt Trim Type', 'ava-woo-builder' ),
				'default'   => 'word',
				'options'   => array(
					'word'    => 'Words',
					'letters' => 'Letters',
				),
				'condition' => array(
					'show_title' => array( 'yes' ),
				),
			),
			'excerpt_length'        => array(
				'type'      => 'number',
				'label'     => esc_html__( 'Excerpt Words/Letters Count', 'ava-woo-builder' ),
				'min'       => 1,
				'default'   => 10,
				'condition' => array(
					'show_excerpt' => array( 'yes' )
				)
			),
			'show_cat'              => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Product Categories', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'show_tag'              => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Product Tags', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'show_price'            => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Product Price', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'show_rating'           => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Product Rating', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'show_sku'           => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show SKU', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => '',
			),
			'show_button'           => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Add To Cart Button', 'ava-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'button_use_ajax_style' => array(
				'label'        => esc_html__( 'Use default ajax add to cart styles', 'ava-woo-builder' ),
				'description'  => esc_html__( 'This option enables default WooCommerce styles for \'Add to Cart\' ajax button (\'Loading\' and \'Added\' statements)', 'ava-woo-builder' ),
				'type'         => 'switcher',
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => array(
					'show_button' => array( 'yes' )
				)
			),
			'not_found_message' => array(
				'type'    => 'text',
				'label'   => esc_html__( 'Not found message', 'ava-woo-builder' ),
				'default' => esc_html__( 'Products not found', 'ava-woo-builder' ),
			),
		) );

	}

	/**
	 * Return list query types
	 *
	 * @return array
	 */
	public function get_products_query_type() {
		$args = array(
			'all'      => esc_html__( 'All', 'ava-woo-builder' ),
			'featured' => esc_html__( 'Featured', 'ava-woo-builder' ),
			'sale'     => esc_html__( 'Sale', 'ava-woo-builder' ),
			'tag'      => esc_html__( 'Tag', 'ava-woo-builder' ),
			'category' => esc_html__( 'Category', 'ava-woo-builder' ),
			'ids'      => esc_html__( 'Specific IDs', 'ava-woo-builder' ),
			'viewed'   => esc_html__( 'Recently Viewed', 'ava-woo-builder' ),
		);

		$single_product_args = array(
			'related'     => esc_html__( 'Related', 'ava-woo-builder' ),
			'up-sells'    => esc_html__( 'Up Sells', 'ava-woo-builder' ),
			'cross-sells' => esc_html__( 'Cross Sells', 'ava-woo-builder' ),
		);

		if ( is_product() ) {
			$args = wp_parse_args( $single_product_args, $args );
		}

		return $args;
	}

	/**
	 * Get categories list.
	 *
	 * @return array
	 */
	public function get_product_categories() {

		$categories = get_terms( 'product_cat' );

		if ( empty( $categories ) || ! is_array( $categories ) ) {
			return array();
		}

		return wp_list_pluck( $categories, 'name', 'term_id' );

	}

	/**
	 * Get categories list.
	 *
	 * @return array
	 */
	public function get_product_tags() {

		$tags = get_terms( 'product_tag' );

		if ( empty( $tags ) || ! is_array( $tags ) ) {
			return array();
		}

		return wp_list_pluck( $tags, 'name', 'term_id' );

	}

	/**
	 * Get preset template
	 *
	 * @param  [type] $name [description]
	 *
	 * @return [type]       [description]
	 */
	public function get_product_preset_template() {
		return ava_woo_builder()->get_template( $this->get_tag() . '/global/presets/' . $this->get_attr( 'presets' ) . '.php' );
	}

	/**
	 * Query products by attributes
	 *
	 * @return object
	 */
	public function query() {

		$defaults = apply_filters( 'ava-woo-builder/shortcodes/ava-woo-products/query-args', array(
			'post_status'   => 'publish',
			'post_type'     => 'product',
			'no_found_rows' => 1,
			'meta_query'    => array(),
			'tax_query'     => array(
				'relation' => 'AND',
			)
		), $this );

		if ( 'yes' === $this->get_attr( 'use_current_query' ) ) {

			if ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) {
				global $wp_query;

				$wp_query->set( 'ava_use_current_query', 'yes' );
				$wp_query->set( 'posts_per_page', intval( $this->get_attr( 'number' ) ) );

				$default_query = array(
					'post_type'      => $wp_query->get( 'post_type' ),
					'wc_query'       => $wp_query->get( 'wc_query' ),
					'tax_query'      => $wp_query->get( 'tax_query' ),
					'meta_query'      => $wp_query->get( 'meta_query' ),
					'orderby'        => $wp_query->get( 'orderby' ),
					'order'        => $wp_query->get( 'order' ),
					'posts_per_page' => intval( $this->get_attr( 'number' ) ),
					'paged'          => $wp_query->get( 'paged' )
				);

				if ( $wp_query->get( 'taxonomy' ) ) {
					$default_query['taxonomy'] = $wp_query->get( 'taxonomy' );
					$default_query['term']     = $wp_query->get( 'term' );
				}

				if ( is_search() ){
					$default_query['s'] = $wp_query->get( 's' );
				}

				$query_args = wp_parse_args( $wp_query->query_vars, $defaults );

				// Ensure ava-woo-builder/shortcodes/ava-woo-products/query-args hook correctly fires even for archive (For filters compat)
				$defaults = apply_filters( 'ava-woo-builder/shortcodes/ava-woo-products/query-args', $query_args, $this );

				$query_args = $this->get_wc_catalog_ordering_args( $query_args );

				return new WP_Query( $query_args );

			}

		}

		$query_type                   = $this->get_attr( 'products_query' );
		$query_order                  = $this->get_attr( 'products_order' );
		$query_args['posts_per_page'] = intval( $this->get_attr( 'number' ) );
		$product_visibility_term_ids  = wc_get_product_visibility_term_ids();
		$viewed_products              = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : array();
		$viewed_products              = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

		if ( ( 'viewed' === $query_type ) && empty( $viewed_products ) ) {
			return false;
		}

		if ( $this->is_single_linked_products( $query_type ) ) {
			global $product;
			$product = wc_get_product();

			if ( ! $product ) {
				return false;
			}

			switch ( $query_type ) {
				case 'related':
					$query_args['post__in'] = wc_get_related_products( $product->get_id(), $query_args['posts_per_page'], $product->get_upsell_ids() );
					$query_args['orderby']  = 'post__in';
					break;
				case 'up-sells':
					$query_args['post__in'] = $product->get_upsell_ids();
					$query_args['orderby']  = 'post__in';
					break;
				case 'cross-sells':
					$query_args['post__in'] = $product->get_cross_sell_ids();
					$query_args['orderby']  = 'post__in';
					break;
			}

			if ( empty( $query_args['post__in'] ) ) {
				return false;
			}
		}

		switch ( $query_type ) {
			case 'category':
				if ( '' !== $this->get_attr( 'products_cat' ) ) {
					$query_args['tax_query'][] = array(
						'taxonomy' => 'product_cat',
						'field'    => 'term_id',
						'terms'    => explode( ',', $this->get_attr( 'products_cat' ) ),
						'operator' => 'IN',
					);
				}
				break;
			case 'tag':
				if ( '' !== $this->get_attr( 'products_tag' ) ) {
					$query_args['tax_query'][] = array(
						'taxonomy' => 'product_tag',
						'field'    => 'term_id',
						'terms'    => explode( ',', $this->get_attr( 'products_tag' ) ),
						'operator' => 'IN',
					);
				}
				break;
			case 'ids':
				if ( '' !== $this->get_attr( 'products_ids' ) ) {
					$query_args['post__in'] = explode(
						',',
						str_replace( ' ', '', $this->get_attr( 'products_ids' ) )
					);
				}
				break;
			case 'featured':
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['featured'],
				);
				break;
			case 'sale':
				$product_ids_on_sale    = wc_get_product_ids_on_sale();
				$product_ids_on_sale[]  = 0;
				$query_args['post__in'] = $product_ids_on_sale;
				break;
			case 'viewed':
				$query_args['post__in'] = $viewed_products;
				$query_args['orderby']  = 'post__in';
		}

		switch ( $query_order ) {
			case 'price' :
				$query_args['meta_key'] = '_price';
				$query_args['orderby']  = 'meta_value_num';
				break;
			case 'rand' :
				$query_args['orderby'] = 'rand';
				break;
			case 'sales' :
				$query_args['meta_key'] = 'total_sales';
				$query_args['orderby']  = 'meta_value_num';
				break;
			case 'rated':
				$query_args['meta_key'] = '_wc_average_rating';
				$query_args['orderby']  = 'meta_value_num';
				break;
			case 'current':
				$query_args = $this->get_wc_catalog_ordering_args( $query_args );
				break;
			case 'menu_order':
				$query_args['orderby']  = 'menu_order';
				break;
			default :
				$query_args['orderby'] = 'date';
		}

		if ( 'yes' == get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
			$query_args['meta_query'][] = array(
				'key'     => '_stock_status',
				'value'   => 'outofstock',
				'compare' => 'NOT LIKE',
			);
		}

		$query_args = wp_parse_args( $query_args, $defaults );
		$query_args = apply_filters( 'ava-woo-builder/shortcodes/ava-woo-products/final-query-args', $query_args );

		return new WP_Query( $query_args );

	}

	/**
	 * Return true if linked products query type
	 *
	 * @param $query_type
	 *
	 * @return bool
	 */
	public function is_single_linked_products( $query_type ) {

		if ( 'related' === $query_type || 'up-sells' === $query_type || 'cross-sells' === $query_type ) {
			return true;
		}

		return false;

	}

	/**
	 * Add WooCommerce catalog ordering args to current query
	 *
	 * @param $query_args
	 *
	 * @return array
	 */
	public function get_wc_catalog_ordering_args( $query_args ) {

		if ( !isset( $query_args['orderby'] ) ){
            $query_args['orderby'] = 'date';
        }

		// @codingStandardsIgnoreStart
		$ordering_args                = WC()->query->get_catalog_ordering_args( $query_args['orderby'], $query_args['order'] );
		$query_args['orderby']        = $ordering_args['orderby'];
		$query_args['order']          = $ordering_args['order'];
		if ( $ordering_args['meta_key'] ) {
			$query_args['meta_key']       = $ordering_args['meta_key'];
		}

		return $query_args;

	}

	/**
	 * Products shortocde function
	 *
	 * @param  array $atts Attributes array.
	 *
	 * @return string
	 */
	public function _shortcode( $content = null ) {
		$query = $this->query();
		$not_found_message = $this->get_attr( 'not_found_message' );

		if (  false === $query || empty( $query ) || is_wp_error( $query ) || !$query->have_posts() ) {
			echo sprintf( '<h3 class="ava-woo-products__not-found">%s</h3>', $not_found_message );

			return false;
		}

		$loop_start = $this->get_template( 'loop-start' );
		$loop_item  = $this->get_template( 'loop-item' );
		$loop_end   = $this->get_template( 'loop-end' );

		global $post;

		ob_start();

		/**
		 * Hook before loop start template included
		 */
		do_action( 'ava-woo-builder/shortcodes/ava-woo-products/loop-start' );

		include $loop_start;

		while ( $query->have_posts() ) {

			$query->the_post();
			$post = $query->post;

			setup_postdata( $post );

			/**
			 * Hook before loop item template included
			 */
			do_action( 'ava-woo-builder/shortcodes/ava-woo-products/loop-item-start' );

			include $loop_item;

			/**
			 * Hook after loop item template included
			 */
			do_action( 'ava-woo-builder/shortcodes/ava-woo-products/loop-item-end' );

		}

		include $loop_end;

		/**
		 * Hook after loop end template included
		 */
		do_action( 'ava-woo-builder/shortcodes/ava-woo-products/loop-end' );

		wp_reset_postdata();

		return ob_get_clean();

	}

}
