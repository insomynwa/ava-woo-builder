<?php
/**
 * Class: Ava_Woo_Builder_Single_Rating
 * Name: Single Rating
 * Slug: ava-single-rating
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

class Ava_Woo_Builder_Single_Rating extends Ava_Woo_Builder_Base {

	public function get_name() {
		return 'ava-single-rating';
	}

	public function get_title() {
		return esc_html__( 'Single Rating', 'ava-woo-builder' );
	}

	public function get_icon() {
		return 'avawoobuilder-icon-8';
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
			'ava-woo-builder/ava-single-rating/css-scheme',
			array(
				'rating_wrapper' => '.ava-woo-builder .woocommerce-product-rating',
				'stars'          => '.ava-woo-builder.elementor-ava-single-rating .product-rating__content',
				'reviews_link'   => '.ava-woo-builder .woocommerce-review-link',
			)
		);

		$this->start_controls_section(
			'section_rating_styles',
			array(
				'label'      => esc_html__( 'Rating', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'show_single_empty_rating',
			array(
				'label'        => esc_html__( 'Show Rating if Empty', 'ava-woo-builder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'true',
				'default'      => '',
			)
		);

		$this->add_control(
			'rating_icon',
			array(
				'label'   => esc_html__( 'Rating Icon', 'ava-woo-builder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'avawoo-front-icon-rating-1',
				'options' => ava_woo_builder_tools()->get_available_rating_icons_list(),
			)
		);

		$this->add_control(
			'rating_direction',
			array(
				'label'     => esc_html__( 'Elements display', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'row',
				'options'   => array(
					'column' => esc_html__( 'Block', 'ava-woo-builder' ),
					'row'    => esc_html__( 'Inline', 'ava-woo-builder' ),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating_wrapper'] => 'flex-direction: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'rating_alignment_horizontal',
			array(
				'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'condition' => array(
					'rating_direction' => 'row',
				),
				'default'   => 'left',
				'options'   => array(
					'flex-start'    => array(
						'title' => esc_html__( 'Left', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-left',
					),
					'center'        => array(
						'title' => esc_html__( 'Center', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end'      => array(
						'title' => esc_html__( 'Right', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-right',
					),
					'space-between' => array(
						'title' => esc_html__( 'Justify', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-justify',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating_wrapper'] => 'justify-content: {{VALUE}}; align-items: flex-start;',
				),
			)
		);

		$this->add_responsive_control(
			'rating_alignment_vertical',
			array(
				'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'condition' => array(
					'rating_direction' => 'column',
				),
				'default'   => 'left',
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'ava-woo-builder' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating_wrapper'] => 'align-items: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'heading_stars_styles',
			array(
				'label'     => esc_html__( 'Stars', 'ava-woo-builder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'tabs_stars_styles' );

		$this->start_controls_tab(
			'tab_stars_all',
			array(
				'label' => esc_html__( 'All', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'stars_color_all',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e7e8e8',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['stars'] . ' .product-rating__icon' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_stars_rated',
			array(
				'label' => esc_html__( 'Rated', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'stars_color_rated',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fdbc32',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['stars'] . ' .product-rating__icon.active' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'stars_font_size',
			array(
				'label'      => esc_html__( 'Font Size (px)', 'ava-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 60,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 16,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['stars'] . ' .product-rating__icon' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'stars_space_between',
			array(
				'label'      => esc_html__( 'Space Between Stars (px)', 'ava-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 20,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 2,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['stars'] . ' .product-rating__icon + .product-rating__icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'stars_margin',
			array(
				'label'      => __( 'Margin', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['stars'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'heading_reviews_link_styles',
			array(
				'label'     => esc_html__( 'Reviews Link', 'ava-woo-builder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'reviews_link_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['reviews_link'],
			)
		);

		$this->start_controls_tabs( 'tabs_reviews_link_styles' );

		$this->start_controls_tab(
			'tab_reviews_link_normal',
			array(
				'label' => esc_html__( 'Normal', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'reviews_link_color_normal',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['reviews_link'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_reviews_link_hover',
			array(
				'label' => esc_html__( 'Hover', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'reviews_link_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['reviews_link'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'reviews_link_decoration',
			array(
				'label'     => esc_html__( 'Text Decoration', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => array(
					'none'         => esc_html__( 'None', 'ava-woo-builder' ),
					'line-through' => esc_html__( 'Line Through', 'ava-woo-builder' ),
					'underline'    => esc_html__( 'Underline', 'ava-woo-builder' ),
					'overline'     => esc_html__( 'Overline', 'ava-woo-builder' ),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['reviews_link'] . ':hover' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'reviews_link_margin',
			array(
				'label'      => __( 'Margin', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['reviews_link'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
