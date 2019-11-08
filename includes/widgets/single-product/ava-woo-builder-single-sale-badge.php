<?php
/**
 * Class: Ava_Woo_Builder_Sale_Badge
 * Name: Single Sale Badge
 * Slug: ava-single-sale-badge
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

class Ava_Woo_Builder_Single_Sale_Badge extends Ava_Woo_Builder_Base {

	public function get_name() {
		return 'ava-single-sale-badge';
	}

	public function get_title() {
		return esc_html__( 'Single Sale Badge', 'ava-woo-builder' );
	}

	public function get_icon() {
		return 'avawoobuilder-icon-11';
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
			'ava-woo-builder/ava-single-sale-badge/css-scheme',
			array(
				'badge' => '.ava-woo-builder .onsale'
			)
		);

		$this->start_controls_section(
			'section_badge_content',
			array(
				'label'      => esc_html__( 'Content', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_CONTENT,
				'show_label' => false,
			)
		);

		$this->add_control(
			'single_badge_text',
			array(
				'type'      => 'text',
				'label'     => esc_html__( 'Sale Badge Text', 'ava-woo-builder' ),
				'default'   => 'Sale!',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_single_badge_style',
			array(
				'label'      => esc_html__( 'General', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'single_badge_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'single_badge_background',
			array(
				'label'     => esc_html__( 'Background', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'single_badge_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['badge'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'single_badge_border',
				'label'       => esc_html__( 'Border', 'ava-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['badge'],
			)
		);

		$this->add_responsive_control(
			'single_badge_border_radius',
			array(
				'label'      => __( 'Border Radius', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'single_badge_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['badge'],
			)
		);

		$this->add_responsive_control(
			'single_badge_content_padding',
			array(
				'label'      => __( 'Padding', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'single_badge_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' => 'text-align: {{VALUE}};',
				),
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
