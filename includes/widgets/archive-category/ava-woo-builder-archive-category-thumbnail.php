<?php
/**
 * Class: Ava_Woo_Builder_Archive_Category_Thumbnail
 * Name: Thumbnail
 * Slug: ava-woo-builder-archive-category-thumbnail
 */

namespace Elementor;

use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Ava_Woo_Builder_Archive_Category_Thumbnail extends Widget_Base {

	private $source = false;

	public function get_name() {
		return 'ava-woo-builder-archive-category-thumbnail';
	}

	public function get_title() {
		return esc_html__( 'Thumbnail', 'ava-woo-builder' );
	}

	public function get_icon() {
		return 'avawoobuilder-icon-37';
	}

	public function get_ava_help_url() {
		return 'https://blockcroco.com/knowledge-base/articles/woocommerce-avawoobuilder-settings-how-to-create-and-set-a-custom-categories-archive-template/';
	}

	public function get_categories() {
		return array( 'ava-woo-builder' );
	}

	public function show_in_panel() {
		return ava_woo_builder()->documents->is_document_type( 'category' );
	}

	protected function _register_controls() {

		$css_scheme = apply_filters(
			'ava-woo-builder/ava-archive-category-thumbnail/css-scheme',
			array(
				'thumbnail-wrapper' => '.ava-woo-builder-archive-category-thumbnail__wrapper',
				'thumbnail'         => '.ava-woo-builder-archive-category-thumbnail'
			)
		);

		$this->start_controls_section(
			'section_general',
			array(
				'label' => __( 'Content', 'ava-woo-builder' ),
			)
		);

		$this->add_control(
			'is_linked',
			array(
				'label'        => esc_html__( 'Add link to thumbnail', 'ava-woo-builder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'archive_category_thumbnail_size',
			array(
				'type'    => 'select',
				'label'   => esc_html__( 'Thumbnail Size', 'ava-woo-builder' ),
				'default' => 'woocommerce_thumbnail',
				'options' => ava_woo_builder_tools()->get_image_sizes(),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_archive_category_thumbnail_style',
			array(
				'label'      => esc_html__( 'Thumbnail', 'ava-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'archive_category_thumbnail_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnail'] => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'archive_category_thumbnail_border',
				'selector' => '{{WRAPPER}} ' . $css_scheme['thumbnail'],
			)
		);

		$this->add_control(
			'archive_category_thumbnail_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnail'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'archive_category_thumbnail_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['thumbnail'],
			)
		);

		$this->add_responsive_control(
			'archive_category_thumbnail_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ava-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnail-wrapper'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'archive_category_thumbnail_alignment',
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
					'{{WRAPPER}} ' . $css_scheme['thumbnail-wrapper'] => 'text-align: {{VALUE}};',
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

	public static function render_callback( $settings = array(), $args ) {

		$category = !empty( $args ) ? $args['category'] : get_queried_object();

		$open_link  = '';
		$close_link = '';

		if ( isset( $settings['is_linked'] ) && 'yes' === $settings['is_linked'] ) {
			$open_link  = '<a href="' . ava_woo_builder_tools()->get_term_permalink( $category->term_id ) . '">';
			$close_link = '</a>';
		}

		echo '<div class="ava-woo-builder-archive-category-thumbnail__wrapper">';
		echo '<div class="ava-woo-builder-archive-category-thumbnail">';
		echo $open_link;
		echo ava_woo_builder_template_functions()->get_category_thumbnail(
			$category->term_id,
			$settings['archive_category_thumbnail_size']
		);
		echo $close_link;
		echo '</div>';
		echo '</div>';

	}

	protected function render() {

		$settings = $this->get_settings();

		$macros_settings = array(
			'is_linked'              => $settings['is_linked'],
			'archive_category_thumbnail_size' => $settings['archive_category_thumbnail_size'],
		);

		if ( ava_woo_builder_tools()->is_builder_content_save() ) {
			echo ava_woo_builder()->parser->get_macros_string( $this->get_name(), $macros_settings );
		} else {
			echo self::render_callback(
				$macros_settings,
				ava_woo_builder_integration_woocommerce()->get_current_args()
			);
		}

	}

	public function add_product_classes() {
	}

}
