<?php
/**
 * Class: Ava_Woo_Builder_Single_Content
 * Name: Single Content
 * Slug: ava-single-content
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

class Ava_Woo_Builder_Single_Content extends Ava_Woo_Builder_Base {

	public function get_name() {
		return 'ava-single-content';
	}

	public function get_title() {
		return esc_html__( 'Single Content', 'ava-woo-builder' );
	}

	public function get_icon() {
		return 'avawoobuilder-icon-3';
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

		$css_scheme = apply_filters(
			'ava-woo-builder/ava-single-content/css-scheme',
			array(
				'content_wrapper'            => '.ava-woo-builder .ava-single-content'
			)
		);

		$this->start_controls_section(
			'section_single_content_style',
			array(
				'label' => __( 'General', 'ava-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'single_content_text_color',
			array(
				'label'     => __( 'Text Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['content_wrapper'] => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'   => 'typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['content_wrapper'],
			)
		);

		$this->add_responsive_control(
			'single_content_align',
			array(
				'label'     => __( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'    => array(
						'title' => __( 'Left', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-left',
					),
					'center'  => array(
						'title' => __( 'Center', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'   => array(
						'title' => __( 'Right', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-right',
					),
					'justify' => array(
						'title' => __( 'Justified', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-justify',
					),
				),
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['content_wrapper'] => 'text-align: {{VALUE}};',
				],
			)
		);

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		if ( true === $this->__set_editor_product() ) {
			$this->__open_wrap();
			include $this->__get_global_template( 'index' );
			$this->__close_wrap();
			$this->__reset_editor_product();
		}

	}
}
