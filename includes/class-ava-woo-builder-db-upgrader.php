<?php
/**
 * DB upgrder class
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Ava_Woo_Builder_DB_Upgrader' ) ) {

	/**
	 * Define Ava_Woo_Builder_DB_Upgrader class
	 */
	class Ava_Woo_Builder_DB_Upgrader {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * Setting key
		 *
		 * @var string
		 */
		public $key = null;
		public $shop_key = null;

		/**
		 * Constructor for the class
		 */
		public function init() {
			$this->key      = ava_woo_builder_settings()->key;
			$this->shop_key = ava_woo_builder_shop_settings()->options_key;

			/**
			 * Plugin initialized on new Ava_Woo_Builder_DB_Upgrader call.
			 * Please ensure, that it called only on admin context
			 */
			$this->init_upgrader();
		}

		/**
		 * Initialize upgrader module
		 *
		 * @return void
		 */
		public function init_upgrader() {
			new CX_Db_Updater( array(
					'slug'      => 'ava-woo-builder',
					'version'   => '1.5.0',
					'callbacks' => array(
						'1.2.0' => array(
							array( $this, 'update_db_1_2_0' ),
						),
						'1.3.0' => array(
							array( $this, 'update_db_1_3_0' ),
						),
						'1.5.0' => array(
							array( $this, 'update_db_1_5_0' ),
						),
					),
				)
			);
		}

		/**
		 * Update db updater 1.2.0
		 *
		 * @return void
		 */
		public function update_db_1_2_0() {
			$current_version_settings      = get_option( $this->key, false );
			$current_version_settings_shop = get_option( $this->shop_key, false );

			if ( $current_version_settings_shop ) {
				if ( ! isset( $current_version_settings_shop['custom_archive_page'] ) ) {
					$current_version_settings_shop['custom_archive_page'] = 'no';
				}
				if ( ! isset( $current_version_settings_shop['archive_template'] ) ) {
					$current_version_settings_shop['archive_template'] = 'default';
				}
				if ( ! isset( $current_version_settings_shop['shortcode_template'] ) ) {
					$current_version_settings_shop['shortcode_template'] = 'default';
				}
				if ( ! isset( $current_version_settings_shop['search_template'] ) ) {
					$current_version_settings_shop['search_template'] = 'default';
				}
				if ( ! isset( $current_version_settings_shop['cross_sells_template'] ) ) {
					$current_version_settings_shop['cross_sells_template'] = 'default';
				}
				if ( ! isset( $current_version_settings_shop['related_template'] ) ) {
					$current_version_settings_shop['related_template'] = 'default';
				}
				if ( ! isset( $current_version_settings_shop['related_products_per_page'] ) ) {
					$current_version_settings_shop['related_products_per_page'] = 3;
				}
				if ( ! isset( $current_version_settings_shop['up_sells_products_per_page'] ) ) {
					$current_version_settings_shop['up_sells_products_per_page'] = 3;
				}
				if ( ! isset( $current_version_settings_shop['cross_sells_products_per_page'] ) ) {
					$current_version_settings_shop['cross_sells_products_per_page'] = 3;
				}
				update_option( $this->shop_key, $current_version_settings_shop );
			}

			if ( $current_version_settings ) {
				if ( isset( $current_version_settings['archive_product_available_widgets'] ) ) {
					if ( ! isset( $current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-add-to-cart'] ) ) {
						$current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-add-to-cart'] = 'true';
					}
					if ( ! isset( $current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-cats'] ) ) {
						$current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-cats'] = 'true';
					}
					if ( ! isset( $current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-product-excerpt'] ) ) {
						$current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-product-excerpt'] = 'true';
					}
					if ( ! isset( $current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-product-price'] ) ) {
						$current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-product-price'] = 'true';
					}
					if ( ! isset( $current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-product-rating'] ) ) {
						$current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-product-rating'] = 'true';
					}
					if ( ! isset( $current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-product-thumbnail'] ) ) {
						$current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-product-thumbnail'] = 'true';
					}
					if ( ! isset( $current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-product-title'] ) ) {
						$current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-product-title'] = 'true';
					}
					if ( ! isset( $current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-sale-badge'] ) ) {
						$current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-sale-badge'] = 'true';
					}
					if ( ! isset( $current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-stock-status'] ) ) {
						$current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-stock-status'] = 'true';
					}
					if ( ! isset( $current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-tags'] ) ) {
						$current_version_settings['archive_product_available_widgets']['ava-woo-builder-archive-tags'] = 'true';
					}
					update_option( $this->key, $current_version_settings );
				}
			}
		}

		/**
		 * Update db updater 1.3.0
		 *
		 * @return void
		 */
		public function update_db_1_3_0() {

			$current_version_settings      = get_option( $this->key, false );
			$current_version_settings_shop = get_option( $this->shop_key, false );

			if ( $current_version_settings_shop ) {
				if ( ! isset( $current_version_settings_shop['custom_shop_page'] ) ) {
					$current_version_settings_shop['custom_shop_page'] = 'no';
				}
				if ( ! isset( $current_version_settings_shop['shop_template'] ) ) {
					$current_version_settings_shop['shop_template'] = 'default';
				}
				if ( ! isset( $current_version_settings_shop['custom_archive_category_page'] ) ) {
					$current_version_settings_shop['custom_archive_category_page'] = 'no';
				}
				if ( ! isset( $current_version_settings_shop['category_template'] ) ) {
					$current_version_settings_shop['category_template'] = 'default';
				}
				update_option( $this->shop_key, $current_version_settings_shop );
			}

			if ( $current_version_settings ) {
				if ( isset( $current_version_settings['archive_category_available_widgets'] ) ) {
					if ( ! isset( $current_version_settings['archive_category_available_widgets']['ava-woo-builder-archive-category-count'] ) ) {
						$current_version_settings['archive_category_available_widgets']['ava-woo-builder-archive-category-count'] = 'true';
					}
					if ( ! isset( $current_version_settings['archive_category_available_widgets']['ava-woo-builder-archive-category-description'] ) ) {
						$current_version_settings['archive_category_available_widgets']['ava-woo-builder-archive-category-description'] = 'true';
					}
					if ( ! isset( $current_version_settings['archive_category_available_widgets']['ava-woo-builder-archive-category-thumbnail'] ) ) {
						$current_version_settings['archive_category_available_widgets']['ava-woo-builder-archive-category-thumbnail'] = 'true';
					}
					if ( ! isset( $current_version_settings['archive_category_available_widgets']['ava-woo-builder-archive-category-title'] ) ) {
						$current_version_settings['archive_category_available_widgets']['ava-woo-builder-archive-category-title'] = 'true';
					}
				}
				if ( isset( $current_version_settings['shop_product_available_widgets'] ) ) {
					if ( ! isset( $current_version_settings['shop_product_available_widgets']['ava-woo-builder-products-description'] ) ) {
						$current_version_settings['shop_product_available_widgets']['ava-woo-builder-products-description'] = 'true';
					}
					if ( ! isset( $current_version_settings['shop_product_available_widgets']['ava-woo-builder-products-loop'] ) ) {
						$current_version_settings['shop_product_available_widgets']['ava-woo-builder-products-loop'] = 'true';
					}
					if ( ! isset( $current_version_settings['shop_product_available_widgets']['ava-woo-builder-products-navigation'] ) ) {
						$current_version_settings['shop_product_available_widgets']['ava-woo-builder-products-navigation'] = 'true';
					}
					if ( ! isset( $current_version_settings['shop_product_available_widgets']['ava-woo-builder-products-notices'] ) ) {
						$current_version_settings['shop_product_available_widgets']['ava-woo-builder-products-notices'] = 'true';
					}
					if ( ! isset( $current_version_settings['shop_product_available_widgets']['ava-woo-builder-products-ordering'] ) ) {
						$current_version_settings['shop_product_available_widgets']['ava-woo-builder-products-ordering'] = 'true';
					}
					if ( ! isset( $current_version_settings['shop_product_available_widgets']['ava-woo-builder-products-page-title'] ) ) {
						$current_version_settings['shop_product_available_widgets']['ava-woo-builder-products-page-title'] = 'true';
					}
					if ( ! isset( $current_version_settings['shop_product_available_widgets']['ava-woo-builder-products-pagination'] ) ) {
						$current_version_settings['shop_product_available_widgets']['ava-woo-builder-products-pagination'] = 'true';
					}
					if ( ! isset( $current_version_settings['shop_product_available_widgets']['ava-woo-builder-products-result-count'] ) ) {
						$current_version_settings['shop_product_available_widgets']['ava-woo-builder-products-result-count'] = 'true';
					}
					update_option( $this->key, $current_version_settings );
				}

			}
		}

		/**
		 * Update db updater 1.5.0
		 *
		 * @return void
		 */
		public function update_db_1_5_0() {

			$current_version_settings_shop = get_option( $this->shop_key, false );

			if ( $current_version_settings_shop ) {
				if ( ! isset( $current_version_settings_shop['custom_taxonomy_template'] ) ) {
					$current_version_settings_shop['custom_taxonomy_template'] = 'no';
				}
				update_option( $this->shop_key, $current_version_settings_shop );
			}

		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
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
 * Returns instance of Ava_Woo_Builder_Template_Functions
 *
 * @return object
 */
function ava_woo_builder_db_upgrader() {
	return Ava_Woo_Builder_DB_Upgrader::get_instance();
}