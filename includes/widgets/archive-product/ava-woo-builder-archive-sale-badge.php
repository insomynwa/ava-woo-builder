<?php
/**
 * Class: Ava_Woo_Builder_Archive_Sale_Badge
 * Name: Sale Badge
 * Slug: ava-woo-builder-archive-sale-badge
 */

namespace Elementor;

use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Ava_Woo_Builder_Archive_Sale_Badge extends Widget_Base {

	private $source = false;

	public function get_name() {
		return 'ava-woo-builder-archive-sale-badge';
	}

	public function get_title() {
		return esc_html__( 'Sale Badge', 'ava-woo-builder' );
	}

	public function get_icon() {
		return 'avawoobuilder-icon-11';
	}

	public function get_help_url() {
		return 'https://blockcroco.com/knowledge-base/articles/woocommerce-avawoobuilder-settings-how-to-create-and-set-a-custom-categories-archive-template/?utm_source=need-help&utm_medium=ava-woo-categories&utm_campaign=avawoobuilder';
	}

	public function get_categories() {
		return array( 'ava-woo-builder' );
	}

	public function show_in_panel() {
		return ava_woo_builder()->documents->is_document_type( 'archive' );
	}

	protected function _register_controls() {

		$css_scheme = apply_filters(
			'ava-woo-builder/ava-archive-sale-badge/css-scheme',
			array(
				'wrapper' => '.ava-woo-builder-archive-product-sale-badge',
				'badge'   => '.ava-woo-product-badge__sale'
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
			'archive_badge_text',
			array(
				'type'        => 'text',
				'label'       => esc_html__( 'Sale Badge Text', 'ava-woo-builder' ),
				'default'     => 'Sale!',
				'description' => esc_html__( 'Use %percentage_sale% and %numeric_sale% macros to display a withdrawal of discounts as a percentage or numeric of the initial price.', 'ava-woo-builder' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_archive_badge_style',
			array(
				'label'      => esc_html__( 'General', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'archive_badge_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'archive_badge_background',
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
				'name'     => 'archive_badge_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['badge'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'archive_badge_border',
				'label'       => esc_html__( 'Border', 'ava-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['badge'],
			)
		);

		$this->add_responsive_control(
			'archive_badge_border_radius',
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
				'name'     => 'archive_badge_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['badge'],
			)
		);

		$this->add_responsive_control(
			'archive_badge_content_padding',
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
			'archive_badge_content_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['wrapper'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'archive_badge_alignment',
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

		$badge_text = ava_woo_builder()->macros->do_macros( $settings['archive_badge_text'] );
		$badge_content = ava_woo_builder_template_functions()->get_product_sale_flash( $badge_text );

		if ( null !== $badge_content ){
			echo '<div class="ava-woo-builder-archive-product-sale-badge">';
			echo $badge_content;
			echo '</div>';
		}

	}


	protected function render() {
		$settings = $this->get_settings();

		$macros_settings = array(
			'archive_badge_text' => $settings['archive_badge_text'],
		);

		if ( ava_woo_builder_tools()->is_builder_content_save() ) {
			echo ava_woo_builder()->parser->get_macros_string( $this->get_name(), $macros_settings );
		} else {
			echo self::render_callback( $macros_settings );
		}

	}

}
