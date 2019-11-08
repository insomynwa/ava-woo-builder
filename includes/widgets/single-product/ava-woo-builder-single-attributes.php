<?php
/**
 * Class: Ava_Woo_Builder_Single_Attributes
 * Name: Single Attributes
 * Slug: ava-single-attributes
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

class Ava_Woo_Builder_Single_Attributes extends Ava_Woo_Builder_Base {

	public function get_name() {
		return 'ava-single-attributes';
	}

	public function get_title() {
		return esc_html__( 'Single Attributes', 'ava-woo-builder' );
	}

	public function get_icon() {
		return 'avawoobuilder-icon-2';
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
			'ava-woo-builder/ava-single-attributes/css-scheme',
			array(
				'title'            => '.ava-woo-builder .ava-single-attrs__title',
				'attributes_table' => '.ava-woo-builder .shop_attributes',
				'attributes_title' => '.ava-woo-builder .shop_attributes tr > th',
				'attributes_value' => '.ava-woo-builder .shop_attributes tr > td',
			)
		);

		$this->start_controls_section(
			'section_attrs_content',
			array(
				'label' => esc_html__( 'Content', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'block_title',
			array(
				'label' => esc_html__( 'Title Text', 'ava-woo-builder' ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'block_title_tag',
			array(
				'label'   => esc_html__( 'Title Tag', 'ava-woo-builder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => array(
					'h1'  => esc_html__( 'H1', 'ava-woo-builder' ),
					'h2'  => esc_html__( 'H2', 'ava-woo-builder' ),
					'h3'  => esc_html__( 'H3', 'ava-woo-builder' ),
					'h4'  => esc_html__( 'H4', 'ava-woo-builder' ),
					'h5'  => esc_html__( 'H5', 'ava-woo-builder' ),
					'h6'  => esc_html__( 'H6', 'ava-woo-builder' ),
					'div' => esc_html__( 'DIV', 'ava-woo-builder' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_attrs_title_style',
			array(
				'label'      => esc_html__( 'Title', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'attrs_title_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'attrs_title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['title'],
			)
		);

		$this->add_responsive_control(
			'attrs_title_margin',
			array(
				'label'      => __( 'Margin', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'attrs_title_padding',
			array(
				'label'      => __( 'Padding', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'attrs_title_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_attrs_table_style',
			array(
				'label'      => esc_html__( 'Attributes table', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'section_attrs_table_width',
			array(
				'label'      => esc_html__( 'Table Width', 'ava-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'%'  => array(
						'min' => 10,
						'max' => 100,
					),
					'px' => array(
						'min' => 100,
						'max' => 500,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['attributes_table'] => 'max-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'heading_attrs_table_title',
			array(
				'label'     => esc_html__( 'Title', 'ava-woo-builder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'attrs_table_title_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['attributes_title'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'attrs_table_title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['attributes_title'],
			)
		);

		$this->add_control(
			'attrs_table_title_background',
			array(
				'label'     => __( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['attributes_title'] => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'attrs_table_title_border',
				'label'          => esc_html__( 'Border', 'ava-woo-builder' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['attributes_title'],
				'fields_options' => array(
					'border' => array(
						'default' => 'solid',
					),
					'width'  => array(
						'default' => array(
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						),
					),
					'color'  => array(),
				),
			)
		);

		$this->add_responsive_control(
			'attrs_table_title_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['attributes_title'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'attrs_table_title_padding',
			array(
				'label'      => __( 'Padding', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['attributes_title'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'attrs_table_title_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['attributes_title'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'heading_attrs_table_value',
			array(
				'label'     => esc_html__( 'Value', 'ava-woo-builder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'attrs_table_value_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['attributes_value'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'attrs_table_value_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['attributes_value'],
			)
		);

		$this->add_control(
			'attrs_table_value_background',
			array(
				'label'     => __( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['attributes_value'] => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'attrs_table_value_border',
				'label'          => esc_html__( 'Border', 'ava-woo-builder' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['attributes_value'],
				'fields_options' => array(
					'border' => array(
						'default' => 'solid',
					),
					'width'  => array(
						'default' => array(
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						),
					),
					'color'  => array(),
				),
			)
		);

		$this->add_responsive_control(
			'attrs_table_value_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['attributes_value'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'attrs_table_value_padding',
			array(
				'label'      => __( 'Padding', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['attributes_value'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'attrs_table_value_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['attributes_value'] => 'text-align: {{VALUE}};',
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
