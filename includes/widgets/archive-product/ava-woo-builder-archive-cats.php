<?php
/**
 * Class: Ava_Woo_Builder_Archive_Cats
 * Name: Categories
 * Slug: ava-woo-builder-archive-cats
 */

namespace Elementor;

use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Ava_Woo_Builder_Archive_Cats extends Widget_Base {

	private $source = false;

	public function get_name() {
		return 'ava-woo-builder-archive-cats';
	}

	public function get_title() {
		return esc_html__( 'Categories', 'ava-woo-builder' );
	}

	public function get_icon() {
		return 'avawoobuilder-icon-24';
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
			'ava-woo-builder/ava-archive-cats/css-scheme',
			array(
				'cats' => '.ava-woo-builder-archive-product-cats',
			)
		);


		$this->start_controls_section(
			'section_archive_cats_style',
			array(
				'label'      => esc_html__( 'Categories', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'archive_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['cats'],
			)
		);

		$this->start_controls_tabs( 'tabs_archive_cats_color' );

		$this->start_controls_tab(
			'tab_archive_cats_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'archive_cats_color',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['cats'] . ' a' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['cats']        => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_archive_cats_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'archive_cats_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['cats'] . ' a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'archive_cats_alignment',
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
					'{{WRAPPER}} ' . $css_scheme['cats'] => 'text-align: {{VALUE}};',
				),
				'separator' => 'before'
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

	public static function render_callback() {

		echo '<div class="ava-woo-builder-archive-product-cats">';
		echo ava_woo_builder_template_functions()->get_product_categories_list();
		echo '</div>';

	}

	protected function render() {

		if ( ava_woo_builder_tools()->is_builder_content_save() ) {
			echo ava_woo_builder()->parser->get_macros_string( $this->get_name() );
		} else {
			echo self::render_callback( );
		}

	}

}
