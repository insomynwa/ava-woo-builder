<?php
/**
 * Class: Ava_Woo_Builder_Products_Result_Count
 * Name: Products Result Count
 * Slug: ava-woo-builder-products-result-count
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Ava_Woo_Builder_Products_Result_Count extends Ava_Woo_Builder_Base {

	public function get_name() {
		return 'ava-woo-builder-products-result-count';
	}

	public function get_title() {
		return esc_html__( 'Products Result Count', 'ava-woo-builder' );
	}

	public function get_icon() {
		return 'avawoobuilder-icon-33';
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

	protected function _register_controls() {

		$css_scheme = apply_filters(
			'ava-woo-builder/products-result-count/css-scheme',
			array(
				'result_count' => '.elementor-ava-woo-builder-products-result-count .woocommerce-result-count',
			)
		);

		$this->start_controls_section(
			'section_result_count_style',
			array(
				'label' => __( 'Result Count', 'ava-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'result_count_text_color',
			array(
				'label'     => __( 'Text Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['result_count'] => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'result_count_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['result_count'],
			)
		);
		$this->add_responsive_control(
			'result_count_align',
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
					'{{WRAPPER}} ' . $css_scheme['result_count'] => 'text-align: {{VALUE}};',
				],
			)
		);

		$this->end_controls_section();
	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();

		woocommerce_result_count();

		$this->__close_wrap();

	}
}
