<?php
/**
 * Popup compatibility package
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Ava_Woo_Builder_Popup_Package' ) ) {


	/**
	 * Define Ava_Woo_Builder_Popup_Package class
	 */
	class Ava_Woo_Builder_Popup_Package {

		private $ava_woo_builder_qw_templates;

		/**
		 * Ava_Woo_Builder_Popup_Package constructor.
		 */
		public function __construct() {

			add_filter( 'ava-popup/widget-extension/widget-before-render-settings', array( $this, 'define_popups' ), 10, 2 );
			add_filter( 'ava-popup/popup-generator/before-define-popup-assets/popup-id', array( $this, 'define_popup_assets' ), 10, 2 );

			add_action( 'ava-popup/editor/widget-extension/after-base-controls', array( $this, 'register_controls' ), 10, 2 );
			add_filter( 'ava-popup/widget-extension/widget-before-render-settings', array( $this, 'pass_woo_builder_trigger' ), 10, 2 );
			add_filter( 'ava-popup/ajax-request/get-elementor-content', array( $this, 'get_popup_content' ), 10, 2 );

			add_action( 'ava-woo-builder/popup-generator/after-added-to-cart/cart-popup', array( $this, 'get_cart_popup_data_attrs' ), 10, 2 );

			// Add Quick View buttons controls to Products Grid widget
			add_action( 'elementor/element/ava-woo-products/section_dots_style/after_section_end', array( $this, 'register_quickview_button_content_controls' ) , 10, 2 );
			add_action( 'elementor/element/ava-woo-products/section_dots_style/after_section_end', array( $this, 'register_quickview_button_style_controls' ) , 10, 2 );
			add_action( 'elementor/element/ava-woo-products/section_general/before_section_end', array( $this, 'register_quickview_button_show_control' ) , 10, 2 );
			add_action( 'ava-woo-builder/templates/ava-woo-products/quickview-button', array( $this, 'get_quickview_button_content' ) );

			// Add Quick View buttons controls to Products List widget
			add_action( 'elementor/element/ava-woo-products-list/section_button_style/after_section_end', array( $this, 'register_quickview_button_content_controls' ) , 10, 2 );
			add_action( 'elementor/element/ava-woo-products-list/section_button_style/after_section_end', array( $this, 'register_quickview_button_style_controls' ) , 10, 2 );
			add_action( 'elementor/element/ava-woo-products-list/section_general/before_section_end', array( $this, 'register_quickview_button_show_control' ) , 10, 2 );
			add_action( 'ava-woo-builder/templates/ava-woo-products-list/quickview-button', array( $this, 'get_quickview_button_content' ) );

		}


		/**
		 * Define Ava Woo Builder quick view popups
		 *
		 * @param $widget_settings
		 * @param $settings
		 *
		 * @return mixed
		 */
		public function define_popups( $widget_settings, $settings ) {

			if( ! isset( $settings['ava_woo_builder_qv'] ) ){
				return $widget_settings;
			}

			$popup_id                   = $settings['ava_attached_popup'];
			$ava_woo_builder_qw_enabled = filter_var( $settings['ava_woo_builder_qv'], FILTER_VALIDATE_BOOLEAN );

			if ( $ava_woo_builder_qw_enabled && ! empty( $settings['ava_woo_builder_qv_template'] ) ) {
				$this->ava_woo_builder_qw_templates[ $popup_id ] = $settings['ava_woo_builder_qv_template'];
			}

			$this->enqueue_popup_styles( $settings['ava_attached_popup'] );

			return $widget_settings;

		}

		/**
		 * Enqueue current popup styles
		 *
		 * @param $popup_id
		 */
		public function enqueue_popup_styles( $popup_id ){

			if ( $popup_id ) {
				if ( class_exists( 'Elementor\Core\Files\CSS\Post' ) ) {
					$css_file = new Elementor\Core\Files\CSS\Post( $popup_id );
				} else {
					$css_file = new Elementor\Post_CSS_File( $popup_id );
				}

				$css_file->enqueue();

			}

		}

		/**
		 * Define Ava Woo Builder quick view content assets
		 *
		 * @param $popup_id
		 * @param $settings
		 *
		 * @return mixed
		 */
		public function define_popup_assets( $popup_id, $settings ) {

			if( empty( $this->ava_woo_builder_qw_templates ) ){
				return $popup_id;
			}

			if ( isset( $this->ava_woo_builder_qw_templates[ $popup_id ] ) ) {
				$popup_id = $this->ava_woo_builder_qw_templates[ $popup_id ];
			}

			return $popup_id;

		}

		/**
		 * Register Ava Woo Builder trigger
		 * @return [type] [description]
		 */
		public function register_controls( $manager ) {
			$templates = ava_woo_builder_post_type()->get_templates_list_for_options( 'single' );
			$avaliable_popups = Ava_Popup_Utils::get_avaliable_popups();

			$manager->add_control(
				'ava_woo_builder_qv',
				array(
					'label'        => __( 'Ava Woo Builder Quick View', 'ava-woo-builder' ),
					'description'  => __( 'For Products Grid and Product List widgets use Click On Custom Selector Trigger Type with .ava-quickview-button selector', 'ava-woo-builder' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'ava-woo-builder' ),
					'label_off'    => __( 'No', 'ava-woo-builder' ),
					'return_value' => 'yes',
					'default'      => '',
				)
			);

			$manager->add_control(
				'ava_woo_builder_qv_template',
				array(
					'type'      => Elementor\Controls_Manager::SELECT,
					'label'     => esc_html__( 'Template', 'ava-woo-builder' ),
					'default'   => '',
					'options'   => $templates,
					'condition' => array(
						'ava_woo_builder_qv' => 'yes',
					),
				)
			);
			
			$manager->add_control(
				'ava_woo_builder_cart_popup',
				array(
					'label'        => esc_html__( 'Ava Woo Builder Cart PopUp', 'ava-woo-builder' ),
					'description'  => esc_html__( 'This options works only with Products Grid, Product List, Archive Add to Cart widgets and open popup after product added to cart.', 'ava-woo-builder' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
					'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
					'return_value' => 'yes',
					'default'      => '',
				)
			);
			
			$manager->add_control(
				'ava_woo_builder_cart_popup_template',
				array(
					'type'      => Elementor\Controls_Manager::SELECT,
					'label'     => esc_html__( 'Template', 'ava-woo-builder' ),
					'default'   => '',
					'options'   => $avaliable_popups,
					'condition' => array(
						'ava_woo_builder_cart_popup' => 'yes',
					),
				)
			);

		}
		
		/**
		 * If cart popup option enable - set appropriate key and popup id in data attribute.
		 *
		 * @param $popup_enable
		 * @param $popup_id
		 * @return bool|int
		 */
		public function get_cart_popup_data_attrs( $popup_enable, $popup_id) {
			if ( ! $popup_enable ) {
				return false;
			}
			
			return printf( 'data-cart-popup-enable=%1s data-cart-popup-id=%2s', json_encode( $popup_enable ), $popup_id );

		}

		/**
		 * If ava_woo_builder_qv enabled - set appropriate key in localized popup data
		 *
		 * @param  [type] $data     [description]
		 * @param  [type] $settings [description]
		 *
		 * @return [type]           [description]
		 */
		public function pass_woo_builder_trigger( $data, $settings ) {

			$popup_trigger  = ! empty( $settings['ava_woo_builder_qv'] ) ? true : false;
			$popup_template = ! empty( $settings['ava_woo_builder_qv_template'] ) ? $settings['ava_woo_builder_qv_template'] : '';

			if ( $popup_trigger ) {
				$data['is-ava-woo-builder']          = $popup_trigger;
				$data['ava-woo-builder-qv-template'] = $popup_template;
			}

			return $data;

		}

		/**
		 * Get dynamic content related to passed post ID
		 *
		 * @param  [type] $content    [description]
		 * @param  [type] $popup_data [description]
		 *
		 * @return [type]             [description]
		 */
		public function get_popup_content( $content, $popup_data ) {

			if ( empty( $popup_data['isAvaWooBuilder'] ) || empty( $popup_data['productId'] ) || empty( $popup_data['templateId'] ) ) {
				return $content;
			}

			$template_id = $popup_data['templateId'];

			if ( empty( $template_id ) ) {
				return $content;
			}

			$plugin = Elementor\Plugin::instance();

			global $post;

			$post = get_post( $popup_data['productId'] );

			if ( empty( $post ) ) {
				return;
			}

			setup_postdata( $post, null, false );
			$content = $plugin->frontend->get_builder_content( $template_id,true );
			wp_reset_postdata( $post );

			return $content;

		}

		/**
		 * Get quick view button html
		 *
		 * @param $display_settings
		 */
		public function get_quickview_button_content( $display_settings ){

			$button_classes = array(
				'ava-quickview-button',
				'ava-quickview-button__link',
				'ava-quickview-button__link--icon-' . $display_settings['quickview_button_icon_position'],
			);

			?>
			<div class="ava-quickview-button__container"><a href="#" class="<?php echo implode( ' ', $button_classes ); ?>">
				<div class="ava-quickview-button__plane ava-quickview-button__plane-normal"></div>
				<div class="ava-quickview-button__state ava-quickview-button__state-normal">
					<?php
					if ( filter_var( $display_settings['quickview_use_button_icon'], FILTER_VALIDATE_BOOLEAN ) ) {
						printf( '<span class="ava-quickview-button__icon"><i class="%s"></i></span>', $display_settings['quickview_button_icon_normal'] );
					}
					printf( '<span class="ava-quickview-button__label">%s</span>', $display_settings['quickview_button_label_normal'] );
					?>
				</div>
			</a></div>
			<?php

		}

		/**
		 * Register content controls
		 *
		 * @param       $obj
		 * @param array $args
		 */
		public function register_quickview_button_content_controls( $obj, $args = array() ){

			$obj->start_controls_section(
				'section_quickview_content',
				array(
					'label' => esc_html__( 'Quick View', 'ava-woo-builder' ),
				)
			);

			$obj->add_control(
				'quickview_button_icon_normal',
				array(
					'label'       => esc_html__( 'Button Icon', 'ava-woo-builder' ),
					'type'        => Elementor\Controls_Manager::ICON,
					'label_block' => true,
					'file'        => '',
					'default'     => 'fa fa-eye',
				)
			);

			$obj->add_control(
				'quickview_button_label_normal',
				array(
					'label'   => esc_html__( 'Button Label Text', 'ava-woo-builder' ),
					'type'    => Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Quick View', 'ava-woo-builder' ),
				)
			);

			$obj->add_control(
				'quickview_button_icon_settings_heading',
				array(
					'label'     => esc_html__( 'Icon', 'ava-woo-builder' ),
					'type'      => Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$obj->add_control(
				'quickview_use_button_icon',
				array(
					'label'        => esc_html__( 'Use Icon?', 'ava-woo-builder' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
					'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				)
			);

			$obj->add_control(
				'quickview_button_icon_position',
				array(
					'label'       => esc_html__( 'Icon Position', 'ava-woo-builder' ),
					'type'        => Elementor\Controls_Manager::SELECT,
					'options'     => array(
						'left'   => esc_html__( 'Left', 'ava-woo-builder' ),
						'top'    => esc_html__( 'Top', 'ava-woo-builder' ),
						'right'  => esc_html__( 'Right', 'ava-woo-builder' ),
						'bottom' => esc_html__( 'Bottom', 'ava-woo-builder' ),
					),
					'default'     => 'left',
					'render_type' => 'template',
					'condition'   => array(
						'quickview_use_button_icon' => 'yes',
					),
				)
			);

			$obj->end_controls_section();

		}

		/**
		 * Register style controls
		 *
		 * @param       $obj
		 * @param array $args
		 */
		public function register_quickview_button_style_controls( $obj, $args = array() ){

			$css_scheme = apply_filters(
				'ava-quickview-button/quickview-button/css-scheme',
				array(
					'container'    => '.ava-quickview-button__container',
					'button'       => '.ava-quickview-button__link',
					'plane_normal' => '.ava-quickview-button__plane-normal',
					'state_normal' => '.ava-quickview-button__state-normal',
					'icon_normal'  => '.ava-quickview-button__state-normal .ava-quickview-button__icon',
					'label_normal' => '.ava-quickview-button__state-normal .ava-quickview-button__label',
				)
			);

			/**
			 * General Style Section
			 */
			$obj->start_controls_section(
				'section_button_quickview_general_style',
				array(
					'label'      => esc_html__( 'Quick View', 'ava-woo-builder' ),
					'tab'        => Elementor\Controls_Manager::TAB_STYLE,
					'show_label' => false,
				)
			);

			$obj->add_group_control(
				Elementor\Group_Control_Typography::get_type(),
				array(
					'name'     => 'quickview_button_typography',
					'scheme'   => Elementor\Scheme_Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ',{{WRAPPER}} ' . $css_scheme['label_normal'],
				)
			);

			$obj->add_control(
				'quickview_custom_size',
				array(
					'label'        => esc_html__( 'Custom Size', 'ava-woo-builder' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
					'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
					'return_value' => 'yes',
					'default'      => 'false',
				)
			);

			$obj->add_responsive_control(
				'quickview_button_custom_width',
				array(
					'label'      => esc_html__( 'Custom Width', 'ava-woo-builder' ),
					'type'       => Elementor\Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'em',
						'%',
					),
					'range'      => array(
						'px' => array(
							'min' => 40,
							'max' => 1000,
						),
						'%'  => array(
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme['button'] => 'width: {{SIZE}}{{UNIT}};',
					),
					'condition'  => array(
						'quickview_custom_size' => 'yes',
					),
				)
			);

			$obj->add_responsive_control(
				'quickview_button_custom_height',
				array(
					'label'      => esc_html__( 'Custom Height', 'ava-woo-builder' ),
					'type'       => Elementor\Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'em',
						'%',
					),
					'range'      => array(
						'px' => array(
							'min' => 10,
							'max' => 1000,
						),
						'%'  => array(
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme['button'] => 'height: {{SIZE}}{{UNIT}};',
					),
					'condition'  => array(
						'quickview_custom_size' => 'yes',
					),
				)
			);

			$obj->start_controls_tabs( 'quickview_button_style_tabs' );

			$obj->start_controls_tab(
				'quickview_button_normal_styles',
				array(
					'label' => esc_html__( 'Normal', 'ava-woo-builder' ),
				)
			);

			$obj->add_control(
				'quickview_button_normal_color',
				array(
					'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
					'type'      => Elementor\Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme['label_normal'] => 'color: {{VALUE}}',
						'{{WRAPPER}} ' . $css_scheme['icon_normal'] => 'color: {{VALUE}}',
					),
				)
			);

			$obj->add_control(
				'quickview_button_normal_background',
				array(
					'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
					'type'      => Elementor\Controls_Manager::COLOR,
					'scheme'    => array(
						'type'  => Elementor\Scheme_Color::get_type(),
						'value' => Elementor\Scheme_Color::COLOR_1,
					),
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme['button'] . ' ' . $css_scheme['plane_normal'] => 'background-color: {{VALUE}}',
					),
				)
			);

			$obj->end_controls_tab();

			$obj->start_controls_tab(
				'quickview_button_hover_styles',
				array(
					'label' => esc_html__( 'Hover', 'ava-woo-builder' ),
				)
			);

			$obj->add_control(
				'quickview_button_hover_color',
				array(
					'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
					'type'      => Elementor\Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme['button'] . ':hover ' . $css_scheme['label_normal'] => 'color: {{VALUE}}',
						'{{WRAPPER}} ' . $css_scheme['button'] . ':hover ' . $css_scheme['icon_normal'] => 'color: {{VALUE}}',
					),
				)
			);

			$obj->add_control(
				'quickview_button_hover_background',
				array(
					'label'     => esc_html__( 'Background Color', 'ava-woo-builder' ),
					'type'      => Elementor\Controls_Manager::COLOR,
					'scheme'    => array(
						'type'  => Elementor\Scheme_Color::get_type(),
						'value' => Elementor\Scheme_Color::COLOR_4,
					),
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme['button'] . ':hover ' . $css_scheme['plane_normal'] => 'background-color: {{VALUE}}',
					),
				)
			);

			$obj->add_control(
				'quickview_button_border_hover_color',
				array(
					'label'     => esc_html__( 'Border Color', 'ava-woo-builder' ),
					'type'      => Elementor\Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme['button'] . ':hover ' . $css_scheme['plane_normal'] => 'border-color: {{VALUE}}',
					),
					'condition' => array(
						'quickview_button_border_border!' => ''
					)
				)
			);

			$obj->end_controls_tab();

			$obj->end_controls_tabs();

			$obj->add_control(
				'quickview_button_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'ava-woo-builder' ),
					'type'       => Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme['button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} ' . $css_scheme['plane_normal'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->add_responsive_control(
				'quickview_button_alignment',
				array(
					'label'     => esc_html__( 'Alignment', 'ava-woo-builder' ),
					'type'      => Elementor\Controls_Manager::CHOOSE,
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
						'{{WRAPPER}} ' . $css_scheme['container'] => 'justify-content: {{VALUE}};',
					),
					'separator' => 'before'
				)
			);

			$obj->add_responsive_control(
				'quickview_button_padding',
				array(
					'label'      => __( 'Padding', 'ava-woo-builder' ),
					'type'       => Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme['button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->add_responsive_control(
				'quickview_button_margin',
				array(
					'label'      => __( 'Margin', 'ava-woo-builder' ),
					'type'       => Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme['button'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->add_control(
				'quickview_button_icon_heading',
				array(
					'label'     => esc_html__( 'Icon', 'ava-woo-builder' ),
					'type'      => Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$obj->start_controls_tabs( 'tabs_quickview_icon_styles' );

			$obj->start_controls_tab(
				'tab_quickview_icon_normal',
				array(
					'label' => esc_html__( 'Normal', 'ava-woo-builder' ),
				)
			);

			$obj->add_control(
				'normal_quickview_icon_color',
				array(
					'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
					'type'      => Elementor\Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme['icon_normal'] . ' i' => 'color: {{VALUE}}',
					),
				)
			);

			$obj->add_responsive_control(
				'normal_quickview_icon_font_size',
				array(
					'label'      => esc_html__( 'Font Size', 'ava-woo-builder' ),
					'type'       => Elementor\Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'em',
						'rem',
					),
					'range'      => array(
						'px' => array(
							'min' => 1,
							'max' => 100,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme['icon_normal'] . ' i' => 'font-size: {{SIZE}}{{UNIT}}',
					),
				)
			);

			$obj->add_responsive_control(
				'normal_quickview_icon_margin',
				array(
					'label'      => __( 'Margin', 'ava-woo-builder' ),
					'type'       => Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme['icon_normal'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->end_controls_tab();

			$obj->start_controls_tab(
				'tab_quickview_icon_hover',
				array(
					'label' => esc_html__( 'Hover', 'ava-woo-builder' ),
				)
			);

			$obj->add_control(
				'quickview_icon_color_hover',
				array(
					'label'     => esc_html__( 'Color', 'ava-woo-builder' ),
					'type'      => Elementor\Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme['button'] . ':hover ' . $css_scheme['icon_normal'] . ' i' => 'color: {{VALUE}}',
					),
				)
			);

			$obj->end_controls_tab();

			$obj->end_controls_tabs();

			$obj->end_controls_section();

		}

		/**
		 * Register displaying controls
		 *
		 * @param       $obj
		 * @param array $args
		 */
		public function register_quickview_button_show_control( $obj, $args = array() ){
			$obj->add_control(
				'show_quickview',
				array(
					'label'        => esc_html__( 'Show Quick View', 'ava-woo-builder' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'ava-woo-builder' ),
					'label_off'    => esc_html__( 'No', 'ava-woo-builder' ),
					'return_value' => 'yes',
					'default'      => '',
				)
			);

			$obj->add_responsive_control(
				'quickview_button_order',
				array(
					'type'      => Elementor\Controls_Manager::NUMBER,
					'label'     => esc_html__( 'Quick View Button Order', 'ava-woo-builder' ),
					'default'   => 1,
					'min'       => 1,
					'max'       => 10,
					'step'      => 1,
					'selectors' => array(
						'{{WRAPPER}} ' . '.ava-quickview-button__container' => 'order: {{VALUE}}',
					),
				)
			);
		}

	}

}

new Ava_Woo_Builder_Popup_Package();
