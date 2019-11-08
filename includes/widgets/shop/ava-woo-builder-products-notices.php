<?php
/**
 * Class: Ava_Woo_Builder_Products_Notices
 * Name: Products Notices
 * Slug: ava-woo-builder-products-notices
 */

namespace Elementor;

use Elementor\Widget_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Ava_Woo_Builder_Products_Notices extends Ava_Woo_Builder_Base {

	public function get_name() {
		return 'ava-woo-builder-products-notices';
	}

	public function get_title() {
		return esc_html__( 'Products Notices', 'ava-woo-builder' );
	}

	public function get_icon() {
		return 'avawoobuilder-icon-30';
	}

	public function get_script_depends() {
		return array();
	}

	public function get_ava_help_url() {
		return 'https://blockcroco.com/knowledge-base/articles/avawoobuilder-how-to-create-and-set-a-shop-page-template/';
	}

	public function get_categories() {
		return array( 'ava-woo-builder' );
	}

	public function show_in_panel() {
		return ava_woo_builder()->documents->is_document_type( 'shop' );
	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();

		if ( !ava_woo_builder_integration()->in_elementor() ) {
			wc_print_notices();
		}

		$this->__close_wrap();

	}
}
