<?php
/**
 * Class: Ava_Woo_Products
 * Name: Products Grid
 * Slug: ava-woo-products
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Ava_Woo_Products extends Ava_Woo_Builder_Base {

	public function get_name() {
		return 'ava-woo-products';
	}

	public function get_title() {
		return esc_html__( 'Products Grid', 'ava-woo-builder' );
	}

	public function get_icon() {
		return 'avawoobuilder-icon-16';
	}

	public function get_ava_help_url() {
		return 'https://blockcroco.com/knowledge-base/articles/avawoobuilder-products-grid-widget-overview/';
	}

	public function get_categories() {
		return array( 'ava-woo-builder' );
	}

	public function __shortcode() {
		return ava_woo_builder_shortocdes()->get_shortcode( $this->get_name() );
	}

	public function get_script_depends() {
		return array( 'jquery-slick' );
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_general',
			array(
				'label' => esc_html__( 'General', 'ava-woo-builder' ),
			)
		);

		$attributes = $this->__shortcode()->get_atts();

		foreach ( $attributes as $attr => $settings ) {

			if ( empty( $settings['type'] ) ) {
				continue;
			}

			if ( ! empty( $settings['responsive'] ) ) {
				$this->add_responsive_control( $attr, $settings );
			} else {
				$this->add_control( $attr, $settings );
			}

		}

		$this->end_controls_section();

		$css_scheme = apply_filters(
			'ava-woo-builder/ava-woo-products/css-scheme',
			array(
				'wrap'        => '.ava-woo-products',
				'column'      => '.ava-woo-products .ava-woo-products__item',
				'inner-box'   => '.ava-woo-products .ava-woo-products__inner-box',
				'thumb'       => '.ava-woo-products .ava-woo-product-thumbnail',
				'title'       => '.ava-woo-products .ava-woo-product-title',
				'sku'         => '.ava-woo-products .ava-woo-product-sku',
				'categories'  => '.ava-woo-products .ava-woo-product-categories',
				'tags'        => '.ava-woo-products .ava-woo-product-tags',
				'excerpt'     => '.ava-woo-products .ava-woo-product-excerpt',
				'rating'      => '.ava-woo-products .ava-woo-product-rating',
				'price'       => '.ava-woo-products .ava-woo-product-price',
				'currency'    => '.ava-woo-products .ava-woo-product-price .woocommerce-Price-currencySymbol',
				'button-wrap' => '.ava-woo-products .ava-woo-product-button',
				'button'      => '.ava-woo-products .ava-woo-product-button .button',
				'overlay'     => '.ava-woo-products .ava-woo-product-img-overlay',
				'badges'      => '.ava-woo-products .ava-woo-product-badges',
				'badge'       => '.ava-woo-products .ava-woo-product-badge',
				'not-found-message' => '.ava-woo-products__not-found',
			)
		);

		$this->start_controls_section(
			'section_carousel',
			array(
				'label' => esc_html__( 'Carousel', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'carousel_enabled',
			array(
				'label'        => esc_html__( 'Enable Carousel', 'ava-woo-builder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_responsive_control(
			'slides_min_height',
			array(
				'label'       => esc_html__( 'Slides Minimal Height', 'ava-woo-builder' ),
				'label_block' => true,
				'type'        => Controls_Manager::NUMBER,
				'default'     => '',
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['inner-box'] => 'min-height: {{VALUE}}px;',
				),

			)
		);

		$this->add_control(
			'slides_to_scroll',
			array(
				'label'     => esc_html__( 'Slides to Scroll', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => ava_woo_builder_tools()->get_select_range( 4 ),
				'condition' => array(
					'columns!' => '1',
				),
			)
		);

		$this->add_control(
			'arrows',
			array(
				'label'        => esc_html__( 'Show Arrows Navigation', 'ava-woo-builder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'prev_arrow',
			array(
				'label'     => esc_html__( 'Prev Arrow Icon', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fa fa-angle-left',
				'options'   => ava_woo_builder_tools()->get_available_prev_arrows_list(),
				'condition' => array(
					'arrows' => 'true',
				),
			)
		);

		$this->add_control(
			'next_arrow',
			array(
				'label'     => esc_html__( 'Next Arrow Icon', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fa fa-angle-right',
				'options'   => ava_woo_builder_tools()->get_available_next_arrows_list(),
				'condition' => array(
					'arrows' => 'true',
				),
			)
		);

		$this->add_control(
			'dots',
			array(
				'label'        => esc_html__( 'Show Dots Navigation', 'ava-woo-builder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'true',
				'default'      => '',
			)
		);

		$this->add_control(
			'pause_on_hover',
			array(
				'label'        => esc_html__( 'Pause on Hover', 'ava-woo-builder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'true',
				'default'      => '',
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => esc_html__( 'Autoplay', 'ava-woo-builder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'autoplay_speed',
			array(
				'label'     => esc_html__( 'Autoplay Speed', 'ava-woo-builder' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => array(
					'autoplay' => 'true',
				),
			)
		);

		$this->add_control(
			'infinite',
			array(
				'label'        => esc_html__( 'Infinite Loop', 'ava-woo-builder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'effect',
			array(
				'label'     => esc_html__( 'Effect', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'slide',
				'options'   => array(
					'slide' => esc_html__( 'Slide', 'ava-woo-builder' ),
					'fade'  => esc_html__( 'Fade', 'ava-woo-builder' ),
				),
				'condition' => array(
					'columns' => '1',
				),
			)
		);

		$this->add_control(
			'speed',
			array(
				'label'   => esc_html__( 'Animation Speed', 'ava-woo-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 500,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_column_style',
			array(
				'label'      => esc_html__( 'Column', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'column_padding',
			array(
				'label'       => esc_html__( 'Column Padding', 'ava-woo-builder' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px' ),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['column'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['wrap']   => 'margin-right: -{{RIGHT}}{{UNIT}}; margin-left: -{{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			array(
				'label'      => esc_html__( 'Product Item', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_box( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_thumb_style',
			array(
				'label'      => esc_html__( 'Product Thumbnail', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_thumbnail( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			array(
				'label'      => esc_html__( 'Title', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_title( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_excerpt_style',
			array(
				'label'      => esc_html__( 'Excerpt', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_excerpt( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			array(
				'label'      => esc_html__( 'Button', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_button( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_price_style',
			array(
				'label'      => esc_html__( 'Price', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_price( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_rating_styles',
			array(
				'label'      => esc_html__( 'Rating', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_rating( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cats_style',
			array(
				'label'      => esc_html__( 'Categories', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_categories( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_tags_style',
			array(
				'label'      => esc_html__( 'Tags', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_tags( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_badges_style',
			array(
				'label'      => esc_html__( 'Badges', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_badges( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_sku_style',
			array(
				'label'      => esc_html__( 'SKU', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_sku( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_overlay_style',
			array(
				'label'      => esc_html__( 'Overlay', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_overlay( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_arrows_style',
			array(
				'label'      => esc_html__( 'Carousel Arrows', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => array(
					'carousel_enabled' => 'yes'
				)
			)
		);

		$this->controls_section_carousel_arrows();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dots_style',
			array(
				'label'      => esc_html__( 'Carousel Dots', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => array(
					'carousel_enabled' => 'yes'
				)
			)
		);

		$this->controls_section_carousel_dots();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_not_found_message_style',
			array(
				'label'      => esc_html__( 'Not Found Message', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_not_found_message( $css_scheme );

		$this->end_controls_section();

	}

	protected function render() {
		$this->__context = 'render';

		$this->__open_wrap();

		$attributes    = array();
		$tag           = $this->get_name();
		$settings      = $this->get_settings();
		$shortcode_obj = $this->__shortcode();

		$settings['_widget_id'] = $this->get_id();

		$shortcode_obj->set_settings( $settings );

		foreach ( $shortcode_obj->get_atts() as $attr => $data ) {
			$attr_val            = $settings[ $attr ];
			$attr_val            = ! is_array( $attr_val ) ? $attr_val : implode( ',', $attr_val );
			$attributes[ $attr ] = $attr_val;
		}

		$attributes['_element_id'] = isset( $settings['_element_id'] ) ? $settings['_element_id'] : '';

		echo ava_woo_builder_tools()->get_carousel_wrapper_atts(
			$shortcode_obj->do_shortcode( $attributes ),
			$settings
		);

		$this->__close_wrap();
	}

	protected function controls_section_box( $css_scheme ){

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'box_border',
				'label'       => esc_html__( 'Border', 'ava-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['inner-box'],
			)
		);

		$this->add_responsive_control(
			'box_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['inner-box'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'box_style_tabs' );

		$this->start_controls_tab(
			'box_normal_styles',
			array(
				'label' => esc_html__( 'Normal', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'box_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['inner-box'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'inner_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['inner-box'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'box_hover_styles',
			array(
				'label' => esc_html__( 'Hover', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'box_hover_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['inner-box'] . ':hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'inner_box_hover_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['inner-box'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'box_padding',
			array(
				'label'      => esc_html__( 'Padding', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['inner-box'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before'
			)
		);

	}

	protected function controls_section_overlay( $css_scheme ) {

		$this->start_controls_tabs( 'tabs_overlay_style' );

		$this->start_controls_tab(
			'tab_overlay_normal',
			array(
				'label' => esc_html__( 'Normal', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'overlay_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['overlay'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_overlay_hover',
			array(
				'label' => esc_html__( 'Hover', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'overlay_bg_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['column'] . ':hover .ava-woo-product-img-overlay' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

	}

	protected function controls_section_tags( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tags_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['tags'],
				'exclude' => array( 'text_decoration' ),
			)
		);

		$this->add_control(
			'tags_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tags'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_tags_color' );

		$this->start_controls_tab(
			'tab_tags_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'tags_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tags'] . ' a' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['tags']        => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_tags_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'tags_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tags'] . ' a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'tags_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
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
					'{{WRAPPER}} ' . $css_scheme['tags'] => 'text-align: {{VALUE}};',
				),
				'separator' => 'before'
			)
		);

		$this->add_responsive_control(
			'tags_padding',
			array(
				'label'      => esc_html__( 'Padding', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['tags'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tags_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['tags'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tags_order',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Order', 'ava-woo-builder' ),
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tags'] => 'order: {{VALUE}}',
				),
				'condition' => array(
					'presets' => array( 'preset-1' )
				)
			)
		);

	}

	protected function controls_section_categories( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cats_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['categories'],
				'exclude' => array( 'text_decoration' ),
			)
		);

		$this->add_control(
			'cats_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['categories'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_cats_color' );

		$this->start_controls_tab(
			'tab_cats_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'cats_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['categories'] . ' a' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['categories']        => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_cats_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'cats_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['categories'] . ' a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'cats_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
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
					'{{WRAPPER}} ' . $css_scheme['categories'] => 'text-align: {{VALUE}};',
				),
				'separator' => 'before'
			)
		);

		$this->add_responsive_control(
			'cats_padding',
			array(
				'label'      => esc_html__( 'Padding', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['categories'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'cats_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['categories'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'cats_order',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Order', 'ava-woo-builder' ),
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['categories'] => 'order: {{VALUE}}',
				),
				'condition' => array(
					'presets' => array( 'preset-1' )
				)
			)
		);

	}

	protected function controls_section_price( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['price'],
			)
		);

		$this->add_control(
			'price_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['price'] . ' .amount' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'price_space_between',
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

		$this->start_controls_tabs( 'tabs_price_style' );

		$this->start_controls_tab(
			'tab_price_regular',
			array(
				'label' => esc_html__( 'Regular', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'price_regular_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del .amount' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'price_regular_decoration',
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
			'price_regular_size',
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
			'price_regular_weight',
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
			'tab_price_sale',
			array(
				'label' => esc_html__( 'Sale', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'price_sale_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins .amount' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'price_sale_decoration',
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
			'price_sale_size',
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
			'price_sale_weight',
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

		$this->add_responsive_control(
			'price_item_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
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
					'{{WRAPPER}} ' . $css_scheme['price'] => 'text-align: {{VALUE}};',
				),
				'separator' => 'before'
			)
		);

		$this->add_responsive_control(
			'price_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'price_order',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Order', 'ava-woo-builder' ),
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'order: {{VALUE}}',
				),
				'condition' => array(
					'presets' => array( 'preset-1' )
				)
			)
		);

		$this->add_control(
			'currency_sign_style',
			array(
				'label'     => esc_html__( 'Currency Sign', 'ava-woo-builder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
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
				'label' => esc_html__( 'Regular', 'ava-woo-builder' ),
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
				'label' => esc_html__( 'Sale', 'ava-woo-builder' ),
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

	}

	protected function controls_section_badges( $css_scheme ) {

		$this->add_control(
			'badges_display',
			array(
				'label'     => esc_html__( 'Badges Display', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'inline-block' => esc_html__( 'Inline', 'ava-woo-builder' ),
					'block'        => esc_html__( 'Block', 'ava-woo-builder' ),
				),
				'default'   => 'inline-block',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'display: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'badges_min_width',
			array(
				'label'       => esc_html__( 'Min Width', 'ava-woo-builder' ),
				'label_block' => true,
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px' ),
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 300,
					),
				),
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'min-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'badges_min_height',
			array(
				'label'       => esc_html__( 'Min Height', 'ava-woo-builder' ),
				'label_block' => true,
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px' ),
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 300,
					),
				),
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'min-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'badge_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['badge'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'badge_on_sale_border',
				'label'       => esc_html__( 'Border', 'ava-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['badge'],
				'separator'   => 'before'
			)
		);

		$this->add_responsive_control(
			'badge_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'ava-woo-builder' ),
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
				'name'     => 'badge_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['badge'],
			)
		);

		$this->add_control(
			'badge_on_sale_color',
			array(
				'label'     => esc_html__( 'Badge Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'color: {{VALUE}}',
				),
				'separator' => 'before'
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'badge_on_sale_background',
				'fields_options' => array(
					'attachment' => array(
						'condition' => array()
					)
				),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['badge'],
			)
		);

		$this->add_responsive_control(
			'badge_alignment',
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
					'{{WRAPPER}} ' . $css_scheme['badges'] => 'text-align: {{VALUE}};',
				),
				'separator' => 'before'
			)
		);

		$this->add_responsive_control(
			'badge_padding',
			array(
				'label'      => esc_html__( 'Padding', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'badge_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	}

	protected function controls_section_button( $css_scheme ) {

		$this->add_control(
			'button_display',
			array(
				'label'     => esc_html__( 'Button Display', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'inline-block' => esc_html__( 'Inline', 'ava-woo-builder' ),
					'block'        => esc_html__( 'Block', 'ava-woo-builder' ),
				),
				'default'   => 'inline-block',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'display: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button'],
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'button_bg',
			array(
				'label'       => _x( 'Background Type', 'Background Control', 'ava-woo-builder' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'color'    => array(
						'title' => _x( 'Classic', 'Background Control', 'ava-woo-builder' ),
						'icon'  => 'fa fa-paint-brush',
					),
					'gradient' => array(
						'title' => _x( 'Gradient', 'Background Control', 'ava-woo-builder' ),
						'icon'  => 'fa fa-barcode',
					),
				),
				'default'     => 'color',
				'label_block' => false,
				'render_type' => 'ui',
			)
		);

		$this->add_control(
			'button_bg_color',
			array(
				'label'     => _x( 'Color', 'Background Control', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'title'     => _x( 'Background Color', 'Background Control', 'ava-woo-builder' ),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_bg_color_stop',
			array(
				'label'       => _x( 'Location', 'Background Control', 'ava-woo-builder' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( '%' ),
				'default'     => array(
					'unit' => '%',
					'size' => 0,
				),
				'render_type' => 'ui',
				'condition'   => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type'     => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_color_b',
			array(
				'label'       => _x( 'Second Color', 'Background Control', 'ava-woo-builder' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#f2295b',
				'render_type' => 'ui',
				'condition'   => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type'     => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_color_b_stop',
			array(
				'label'       => _x( 'Location', 'Background Control', 'ava-woo-builder' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( '%' ),
				'default'     => array(
					'unit' => '%',
					'size' => 100,
				),
				'render_type' => 'ui',
				'condition'   => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type'     => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_gradient_type',
			array(
				'label'       => _x( 'Type', 'Background Control', 'ava-woo-builder' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'linear' => _x( 'Linear', 'Background Control', 'ava-woo-builder' ),
					'radial' => _x( 'Radial', 'Background Control', 'ava-woo-builder' ),
				),
				'default'     => 'linear',
				'render_type' => 'ui',
				'condition'   => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type'     => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_gradient_angle',
			array(
				'label'      => _x( 'Angle', 'Background Control', 'ava-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'deg' ),
				'default'    => array(
					'unit' => 'deg',
					'size' => 180,
				),
				'range'      => array(
					'deg' => array(
						'step' => 10,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{button_bg_color.VALUE}} {{button_bg_color_stop.SIZE}}{{button_bg_color_stop.UNIT}}, {{button_bg_color_b.VALUE}} {{button_bg_color_b_stop.SIZE}}{{button_bg_color_b_stop.UNIT}})',
				),
				'condition'  => array(
					'button_bg'               => array( 'gradient' ),
					'button_bg_gradient_type' => 'linear',
				),
				'of_type'    => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_gradient_position',
			array(
				'label'     => _x( 'Position', 'Background Control', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'center center' => _x( 'Center Center', 'Background Control', 'ava-woo-builder' ),
					'center left'   => _x( 'Center Left', 'Background Control', 'ava-woo-builder' ),
					'center right'  => _x( 'Center Right', 'Background Control', 'ava-woo-builder' ),
					'top center'    => _x( 'Top Center', 'Background Control', 'ava-woo-builder' ),
					'top left'      => _x( 'Top Left', 'Background Control', 'ava-woo-builder' ),
					'top right'     => _x( 'Top Right', 'Background Control', 'ava-woo-builder' ),
					'bottom center' => _x( 'Bottom Center', 'Background Control', 'ava-woo-builder' ),
					'bottom left'   => _x( 'Bottom Left', 'Background Control', 'ava-woo-builder' ),
					'bottom right'  => _x( 'Bottom Right', 'Background Control', 'ava-woo-builder' ),
				),
				'default'   => 'center center',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{button_bg_color.VALUE}} {{button_bg_color_stop.SIZE}}{{button_bg_color_stop.UNIT}}, {{button_bg_color_b.VALUE}} {{button_bg_color_b_stop.SIZE}}{{button_bg_color_b_stop.UNIT}})',
				),
				'condition' => array(
					'button_bg'               => array( 'gradient' ),
					'button_bg_gradient_type' => 'radial',
				),
				'of_type'   => 'gradient',
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_text_decor',
			array(
				'label'     => esc_html__( 'Text Decoration', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'none'      => esc_html__( 'None', 'ava-woo-builder' ),
					'underline' => esc_html__( 'Underline', 'ava-woo-builder' ),
				),
				'default'   => 'none',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'text-decoration: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['button'] . '>*' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'ava-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'],
				'separator'   => 'before'
			)
		);

		$this->add_responsive_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'button_hover_bg',
			array(
				'label'       => _x( 'Background Type', 'Background Control', 'ava-woo-builder' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'color'    => array(
						'title' => _x( 'Classic', 'Background Control', 'ava-woo-builder' ),
						'icon'  => 'fa fa-paint-brush',
					),
					'gradient' => array(
						'title' => _x( 'Gradient', 'Background Control', 'ava-woo-builder' ),
						'icon'  => 'fa fa-barcode',
					),
				),
				'default'     => 'color',
				'label_block' => false,
				'render_type' => 'ui',
			)
		);

		$this->add_control(
			'button_hover_bg_color',
			array(
				'label'     => _x( 'Color', 'Background Control', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'title'     => _x( 'Background Color', 'Background Control', 'ava-woo-builder' ),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_bg_color_stop',
			array(
				'label'       => _x( 'Location', 'Background Control', 'ava-woo-builder' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( '%' ),
				'default'     => array(
					'unit' => '%',
					'size' => 0,
				),
				'render_type' => 'ui',
				'condition'   => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type'     => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_color_b',
			array(
				'label'       => _x( 'Second Color', 'Background Control', 'ava-woo-builder' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#f2295b',
				'render_type' => 'ui',
				'condition'   => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type'     => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_color_b_stop',
			array(
				'label'       => _x( 'Location', 'Background Control', 'ava-woo-builder' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( '%' ),
				'default'     => array(
					'unit' => '%',
					'size' => 100,
				),
				'render_type' => 'ui',
				'condition'   => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type'     => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_gradient_type',
			array(
				'label'       => _x( 'Type', 'Background Control', 'ava-woo-builder' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'linear' => _x( 'Linear', 'Background Control', 'ava-woo-builder' ),
					'radial' => _x( 'Radial', 'Background Control', 'ava-woo-builder' ),
				),
				'default'     => 'linear',
				'render_type' => 'ui',
				'condition'   => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type'     => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_gradient_angle',
			array(
				'label'      => _x( 'Angle', 'Background Control', 'ava-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'deg' ),
				'default'    => array(
					'unit' => 'deg',
					'size' => 180,
				),
				'range'      => array(
					'deg' => array(
						'step' => 10,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{button_hover_bg_color.VALUE}} {{button_hover_bg_color_stop.SIZE}}{{button_hover_bg_color_stop.UNIT}}, {{button_hover_bg_color_b.VALUE}} {{button_hover_bg_color_b_stop.SIZE}}{{button_hover_bg_color_b_stop.UNIT}})',
				),
				'condition'  => array(
					'button_hover_bg'               => array( 'gradient' ),
					'button_hover_bg_gradient_type' => 'linear',
				),
				'of_type'    => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_gradient_position',
			array(
				'label'     => _x( 'Position', 'Background Control', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'center center' => _x( 'Center Center', 'Background Control', 'ava-woo-builder' ),
					'center left'   => _x( 'Center Left', 'Background Control', 'ava-woo-builder' ),
					'center right'  => _x( 'Center Right', 'Background Control', 'ava-woo-builder' ),
					'top center'    => _x( 'Top Center', 'Background Control', 'ava-woo-builder' ),
					'top left'      => _x( 'Top Left', 'Background Control', 'ava-woo-builder' ),
					'top right'     => _x( 'Top Right', 'Background Control', 'ava-woo-builder' ),
					'bottom center' => _x( 'Bottom Center', 'Background Control', 'ava-woo-builder' ),
					'bottom left'   => _x( 'Bottom Left', 'Background Control', 'ava-woo-builder' ),
					'bottom right'  => _x( 'Bottom Right', 'Background Control', 'ava-woo-builder' ),
				),
				'default'   => 'center center',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{button_hover_bg_color.VALUE}} {{button_hover_bg_color_stop.SIZE}}{{button_hover_bg_color_stop.UNIT}}, {{button_hover_bg_color_b.VALUE}} {{button_hover_bg_color_b_stop.SIZE}}{{button_hover_bg_color_b_stop.UNIT}})',
				),
				'condition' => array(
					'button_hover_bg'               => array( 'gradient' ),
					'button_hover_bg_gradient_type' => 'radial',
				),
				'of_type'   => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_hover_text_decor',
			array(
				'label'     => esc_html__( 'Text Decoration', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'none'      => esc_html__( 'None', 'ava-woo-builder' ),
					'underline' => esc_html__( 'Underline', 'ava-woo-builder' ),
				),
				'default'   => 'none',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'text-decoration: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover > *' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_hover_border',
				'label'       => esc_html__( 'Border', 'ava-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'button_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
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
					'{{WRAPPER}} ' . ' .ava-woo-product-button' => 'text-align: {{VALUE}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button-wrap'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_order',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Order', 'ava-woo-builder' ),
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . ' .ava-woo-product-button' => 'order: {{VALUE}}',
				),
				'condition' => array(
					'presets' => array( 'preset-1' )
				)
			)
		);

	}

	protected function controls_section_excerpt( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'excerpt_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['excerpt'],
			)
		);

		$this->add_control(
			'excerpt_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['excerpt'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'excerpt_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['excerpt'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'excerpt_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
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
					'{{WRAPPER}} ' . $css_scheme['excerpt'] => 'text-align: {{VALUE}};',
				),
				'separator' => 'before'
			)
		);

		$this->add_responsive_control(
			'excerpt_padding',
			array(
				'label'      => esc_html__( 'Padding', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['excerpt'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'excerpt_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['excerpt'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'excerpt_order',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Order', 'ava-woo-builder' ),
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['excerpt'] => 'order: {{VALUE}}',
				),
				'condition' => array(
					'presets' => array( 'preset-1' )
				)
			)
		);

	}

	protected function controls_section_sku( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sku_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['sku'],
			)
		);

		$this->add_control(
			'sku_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['sku'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'sku_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['sku'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'sku_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
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
					'{{WRAPPER}} ' . $css_scheme['sku'] => 'text-align: {{VALUE}};',
				),
				'separator' => 'before'
			)
		);

		$this->add_responsive_control(
			'sku_padding',
			array(
				'label'      => esc_html__( 'Padding', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['sku'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'sku_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['sku'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'sku_order',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Order', 'ava-woo-builder' ),
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['sku'] => 'order: {{VALUE}}',
				),
				'condition' => array(
					'presets' => array( 'preset-1' )
				)
			)
		);

	}

	protected function controls_section_title( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['title'],
			)
		);

		$this->add_control(
			'title_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_title_color' );

		$this->start_controls_tab(
			'tab_title_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] . ' a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'title_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] . ' a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'title_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
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
				'separator' => 'before'
			)
		);

		$this->add_responsive_control(
			'title_padding',
			array(
				'label'      => esc_html__( 'Padding', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_order',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Order', 'ava-woo-builder' ),
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'order: {{VALUE}}',
				),
				'condition' => array(
					'presets' => array( 'preset-1' )
				)
			)
		);

	}

	protected function controls_section_thumbnail( $css_scheme ) {

		$this->add_control(
			'thumb_background',
			array(
				'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['thumb'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'thumb_border',
				'label'       => esc_html__( 'Border', 'ava-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['thumb'],
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'thumb_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['thumb'],
			)
		);

		$this->add_responsive_control(
			'thumb_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumb'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'thumb_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumb'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before'
			)
		);

		$this->add_responsive_control(
			'thumb_padding',
			array(
				'label'      => esc_html__( 'Padding', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumb'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'thumb_order',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Order', 'ava-woo-builder' ),
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['thumb'] => 'order: {{VALUE}}',
				),
				'condition' => array(
					'presets' => array( 'preset-1' )
				)
			)
		);

	}

	protected function controls_section_rating( $css_scheme ) {

		$this->start_controls_tabs( 'tabs_rating_styles' );

		$this->start_controls_tab(
			'tab_rating_all',
			array(
				'label' => esc_html__( 'All', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'rating_color_all',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] . ' .product-rating__stars'        => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['rating'] . ' .product-rating__stars:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_rating_rated',
			array(
				'label' => esc_html__( 'Rated', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'rating_color_rated',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] . ' .product-rating__stars > span:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'rating_font_size',
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
					'{{WRAPPER}} ' . $css_scheme['rating'] . ' .product-rating__stars' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'rating_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before'
			)
		);

		$this->add_responsive_control(
			'rating_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
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
					'{{WRAPPER}} ' . $css_scheme['rating'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'rating_order',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Order', 'ava-woo-builder' ),
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] => 'order: {{VALUE}}',
				),
				'condition' => array(
					'presets' => array( 'preset-1' )
				)
			)
		);

	}

	protected function controls_section_carousel_arrows() {

		$this->start_controls_tabs( 'tabs_arrows_style' );

		$this->start_controls_tab(
			'tab_prev',
			array(
				'label' => esc_html__( 'Normal', 'ava-woo-builder' ),
			)
		);

		$this->add_group_control(
			\Ava_Woo_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'arrows_style',
				'selector'       => '{{WRAPPER}} .ava-woo-products .ava-arrow',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_1,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_next_hover',
			array(
				'label' => esc_html__( 'Hover', 'ava-woo-builder' ),
			)
		);

		$this->add_group_control(
			\Ava_Woo_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'arrows_hover_style',
				'selector'       => '{{WRAPPER}} .ava-woo-products .ava-arrow:hover',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_1,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prev_arrow_position',
			array(
				'label'     => esc_html__( 'Prev Arrow Position', 'ava-woo-builder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prev_vert_position',
			array(
				'label'   => esc_html__( 'Vertical Postition by', 'ava-woo-builder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top'    => esc_html__( 'Top', 'ava-woo-builder' ),
					'bottom' => esc_html__( 'Bottom', 'ava-woo-builder' ),
				),
			)
		);

		$this->add_responsive_control(
			'prev_top_position',
			array(
				'label'      => esc_html__( 'Top Indent', 'ava-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => - 400,
						'max' => 400,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
					'em' => array(
						'min' => - 50,
						'max' => 50,
					),
				),
				'condition'  => array(
					'prev_vert_position' => 'top',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ava-woo-products .ava-arrow.prev-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'prev_bottom_position',
			array(
				'label'      => esc_html__( 'Bottom Indent', 'ava-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => - 400,
						'max' => 400,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
					'em' => array(
						'min' => - 50,
						'max' => 50,
					),
				),
				'condition'  => array(
					'prev_vert_position' => 'bottom',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ava-woo-products .ava-arrow.prev-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				),
			)
		);

		$this->add_control(
			'prev_hor_position',
			array(
				'label'   => esc_html__( 'Horizontal Position by', 'ava-woo-builder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'  => esc_html__( 'Left', 'ava-woo-builder' ),
					'right' => esc_html__( 'Right', 'ava-woo-builder' ),
				),
			)
		);

		$this->add_responsive_control(
			'prev_left_position',
			array(
				'label'      => esc_html__( 'Left Indent', 'ava-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => - 400,
						'max' => 400,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
					'em' => array(
						'min' => - 50,
						'max' => 50,
					),
				),
				'condition'  => array(
					'prev_hor_position' => 'left',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ava-woo-products .ava-arrow.prev-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'prev_right_position',
			array(
				'label'      => esc_html__( 'Right Indent', 'ava-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => - 400,
						'max' => 400,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
					'em' => array(
						'min' => - 50,
						'max' => 50,
					),
				),
				'condition'  => array(
					'prev_hor_position' => 'right',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ava-woo-products .ava-arrow.prev-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				),
			)
		);

		$this->add_control(
			'next_arrow_position',
			array(
				'label'     => esc_html__( 'Next Arrow Position', 'ava-woo-builder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'next_vert_position',
			array(
				'label'   => esc_html__( 'Vertical Position by', 'ava-woo-builder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top'    => esc_html__( 'Top', 'ava-woo-builder' ),
					'bottom' => esc_html__( 'Bottom', 'ava-woo-builder' ),
				),
			)
		);

		$this->add_responsive_control(
			'next_top_position',
			array(
				'label'      => esc_html__( 'Top Indent', 'ava-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => - 400,
						'max' => 400,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
					'em' => array(
						'min' => - 50,
						'max' => 50,
					),
				),
				'condition'  => array(
					'next_vert_position' => 'top',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ava-woo-products .ava-arrow.next-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'next_bottom_position',
			array(
				'label'      => esc_html__( 'Bottom Indent', 'ava-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => - 400,
						'max' => 400,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
					'em' => array(
						'min' => - 50,
						'max' => 50,
					),
				),
				'condition'  => array(
					'next_vert_position' => 'bottom',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ava-woo-products .ava-arrow.next-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				),
			)
		);

		$this->add_control(
			'next_hor_position',
			array(
				'label'   => esc_html__( 'Horizontal Postition by', 'ava-woo-builder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => array(
					'left'  => esc_html__( 'Left', 'ava-woo-builder' ),
					'right' => esc_html__( 'Right', 'ava-woo-builder' ),
				),
			)
		);

		$this->add_responsive_control(
			'next_left_position',
			array(
				'label'      => esc_html__( 'Left Indent', 'ava-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => - 400,
						'max' => 400,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
					'em' => array(
						'min' => - 50,
						'max' => 50,
					),
				),
				'condition'  => array(
					'next_hor_position' => 'left',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ava-woo-products .ava-arrow.next-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'next_right_position',
			array(
				'label'      => esc_html__( 'Right Indent', 'ava-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => - 400,
						'max' => 400,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
					'em' => array(
						'min' => - 50,
						'max' => 50,
					),
				),
				'condition'  => array(
					'next_hor_position' => 'right',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ava-woo-products .ava-arrow.next-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				),
			)
		);

	}

	protected function controls_section_carousel_dots() {

		$this->start_controls_tabs( 'tabs_dots_style' );

		$this->start_controls_tab(
			'tab_dots_normal',
			array(
				'label' => esc_html__( 'Normal', 'ava-woo-builder' ),
			)
		);

		$this->add_group_control(
			\Ava_Woo_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'dots_style',
				'selector'       => '{{WRAPPER}} .ava-woo-carousel .ava-slick-dots li span',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_3,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_hover',
			array(
				'label' => esc_html__( 'Hover', 'ava-woo-builder' ),
			)
		);

		$this->add_group_control(
			\Ava_Woo_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'dots_style_hover',
				'selector'       => '{{WRAPPER}} .ava-woo-carousel .ava-slick-dots li span:hover',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_1,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_active',
			array(
				'label' => esc_html__( 'Active', 'ava-woo-builder' ),
			)
		);

		$this->add_group_control(
			\Ava_Woo_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'dots_style_active',
				'selector'       => '{{WRAPPER}} .ava-woo-carousel .ava-slick-dots li.slick-active span',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'dots_gap',
			array(
				'label'     => esc_html__( 'Gap', 'ava-woo-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 5,
					'unit' => 'px',
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .ava-woo-carousel .ava-slick-dots li' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'dots_margin',
			array(
				'label'      => esc_html__( 'Dots Box Margin', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .ava-woo-carousel .ava-slick-dots' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'dots_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
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
					'{{WRAPPER}} .ava-woo-carousel .ava-slick-dots' => 'justify-content: {{VALUE}};',
				),
			)
		);

	}

	protected function controls_section_not_found_message( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'not_found_message_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['not-found-message'],
			)
		);

		$this->add_control(
			'not_found_message_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['not-found-message'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'not_found_message_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['not-found-message'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'not_found_message_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
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
					'{{WRAPPER}} ' . $css_scheme['not-found-message'] => 'text-align: {{VALUE}};',
				),
				'separator' => 'before'
			)
		);

	}

	protected function _content_template() {
	}

}
