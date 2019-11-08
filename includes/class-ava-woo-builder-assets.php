<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Ava_Woo_Builder_Assets' ) ) {

	/**
	 * Define Ava_Woo_Builder_Assets class
	 */
	class Ava_Woo_Builder_Assets {

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

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

			add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'elementor/frontend/after_enqueue_scripts', array(
				'WC_Frontend_Scripts',
				'localize_printed_scripts'
			), 5 );

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );

		}

		public function enqueue_admin_assets(){
			$screen = get_current_screen();

			if ( 'woocommerce_page_wc-settings' === $screen->base ){
				wp_enqueue_style(
					'ava-woo-builder-admin',
					ava_woo_builder()->plugin_url( 'assets/css/admin.css' ),
					false,
					ava_woo_builder()->get_version()
				);
			}

		}

		/**
		 * Enqueue public-facing stylesheets.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function enqueue_styles() {
			$font_path = WC()->plugin_url() . '/assets/fonts/';
			$inline_font = '@font-face {
			font-family: "WooCommerce";
			src: url("' . $font_path . 'WooCommerce.eot");
			src: url("' . $font_path . 'WooCommerce.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'WooCommerce.woff") format("woff"),
				url("' . $font_path . 'WooCommerce.ttf") format("truetype"),
				url("' . $font_path . 'WooCommerce.svg#WooCommerce") format("svg");
			font-weight: normal;
			font-style: normal;
			}';

			wp_enqueue_style(
				'ava-woo-builder',
				ava_woo_builder()->plugin_url( 'assets/css/ava-woo-builder.css' ),
				false,
				ava_woo_builder()->get_version()
			);

			wp_enqueue_style(
				'ava-woo-builder-frontend',
				ava_woo_builder()->plugin_url( 'assets/css/lib/avawoobuilder-frontend-font/css/avawoobuilder-frontend-font.css' ),
				false,
				ava_woo_builder()->get_version()
			);

			wp_add_inline_style(
				'ava-woo-builder',
				$inline_font
			);

		}

		/**
		 * Enqueue plugin scripts only with elementor scripts
		 *
		 * @return void
		 */
		public function enqueue_scripts() {

			wp_enqueue_script(
				'ava-woo-builder',
				ava_woo_builder()->plugin_url( 'assets/js/ava-woo-builder' . $this->suffix() . '.js' ),
				array( 'jquery', 'elementor-frontend' ),
				ava_woo_builder()->get_version(),
				true
			);

			wp_localize_script(
				'ava-woo-builder',
				'avaWooBuilderData',
				apply_filters( 'ava-woo-builder/frontend/localize-data', array() )
			);

		}

		/**
		 * [suffix description]
		 * @return [type] [description]
		 */
		public function suffix() {
			return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
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
 * Returns instance of Ava_Woo_Builder_Assets
 *
 * @return object
 */
function ava_woo_builder_assets() {
	return Ava_Woo_Builder_Assets::get_instance();
}
