<?php
/**
 * Class: Ava_Woo_Builder_Archive_Add_To_Cart
 * Name: Add To Cart
 * Slug: ava-woo-builder-archive-add-to-cart
 */

namespace Elementor;

use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Ava_Woo_Builder_Archive_Add_To_Cart extends Widget_Base {

	private $source = false;

	public function get_name() {
		return 'ava-woo-builder-archive-add-to-cart';
	}

	public function get_title() {
		return esc_html__( 'Add to Cart', 'ava-woo-builder' );
	}

	public function get_icon() {
		return 'avawoobuilder-icon-1';
	}

	public function get_ava_help_url() {
		return 'https://blockcroco.com/knowledge-base/articles/woocommerce-avawoobuilder-settings-how-to-create-and-set-a-custom-categories-archive-template/';
	}

	public function get_categories() {
		return array( 'ava-woo-builder' );
	}

	public function show_in_panel() {
		return ava_woo_builder()->documents->is_document_type( 'archive' );
	}

	protected function _register_controls() {

		$css_scheme = apply_filters(
			'ava-woo-builder/ava-archive-add-to-cart/css-scheme',
			array(
				'wrapper' => '.ava-woo-builder-archive-add-to-cart',
				'button'  => '.ava-woo-builder-archive-add-to-cart .button',
			)
		);

		$this->start_controls_section(
			'section_archive_add_to_cart_style',
			array(
				'label'      => esc_html__( 'Add To Cart', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'        => 'archive_add_to_cart_typography',
				'scheme'      => Scheme_Typography::TYPOGRAPHY_4,
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'],
				'placeholder' => '1px',
			)
		);

		$this->add_responsive_control(
			'button_width',
			array(
				'label'      => esc_html__( 'Button Width', 'ava-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'%',
					'px',
				),
				'range'      => array(
					'%'  => array(
						'min' => 10,
						'max' => 100,
					),
					'px' => array(
						'min' => 50,
						'max' => 1000,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_archive_add_to_cart_style' );

		$this->start_controls_tab(
			'tab_archive_add_to_cart_normal',
			array(
				'label' => esc_html__( 'Normal', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'archive_add_to_cart_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'color: {{VALUE}};',
				),

			)
		);

		$this->add_control(
			'archive_add_to_cart_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'archive_add_to_cart_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_archive_add_to_cart_hover',
			array(
				'label' => esc_html__( 'Hover', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'archive_add_to_cart_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'archive_add_to_cart_background_hover_color',
			array(
				'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'archive_add_to_cart_hover_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'archive_add_to_cart_border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'archive_add_to_cart_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_archive_add_to_cart_added',
			array(
				'label' => esc_html__( 'Added', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'archive_add_to_cart_disabled_color',
			array(
				'label'     => esc_html__( 'Text Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . '.disabled' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'archive_add_to_cart_background_disabled_color',
			array(
				'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . '.disabled' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'archive_add_to_cart_added_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . '.added' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} ' . $css_scheme['button'] . '.added' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'archive_add_to_cart_added_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . '.added',
			)
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'tab_archive_add_to_cart_loading',
			array(
				'label' => esc_html__( 'Loading', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'archive_add_to_cart_loading_color',
			array(
				'label'     => esc_html__( 'Text Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . '.loading' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'archive_add_to_cart_background_loading_color',
			array(
				'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . '.loading' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'archive_add_to_cart_loading_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . '.loading' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'archive_add_to_cart_loading_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . '.loading',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'archive_add_to_cart_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'],
				'separator'   => 'before'

			)
		);

		$this->add_control(
			'archive_add_to_cart_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'archive_add_to_cart_padding',
			array(
				'label'      => esc_html__( 'Padding', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before'
			)
		);

		$this->add_responsive_control(
			'archive_add_to_cart_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
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
					'{{WRAPPER}} ' . $css_scheme['wrapper'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Returns CSS selector for nested element
	 *
	 * @param  [type] $el [description]
	 *
	 * @return [type]     [description]
	 */
	public function css_selector( $el = null ) {
		return sprintf( '{{WRAPPER}} .%1$s %2$s', $this->get_name(), $el );
	}

	public static function render_callback( $settings = array() ) {
		global $product;

		$ajax_add_to_cart_enabled = 'yes' === get_option( 'woocommerce_enable_ajax_add_to_cart' ) ? true : false;
		$popup_enable = ! empty( $settings['ava_woo_builder_cart_popup'] ) ? esc_attr( $settings['ava_woo_builder_cart_popup'] ) : false;
		$popup_id     = ! empty( $settings['ava_woo_builder_cart_popup_template'] ) ? esc_attr( $settings['ava_woo_builder_cart_popup_template'] ) : '';

		$args['class'] = implode(
			' ',
			array_filter(
				array(
					'button',
					'product_type_' . $product->get_type(),
					$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
					$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() && $ajax_add_to_cart_enabled ? 'ajax_add_to_cart' : '',
				)
			)
		);

		if ( $popup_enable ) {
			echo '<div class="ava-woo-builder-archive-add-to-cart" data-cart-popup-enable=' . json_encode( $popup_enable ) . ' data-cart-popup-id=' . $popup_id . ' >';
		} else {
			echo '<div class="ava-woo-builder-archive-add-to-cart">';
		}
		woocommerce_template_loop_add_to_cart( $args );
		echo '</div>';

	}

	protected function render() {
		$settings = $this->get_settings();

		$macros_settings = array(
			'ava_woo_builder_cart_popup'          => json_encode( ! empty( $settings['ava_woo_builder_cart_popup'] ) ? esc_attr( $settings['ava_woo_builder_cart_popup'] ) : false ),
			'ava_woo_builder_cart_popup_template' => ! empty( $settings['ava_woo_builder_cart_popup_template'] ) ? esc_attr( $settings['ava_woo_builder_cart_popup_template'] ) : '',
		);

		if ( ava_woo_builder_tools()->is_builder_content_save() ) {
			echo ava_woo_builder()->parser->get_macros_string( $this->get_name(), $macros_settings );
		} else {
			echo self::render_callback( $macros_settings );
		}

	}

}
