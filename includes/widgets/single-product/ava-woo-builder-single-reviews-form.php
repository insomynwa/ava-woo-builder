<?php
/**
 * Class: Ava_Woo_Builder_Single_Reviews_Form
 * Name: Single Reviews Form
 * Slug: ava-single-reviews-form
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Ava_Woo_Builder_Single_Reviews_Form extends Ava_Woo_Builder_Base {

	public function get_name() {
		return 'ava-single-reviews-form';
	}

	public function get_title() {
		return esc_html__( 'Single Reviews Form', 'ava-woo-builder' );
	}

	public function get_icon() {
		return 'avawoobuilder-icon-10';
	}

	public function get_script_depends() {
		return array();
	}

	public function get_ava_help_url() {
		return 'https://blockcroco.com/knowledge-base/articles/avawoobuilder-how-to-create-and-set-a-single-product-page-template/';
	}

	public function get_categories() {
		return array( 'ava-woo-builder' );
	}

	public function show_in_panel() {
		return ava_woo_builder()->documents->is_document_type( 'single' );
	}

	protected function _register_controls() {
	}

	protected function render() {

		$this->__context = 'render';

		if ( true === $this->__set_editor_product() ) {
			$this->__open_wrap();

			$elementor    = Plugin::instance();
			$is_edit_mode = $elementor->editor->is_edit_mode();

			if ( $is_edit_mode ) {
				add_filter( 'comments_template', array( 'WC_Template_Loader', 'comments_template_loader' ) );
			}

			include $this->__get_global_template( 'index' );
			$this->__close_wrap();
			$this->__reset_editor_product();
		}

	}

}
