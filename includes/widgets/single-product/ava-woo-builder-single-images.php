<?php
/**
 * Class: Ava_Woo_Builder_Single_Images
 * Name: Single Images
 * Slug: ava-single-images
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

class Ava_Woo_Builder_Single_Images extends Ava_Woo_Builder_Base {

	public function get_name() {
		return 'ava-single-images';
	}

	public function get_title() {
		return esc_html__( 'Single Images', 'ava-woo-builder' );
	}

	public function get_script_depends() {
		return array( 'flexslider', 'zoom', 'wc-single-product' );
	}

	public function get_icon() {
		return 'avawoobuilder-icon-5';
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
			'ava-woo-builder/ava-single-images/css-scheme',
			array(
				'images'             => '.ava-woo-builder .ava-single-images__wrap div.images',
				'main_image'         => '.ava-woo-builder .ava-single-images__wrap .woocommerce-product-gallery > .flex-viewport',
				'thumbnails_wrapper' => '.ava-woo-builder .ava-single-images__wrap .flex-control-thumbs',
				'thumbnails'         => '.ava-woo-builder .ava-single-images__wrap .flex-control-thumbs > li',
				'thumbnails_img'     => '.ava-woo-builder .ava-single-images__wrap .flex-control-thumbs > li > img'
			)
		);

		$this->start_controls_section(
			'section_single_main_image_style',
			array(
				'label' => esc_html__( 'Main Image', 'ava-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'main_image_background_color',
			array(
				'label' => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['main_image']  => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'main_image_width',
			array(
				'label'      => esc_html__( 'Images Block Width (%)', 'ava-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['images'] => 'width: {{SIZE}}% !important; float: none !important;',
				),
			)
		);

		$this->add_responsive_control(
			'main_image_margin',
			array(
				'label'      => __( 'Margin', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['main_image'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'main_image_border',
				'selector' => '{{WRAPPER}} ' . $css_scheme['main_image'],
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'main_image_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['main_image'],
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_single_image_thumbnails_style',
			array(
				'label' => esc_html__( 'Thumbnails', 'ava-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'image_thumbnails_background_color',
			array(
				'label' => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnails'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'image_thumbnails_width',
			array(
				'label'      => esc_html__( 'Thumbnails Width (%)', 'ava-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 11,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnails'] => 'width: {{SIZE}}%;',
				),
			)
		);

		$this->add_responsive_control(
			'image_thumbnails_padding',
			array(
				'label'      => __( 'Padding(%)', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnails']         => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; margin:0!important;',
					'{{WRAPPER}} ' . $css_scheme['thumbnails_wrapper'] => 'margin-left: -{{LEFT}}{{UNIT}}; margin-right: -{{RIGHT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'image_thumbnails_border',
				'selector' => '{{WRAPPER}} ' . $css_scheme['thumbnails_img'],
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'image_thumbnails_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['thumbnails_img'],
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