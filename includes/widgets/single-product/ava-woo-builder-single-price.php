<?php
/**
 * Class: Ava_Woo_Builder_Single_Price
 * Name: Single Price
 * Slug: ava-single-price
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

class Ava_Woo_Builder_Single_Price extends Ava_Woo_Builder_Base {

	public function get_name() {
		return 'ava-single-price';
	}

	public function get_title() {
		return esc_html__( 'Single Price', 'ava-woo-builder' );
	}

	public function get_icon() {
		return 'avawoobuilder-icon-7';
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
			'ava-woo-builder/ava-single-price/css-scheme',
			array(
				'price'    => '.ava-woo-builder.elementor-ava-single-price .price',
				'currency' => '.ava-woo-builder.elementor-ava-single-price .price .woocommerce-Price-currencySymbol',
			)
		);

		$this->start_controls_section(
			'section_single_price_style',
			array(
				'label'      => esc_html__( 'Price', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'single_price_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['price'],
			)
		);

		$this->add_control(
			'single_price_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'single_price_space_between',
			array(
				'label'     => esc_html__( 'Space Between Prices', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 200,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del+ins' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'single_price_item_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'ava-woo-builder' ),
						'icon'  => 'fa fa-arrow-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'ava-woo-builder' ),
						'icon'  => 'fa fa-arrow-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_single_price_style' );

		$this->start_controls_tab(
			'tab_single_price_regular',
			array(
				'label' => __( 'Regular', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'single_price_regular_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'single_price_regular_decoration',
			array(
				'label'     => esc_html__( 'Text Decoration', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'line-through',
				'options'   => array(
					'none'         => esc_html__( 'None', 'ava-woo-builder' ),
					'line-through' => esc_html__( 'Line Through', 'ava-woo-builder' ),
					'underline'    => esc_html__( 'Underline', 'ava-woo-builder' ),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'single_price_regular_size',
			array(
				'label'     => esc_html__( 'Size', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 6,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'single_price_regular_weight',
			array(
				'label'     => esc_html__( 'Font Weight', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '400',
				'options'   => array(
					'100' => esc_html__( '100', 'ava-woo-builder' ),
					'200' => esc_html__( '200', 'ava-woo-builder' ),
					'300' => esc_html__( '300', 'ava-woo-builder' ),
					'400' => esc_html__( '400', 'ava-woo-builder' ),
					'500' => esc_html__( '500', 'ava-woo-builder' ),
					'600' => esc_html__( '600', 'ava-woo-builder' ),
					'700' => esc_html__( '700', 'ava-woo-builder' ),
					'800' => esc_html__( '800', 'ava-woo-builder' ),
					'900' => esc_html__( '900', 'ava-woo-builder' ),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del' => 'font-weight: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_single_price_sale',
			array(
				'label' => __( 'Sale', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'single_price_sale_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'single_price_sale_decoration',
			array(
				'label'     => esc_html__( 'Text Decoration', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => array(
					'none'         => esc_html__( 'None', 'ava-woo-builder' ),
					'line-through' => esc_html__( 'Line Through', 'ava-woo-builder' ),
					'underline'    => esc_html__( 'Underline', 'ava-woo-builder' ),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'single_price_sale_size',
			array(
				'label'     => esc_html__( 'Size', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 6,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'single_price_sale_weight',
			array(
				'label'     => esc_html__( 'Font Weight', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '400',
				'options'   => array(
					'100' => esc_html__( '100', 'ava-woo-builder' ),
					'200' => esc_html__( '200', 'ava-woo-builder' ),
					'300' => esc_html__( '300', 'ava-woo-builder' ),
					'400' => esc_html__( '400', 'ava-woo-builder' ),
					'500' => esc_html__( '500', 'ava-woo-builder' ),
					'600' => esc_html__( '600', 'ava-woo-builder' ),
					'700' => esc_html__( '700', 'ava-woo-builder' ),
					'800' => esc_html__( '800', 'ava-woo-builder' ),
					'900' => esc_html__( '900', 'ava-woo-builder' ),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins' => 'font-weight: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_currency_sign_style',
			array(
				'label'      => esc_html__( 'Currency Sign', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'currency_sign_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['currency'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'currency_sign_size',
			array(
				'label'     => esc_html__( 'Size', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 6,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['currency'] => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'currency_sign_vertical_align',
			array(
				'label'     => esc_html__( 'Vertical Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'baseline'    => esc_html__( 'Baseline', 'ava-woo-builder' ),
					'top'         => esc_html__( 'Top', 'ava-woo-builder' ),
					'middle'      => esc_html__( 'Middle', 'ava-woo-builder' ),
					'bottom'      => esc_html__( 'Bottom', 'ava-woo-builder' ),
					'sub'         => esc_html__( 'Sub', 'ava-woo-builder' ),
					'super'       => esc_html__( 'Super', 'ava-woo-builder' ),
					'text-top'    => esc_html__( 'Text Top', 'ava-woo-builder' ),
					'text-bottom' => esc_html__( 'Text Bottom', 'ava-woo-builder' ),
				),
				'default'   => 'baseline',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['currency'] => 'vertical-align: {{VALUE}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_currency_sign_style' );

		$this->start_controls_tab(
			'tab_currency_sign_regular',
			array(
				'label' => __( 'Regular', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'currency_sign_color_regular',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'currency_sign_size_regular',
			array(
				'label'     => esc_html__( 'Size', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 6,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del .woocommerce-Price-currencySymbol' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_currency_sign_sale',
			array(
				'label' => __( 'Sale', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'currency_sign_color_sale',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'currency_sign_size_sale',
			array(
				'label'     => esc_html__( 'Size', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 6,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins .woocommerce-Price-currencySymbol' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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
