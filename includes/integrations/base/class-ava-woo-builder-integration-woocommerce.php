<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    Cherry Team
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Ava_Woo_Builder_Integration_Woocommerce' ) ) {

	/**
	 * Define Ava_Woo_Builder_Integration_Woocommerce class
	 */
	class Ava_Woo_Builder_Integration_Woocommerce {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;
		private $current_template = null;
		private $current_template_archive = null;
		private $current_template_archive_category = null;
		private $current_template_shop = null;
		private $current_template_taxonomy = null;
		private $current_loop = null;
		private $current_category_args = array();

		/**
		 * Constructor for the class
		 */
		public function init() {

			add_filter( 'wc_get_template_part', array( $this, 'rewrite_templates' ), 10, 3 );

			add_filter( 'wc_get_template', array( $this, 'rewrite_category_templates' ), 10, 5 );

			if ( 'yes' === ava_woo_builder_shop_settings()->get( 'use_native_templates' ) ) {
				add_filter( 'wc_get_template', array( $this, 'force_wc_templates' ), 10, 2 );
			}

			if ( 'yes' === ava_woo_builder_shop_settings()->get( 'custom_shop_page' ) ) {
				add_filter( 'template_include', array( $this, 'set_shop_page_template' ), 12 );
			}

			if ( 'yes' === ava_woo_builder_shop_settings()->get( 'custom_taxonomy_template' ) ) {
				add_action( 'init',  array( $this, 'taxonomy_meta' ), 99 );

				add_filter( 'template_include', array( $this, 'set_taxonomy_page_template' ), 12 );
			}

			// Set blank page template for editing product content with Elementor
			add_action( 'template_include', array( $this, 'set_product_template' ), 9999 );

			add_action( 'init', array( $this, 'product_meta' ), 99 );

			add_filter( 'ava-woo-builder/custom-single-template', array( $this, 'force_preview_template' ) );
			add_filter( 'ava-woo-builder/integration/doc-type', array( $this, 'force_preview_doc_type' ) );
			add_filter( 'ava-woo-builder/integration/doc-type', array( $this, 'force_product_doc_type' ) );

			add_filter( 'woocommerce_output_related_products_args', array(
				$this,
				'set_related_products_output_count'
			) );
			add_filter( 'woocommerce_upsell_display_args', array( $this, 'set_up_sells_products_output_count' ) );
			add_filter( 'woocommerce_cross_sells_total', array( $this, 'set_cross_sells_products_output_count' ) );
			add_filter( 'woocommerce_product_loop_start', array( $this, 'set_archive_template_custom_columns' ) );

			// Shop Template Hooks
			add_action( 'ava-woo-builder/woocommerce/before-main-content', 'woocommerce_output_content_wrapper', 10 );
			add_action( 'ava-woo-builder/woocommerce/after-main-content', 'woocommerce_output_content_wrapper_end', 10 );
			add_filter( 'ava-woo-builder/render-callback/custom-args', array( $this, 'get_archive_category_args' ) );

			//Products Navigation Hooks
			add_filter( 'previous_posts_link_attributes', [ $this, 'set_previous_product_link_class' ] );
			add_filter( 'next_posts_link_attributes', [ $this, 'set_next_product_link_class' ] );

			add_action( 'wp_enqueue_scripts', array( $this, 'maybe_enqueue_single_template_css' ) );
		}

		/**
		 * Enqueue Single Template Styles
		 */
		public function maybe_enqueue_single_template_css() {

			$current_template = $this->get_custom_single_template();

			if ( !is_product() ){
				return;
			}

			if ( ! $current_template ) {
				return;
			}

			if ( class_exists( 'Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new Elementor\Core\Files\CSS\Post( $current_template );
			} else {
				$css_file = new Elementor\Post_CSS_File( $current_template );
			}

			$css_file->enqueue();

		}

		/**
		 * Initialize template metabox
		 *
		 * @return void
		 */
		public function product_meta() {

			new Cherry_X_Post_Meta( array(
				'id'            => 'template-settings',
				'title'         => esc_html__( 'Ava Woo Builder Template Settings', 'ava-woo-builder' ),
				'page'          => array( 'product' ),
				'context'       => 'side',
				'priority'      => 'low',
				'callback_args' => false,
				'builder_cb'    => array( ava_woo_builder_post_type(), 'get_builder' ),
				'fields'        => array(
					'_ava_woo_template' => array(
						'type'              => 'select',
						'element'           => 'control',
						'options'           => false,
						'options_callback'  => array( $this, 'get_single_templates' ),
						'label'             => esc_html__( 'Custom Template', 'ava-woo-builder' ),
						'sanitize_callback' => 'esc_attr',
					),
					'_template_type'    => array(
						'type'              => 'select',
						'element'           => 'control',
						'default'           => 'default',
						'options'           => array(
							'default' => esc_html__( 'Default', 'ava-woo-builder' ),
							'canvas'  => esc_html__( 'Canvas', 'ava-woo-builder' ),
						),
						'label'             => esc_html__( 'Template Type', 'ava-woo-builder' ),
						'sanitize_callback' => 'esc_attr',
					),
				),
			) );

		}

		/**
		 * Initialize, edit and update AetWoo Builder templates meta box.
		 *
		 * @return void
		 */
		public function taxonomy_meta() {

			if( ! is_admin() ){
				return;
			}

			$args = array(
				'public' => true
			);
			$output = 'objects';
			$taxonomies = get_taxonomies( $args, $output );

			foreach ( $taxonomies as $taxonomy ) {

				if ( $taxonomy->name === 'product_cat' || $taxonomy->name === 'product_tag' ) {

					// Add fields in taxonomy create form
					add_action( $taxonomy->name . '_add_form_fields', array( $this, 'taxonomy_add_new_meta_field' ), 10, 1 );
					// Add fields in taxonomy edit form
					add_action( $taxonomy->name . '_edit_form_fields', array( $this, 'taxonomy_edit_meta_field' ), 10, 1 );

					// Process edit form fields
					add_action( 'edited_' . $taxonomy->name, array( $this, 'save_taxonomy_custom_meta' ), 10, 1 );
					// Process create form fields
					add_action( 'create_' . $taxonomy->name, array( $this, 'save_taxonomy_custom_meta' ), 10, 1 );

				}

			}

		}

		/**
		 * Add fields in taxonomy create form
		 *
		 * @return void
		 */
		public function taxonomy_add_new_meta_field() {
			$templates = $this->get_shop_templates(); ?>
			<div class="form-field">
				<label for="ava_woo_builder_template"><strong><?php echo esc_html__( 'Custom Template', 'ava-woo-builder' ); ?></strong></label>
				<select name="ava_woo_builder_template" id="ava_woo_builder_template">
					<?php foreach ( $templates as $template_id => $template_title ) : ?>
						<option value="<?php echo esc_attr( $template_id ); ?>"><?php echo esc_attr( $template_title ); ?></option>
					<?php endforeach; ?>
				</select>
				<p><em><?php echo esc_html__( 'It will be applied on singular layout of this term.', 'ava-woo-builder' ); ?></em></p>
			</div>
		<?php }

		/**
		 * Add fields in taxonomy edit form
		 *
		 * @param $term
		 * @return void
		 */
		public function taxonomy_edit_meta_field($term) {

			$term_id = $term->term_id;
			$templates = $this->get_shop_templates();
			$ava_woo_builder_template = get_term_meta($term_id, 'ava_woo_builder_template', true); ?>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="ava_woo_builder_template"><?php echo esc_html__( 'Custom Template', 'ava-woo-builder' ); ?></label>
				</th>
				<td>
					<select name="ava_woo_builder_template" id="ava_woo_builder_template">
						<?php foreach ( $templates as $template_id => $template_title ) : ?>
							<option value="<?php echo esc_attr( $template_id ); ?>" <?php selected( $ava_woo_builder_template, $template_id ); ?>><?php echo esc_attr( $template_title ); ?></option>
						<?php endforeach; ?>
					</select>
					<p><em><?php echo esc_html__( 'It will be applied on singular layout of this term.', 'ava-woo-builder' ); ?></em></p>
				</td>
			</tr>
		<?php }

		/**
		 * Save extra taxonomy fields callback function
		 *
		 * @param $term_id
		 * @return void
		 */
		public function save_taxonomy_custom_meta($term_id) {
			$ava_woo_builder_template = filter_input(INPUT_POST, 'ava_woo_builder_template');

			update_term_meta($term_id, 'ava_woo_builder_template', $ava_woo_builder_template);
		}

		/**
		 * @param $args
		 *
		 * @return string
		 */
		public function set_previous_product_link_class( $args ) {

			$args .= 'class="ava-woo-builder-navigation-prev"';

			return $args;
		}

		/**
		 * @param $args
		 *
		 * @return string
		 */
		public function set_next_product_link_class( $args ) {

			$args .= 'class="ava-woo-builder-navigation-next"';

			return $args;
		}


		/**
		 * Add custom columns for archive product template
		 *
		 * @param $content
		 *
		 * @return string
		 */
		public function set_archive_template_custom_columns( $content ) {

			if( 'shortcode' === $this->get_current_loop() ){
				return $content;
			}

			$settings                      = get_post_meta( $this->get_custom_archive_template(), '_elementor_page_settings', true );
			$settings_category             = get_post_meta( $this->get_custom_archive_category_template(), '_elementor_page_settings', true );
			$use_custom_columns            = isset( $settings['use_custom_template_columns'] ) ? $settings['use_custom_template_columns'] : '';
			$use_custom_categories_columns = isset( $settings_category['use_custom_template_category_columns'] ) ? $settings_category['use_custom_template_category_columns'] : '';
			$classes                       = array( 'products' );
			$classes_cat                   = array( 'products' );
			$content_categories = '';

			if ( ! $settings && ! $settings_category ){
				return $content;
			}

			if ( 'yes' === $use_custom_categories_columns ) {
				$columns_cat        = isset( $settings_category['template_category_columns_count'] ) ? $settings_category['template_category_columns_count'] : 4;
				$columns_cat_tablet = isset( $settings_category['template_category_columns_count_tablet'] ) ? $settings_category['template_category_columns_count_tablet'] : 2;
				$columns_cat_mobile = isset( $settings_category['template_category_columns_count_mobile'] ) ? $settings_category['template_category_columns_count_mobile'] : 1;

				array_push( $classes_cat, 'ava-woo-builder-cat-columns-' . $columns_cat );
				array_push( $classes_cat, 'ava-woo-builder-cat-columns-tab-' . $columns_cat_tablet );
				array_push( $classes_cat, 'ava-woo-builder-cat-columns-mob-' . $columns_cat_mobile );
			}

			if ( 'yes' === $use_custom_columns ) {
				$columns        = isset( $settings['template_columns_count'] ) ? $settings['template_columns_count'] : 4;
				$columns_tablet = isset( $settings['template_columns_count_tablet'] ) ? $settings['template_columns_count_tablet'] : 2;
				$columns_mobile = isset( $settings['template_columns_count_mobile'] ) ? $settings['template_columns_count_mobile'] : 1;

				array_push( $classes, 'ava-woo-builder-columns-' . $columns );
				array_push( $classes, 'ava-woo-builder-columns-tab-' . $columns_tablet );
				array_push( $classes, 'ava-woo-builder-columns-mob-' . $columns_mobile );
			}
			remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );

			$product_subcategories = woocommerce_maybe_show_product_subcategories();

			if ( ! empty( $product_subcategories ) ) {
				$classes_cat = implode( ' ', $classes_cat );

				if ( 'yes' === $use_custom_categories_columns ) {
					$before = sprintf(
						'<ul class="ava-woo-builder-categories--columns %s">',
						$classes_cat
					);
					$after  = '</ul>';
				} else {
					$before = '<ul class="products columns-' . esc_attr( wc_get_loop_prop( 'columns' ) ) . '">';
					$after  = '</ul>';
				}

				$content_categories = $before . woocommerce_maybe_show_product_subcategories() . $after;
			}

			if ( 'yes' === $use_custom_columns ) {
				$classes = implode( ' ', $classes );
				$content = sprintf(
					'<ul class="ava-woo-builder-products--columns %s">',
					$classes
				);
			} else {
				$classes = 'products columns-' . esc_attr( wc_get_loop_prop( 'columns' ) ) . '';
				$display_type = woocommerce_get_loop_display_mode();
				// If displaying just categories, append to the loop.
				if ( 'subcategories' === $display_type ) {
					$classes .= ' ava-woo-builder-hide';
				}
				$content = sprintf( '<ul class="%s">', $classes );
			}
			$content = $content_categories . $content;

			return $content;
		}

		/**
		 * Set count of products displayed in related products section
		 *
		 * @param $args
		 *
		 * @return array
		 */
		public function set_related_products_output_count( $args ) {

			$posts_per_page = ava_woo_builder_shop_settings()->get( 'related_products_per_page' );
			$posts_per_page = isset( $posts_per_page ) ? $posts_per_page : 4;

			$defaults = array(
				'posts_per_page' => $posts_per_page,
			);

			$args = wp_parse_args( $defaults, $args );

			return $args;

		}

		/**
		 * Set count of products displayed in up sells products section
		 *
		 * @param $args
		 *
		 * @return array
		 */
		public function set_up_sells_products_output_count( $args ) {

			$posts_per_page = ava_woo_builder_shop_settings()->get( 'up_sells_products_per_page' );
			$posts_per_page = isset( $posts_per_page ) ? $posts_per_page : 4;

			$defaults = array(
				'posts_per_page' => $posts_per_page,
			);

			$args = wp_parse_args( $defaults, $args );

			return $args;

		}

		/**
		 * Set count of products displayed in cross sells products section
		 *
		 * @return int
		 */
		public function set_cross_sells_products_output_count() {

			$posts_per_page = ava_woo_builder_shop_settings()->get( 'cross_sells_products_per_page' );
			$total          = isset( $posts_per_page ) ? $posts_per_page : 4;

			return $total;

		}

		/**
		 * Returns list of single product templates
		 *
		 * @return [type] [description]
		 */
		public function get_single_templates() {
			return ava_woo_builder_post_type()->get_templates_list_for_options( 'single' );
		}

		/**
		 * Returns list of shop templates
		 *
		 * @return [type] [description]
		 */
		public function get_shop_templates() {
			return ava_woo_builder_post_type()->get_templates_list_for_options( 'shop' );
		}

		/**
		 * Set blank template for editor
		 */
		public function set_product_template( $template ) {

			if ( ! is_singular( 'product' ) ) {
				return $template;
			}

			$template_type = get_post_meta( get_the_ID(), '_template_type', true );

			if ( isset( $_GET['elementor-preview'] ) ) {

				$template = ava_woo_builder()->plugin_path( 'templates/blank.php' );

				do_action( 'ava-woo-builder/template-include/found' );

			}

			if ( 'canvas' === $template_type ) {

				$custom_template = $this->get_custom_single_template();

				if ( $custom_template ) {

					$this->current_template = $custom_template;
					$template               = ava_woo_builder()->plugin_path( 'templates/blank-product.php' );

					do_action( 'ava-woo-builder/template-include/found' );

				}

			}

			return $template;

		}

		/**
		 * Force to use default WooCommerce templates
		 *
		 * @param  [type] $found_template [description]
		 * @param  [type] $template_name  [description]
		 *
		 * @return [type]                 [description]
		 */
		public function force_wc_templates( $found_template, $template_name ) {

			if ( false !== strpos( $template_name, 'woocommerce/single-product/' ) ) {
				$default_path   = WC()->plugin_path() . '/templates/';
				$found_template = $default_path . $template_name;
			}

			return $found_template;

		}

		/**
		 * Rewrite default shop page template
		 *
		 * @param $template
		 * @return array
		 */
		function set_shop_page_template( $template ) {

			if ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) || is_product_taxonomy() ) {

				$custom_template = $this->get_custom_shop_template();

				if ( $custom_template && 'default' !== $custom_template ) {
					$this->current_template_shop = $custom_template;
					$template                    = ava_woo_builder()->get_template( 'woocommerce/archive-product.php' );
				}

			}

			return $template;

		}

		/**
		 * Rewrite default taxonomy page template
		 *
		 * @param $template
		 * @return array
		 */
		function set_taxonomy_page_template( $template ) {

			$taxonomy_custom_template = get_term_meta( get_queried_object_id(), 'ava_woo_builder_template', true );
			$custom_template = $this->get_custom_taxonomy_template();

			if ( is_product_taxonomy() && ! empty( $taxonomy_custom_template ) ) {
				$this->current_template_taxonomy = $custom_template;
				$template                        = ava_woo_builder()->get_template( 'woocommerce/archive-product.php' );
			}

			return $template;

		}

		/**
		 * Rewrite default single product template
		 *
		 * @param  [type] $template [description]
		 * @param  [type] $slug     [description]
		 * @param  [type] $name     [description]
		 *
		 * @return array
		 */
		public function rewrite_templates( $template, $slug, $name ) {

			if ( 'content' === $slug && 'single-product' === $name ) {

				$custom_template = $this->get_custom_single_template();

				if ( $custom_template ) {
					$this->current_template = $custom_template;
					$template               = ava_woo_builder()->get_template( 'woocommerce/content-single-product.php' );
				}

			}

			if ( 'content' === $slug && 'product' === $name ) {

				$custom_template = $this->get_custom_archive_template();

				if ( $custom_template ) {
					$this->current_template_archive = $custom_template;
					$template                       = ava_woo_builder()->get_template( 'woocommerce/content-product.php' );
				}

			}

			return $template;

		}

		/**
		 * Rewrite product category template
		 *
		 * @param $located
		 * @param $template_name
		 * @param $args
		 * @param $template_path
		 * @param $default_path
		 *
		 * @return mixed
		 */
		function rewrite_category_templates( $located, $template_name, $args, $template_path, $default_path ) {

			if ( 'content-product_cat.php' === $template_name ) {

				$custom_template = $this->get_custom_archive_category_template();

				if ( $custom_template && 'default' !== $custom_template ) {
					$this->current_category_args             = $args;
					$this->current_template_archive_category = $custom_template;
					$located                                 = ava_woo_builder()->get_template( 'woocommerce/content-product_cat.php' );
				}

			}

			return $located;
		}

		/**
		 * Return args for current category
		 *
		 * @param $args
		 *
		 * @return array
		 */
		public function get_archive_category_args( $args ) {

			$new_args = $this->current_category_args;

			if ( ! empty( $new_args ) ) {
				$args = wp_parse_args( $new_args, $args );
			}

			return $args;

		}

		public function get_current_args() {
			return $this->current_category_args;
		}

		/**
		 * Returns processed single template
		 *
		 * @return mixed
		 */
		public function current_single_template() {
			return $this->current_template;
		}

		/**
		 * Returns processed single template
		 *
		 * @return mixed
		 */
		public function get_current_archive_template() {
			return $this->current_template_archive;
		}

		/**
		 * Returns processed archive category template
		 *
		 * @return mixed
		 */
		public function get_current_archive_category_template() {
			return $this->current_template_archive_category;
		}

		/**
		 * Returns processed single template
		 *
		 * @return mixed
		 */
		public function get_current_shop_template() {
			return $this->current_template_shop;
		}

		/**
		 * Get current loop type
		 *
		 * @return null|string
		 */
		public function get_current_loop() {

			if ( null !== $this->current_loop ) {
				return $this->current_loop;
			}

			$loop = 'archive';

			if ( wc_get_loop_prop( 'is_shortcode' ) ) {
				$loop = 'shortcode';
			}

			if ( wc_get_loop_prop( 'is_search' ) ) {
				$loop = 'search';
			}

			if ( 'related' === wc_get_loop_prop( 'name' ) || 'up-sells' === wc_get_loop_prop( 'name' ) ) {
				$loop = 'related';
			}

			if ( 'cross-sells' === wc_get_loop_prop( 'name' ) ) {
				$loop = 'cross_sells';
			}

			return $this->current_loop = $loop;

		}

		/**
		 * Reset current loop type
		 *
		 * @return null
		 */
		public function reset_current_loop() {
			$this->current_loop = null;

			return $this->current_loop;
		}


		/**
		 * Returns processed archive template
		 *
		 * @return mixed
		 */
		public function get_custom_shop_template() {

			if ( null !== $this->current_template_shop ) {
				return $this->current_template_shop;
			}

			$enabled = ava_woo_builder_shop_settings()->get( 'custom_shop_page' );

			$custom_template = false;

			if ( 'yes' === $enabled ) {
				if ( 'default' !== ava_woo_builder_shop_settings()->get( 'shop_template' ) ) {
					$custom_template = ava_woo_builder_shop_settings()->get( 'shop_template' );
				}
			}

			$this->current_template_shop = apply_filters(
				'ava-woo-builder/custom-shop-template',
				$custom_template
			);

			return $this->current_template_shop;

		}

		/**
		 * Returns processed archive template
		 *
		 * @return mixed
		 */
		public function get_custom_archive_template() {

			if ( null !== $this->current_template_archive ) {
				return $this->current_template_archive;
			}

			$enabled = ava_woo_builder_shop_settings()->get( 'custom_archive_page' );

			$is_edit_mode = Elementor\Plugin::instance()->editor->is_edit_mode();

			if ( $is_edit_mode && is_singular('product') ){
				add_filter( 'ava-woo-builder/get-template-content/render-method' , array( $this, 'get_macros_render_method' ));
			}

			$custom_template = false;
			$loop            = $this->get_current_loop();

			if ( 'yes' === $enabled ) {
				if ( 'default' !== ava_woo_builder_shop_settings()->get( $loop . '_template' ) ) {
					$custom_template = ava_woo_builder_shop_settings()->get( $loop . '_template' );
				}
			}

			$this->current_template_archive = apply_filters(
				'ava-woo-builder/custom-archive-template',
				$custom_template
			);

			return $this->current_template_archive;

		}

		public function get_macros_render_method(){
			return 'macros';
		}

		/**
		 * Returns processed archive template
		 *
		 * @return mixed
		 */
		public function get_custom_archive_category_template() {

			if ( null !== $this->current_template_archive_category ) {
				return $this->current_template_archive_category;
			}

			$enabled = ava_woo_builder_shop_settings()->get( 'custom_archive_category_page' );

			$custom_template = false;

			if ( 'yes' === $enabled ) {
				if ( 'default' !== ava_woo_builder_shop_settings()->get( 'category_template' ) ) {
					$custom_template = ava_woo_builder_shop_settings()->get( 'category_template' );
				}
			}

			$this->current_template_archive_category = apply_filters(
				'ava-woo-builder/custom-archive-category-template',
				$custom_template
			);

			return $this->current_template_archive_category;

		}

		/**
		 * Get custom single template
		 *
		 * @return string
		 */
		public function get_custom_single_template() {

			$enabled = ava_woo_builder_shop_settings()->get( 'custom_single_page' );

			if ( 'yes' !== $enabled ) {
				return $this->current_template = false;
			}

			if ( null !== $this->current_template ) {
				return $this->current_template;
			}

			$product_template = get_post_meta( get_the_ID(), '_ava_woo_template', true );

			if ( ! empty( $product_template ) ) {
				return apply_filters( 'ava-woo-builder/custom-single-template', $product_template );
			}

			$custom_template = false;

			if ( 'default' !== ava_woo_builder_shop_settings()->get( 'single_template' ) ) {
				$custom_template = ava_woo_builder_shop_settings()->get( 'single_template' );
			}

			$this->current_template = apply_filters(
				'ava-woo-builder/custom-single-template',
				$custom_template
			);

			return $this->current_template;

		}

		/**
		 * Get custom taxonomy template
		 *
		 * @return string
		 */
		public function get_custom_taxonomy_template() {

			if ( null !== $this->current_template_taxonomy ) {
				return $this->current_template_taxonomy;
			}

			$enabled_shop_template     = ava_woo_builder_shop_settings()->get( 'custom_shop_page' );
			$enabled_taxonomy_template = ava_woo_builder_shop_settings()->get( 'custom_taxonomy_template' );

			$custom_template = false;

			if ( 'yes' === $enabled_shop_template && 'default' !== ava_woo_builder_shop_settings()->get( 'shop_template' ) ) {
				$custom_template = ava_woo_builder_shop_settings()->get( 'shop_template' );
			}

			if ( 'yes' === $enabled_taxonomy_template ) {
				$custom_template = get_term_meta( get_queried_object_id(), 'ava_woo_builder_template', true );
			}

			if ( ! empty( $custom_template ) ) {
				$this->current_template_taxonomy =  apply_filters(
					'ava-woo-builder/custom-taxonomy-template',
					$custom_template
				);
			}

			return $this->current_template_taxonomy;

		}

		/**
		 * Force preview template
		 *
		 * @param  [type] $custom_template [description]
		 *
		 * @return [type]                  [description]
		 */
		public function force_preview_template( $custom_template ) {

			if ( ! empty( $_GET['ava_woo_template'] ) && isset( $_GET['preview_nonce'] ) ) {
				return absint( $_GET['ava_woo_template'] );
			} else {
				return $custom_template;
			}

		}

		/**
		 * Force preview document type
		 *
		 * @param  [type] $custom_template [description]
		 *
		 * @return [type]                  [description]
		 */
		public function force_preview_doc_type( $doc_type ) {

			if ( ! empty( $_GET['ava_woo_template'] ) && isset( $_GET['preview_nonce'] ) ) {
				return get_post_meta( absint( $_GET['ava_woo_template'] ), '_elementor_template_type', true );
			} else {
				return $doc_type;
			}

		}

		/**
		 * Force product document type
		 *
		 * @param $doc_type
		 *
		 * @return string
		 */
		public function force_product_doc_type( $doc_type ) {

			if ( ! $doc_type && null !== get_post_meta( get_the_ID(), '_ava_woo_template', true ) ) {

				if ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) || is_product_taxonomy() ) {
					return 'ava-woo-builder-shop';
				}

				if ( 'product' === get_post_type() ) {
					return 'ava-woo-builder';
				}

			} else {

				return $doc_type;

			}

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
 * Returns instance of Ava_Woo_Builder_Integration_Woocommerce
 *
 * @return object
 */
function ava_woo_builder_integration_woocommerce() {
	return Ava_Woo_Builder_Integration_Woocommerce::get_instance();
}
