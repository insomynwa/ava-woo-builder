<?php
/**
 * Main dashboard template
 */
?><div id="ava-woo-builder-settings-page">
	<div class="ava-woo-builder-settings-page">
		<h1 class="cs-vui-title"><?php _e( 'AvaWooBuilder Settings', 'ava-woo-builder' ); ?></h1>
		<div class="cx-vui-panel">
			<cx-vui-tabs
				:in-panel="false"
				value="available-widgets"
				layout="vertical">

				<?php do_action( 'ava-woo-builder/settings-page-template/tabs-start' ); ?>

				<cx-vui-tabs-panel
					name="available-widgets"
					label="<?php _e( 'Available Widgets', 'ava-woo-builder' ); ?>"
					key="available-widgets">

					<div class="avaliable-widgets">
						<div class="avaliable-widgets__option-info">
							<div class="avaliable-widgets__option-info-name"><?php _e( 'Global Available Widgets', 'ava-woo-builder' ); ?></div>
							<div class="avaliable-widgets__option-info-desc"><?php _e( 'List of widgets that will be available when editing the page', 'ava-woo-builder' ); ?></div>
						</div>
						<div class="avaliable-widgets__controls">
							<div
								class="avaliable-widgets__control"
								v-for="(option, index) in pageOptions.global_available_widgets.options">
								<cx-vui-switcher
									:key="index"
									:name="`global-avaliable-widget-${option.value}`"
									:label="option.label"
									:wrapper-css="[ 'equalwidth' ]"
									return-true="true"
									return-false="false"
									v-model="pageOptions.global_available_widgets.value[option.value]"
								>
								</cx-vui-switcher>
							</div>
						</div>
					</div>

					<div class="avaliable-widgets">
						<div class="avaliable-widgets__option-info">
							<div class="avaliable-widgets__option-info-name"><?php _e( 'Single Product Available Widgets', 'ava-woo-builder' ); ?></div>
							<div class="avaliable-widgets__option-info-desc"><?php _e( 'List of widgets that will be available when editing the single product template', 'ava-woo-builder' ); ?></div>
						</div>
						<div class="avaliable-widgets__controls">
							<div
								class="avaliable-widgets__control"
								v-for="(option, index) in pageOptions.single_product_available_widgets.options">
								<cx-vui-switcher
									:key="index"
									:name="`single-product-avaliable-widget-${option.value}`"
									:label="option.label"
									:wrapper-css="[ 'equalwidth' ]"
									return-true="true"
									return-false="false"
									v-model="pageOptions.single_product_available_widgets.value[option.value]"
								>
								</cx-vui-switcher>
							</div>
						</div>
					</div>

					<div class="avaliable-widgets">
						<div class="avaliable-widgets__option-info">
							<div class="avaliable-widgets__option-info-name"><?php _e( 'Archive Product Available Widgets', 'ava-woo-builder' ); ?></div>
							<div class="avaliable-widgets__option-info-desc"><?php _e( 'List of widgets that will be available when editing the archive product template', 'ava-woo-builder' ); ?></div>
						</div>
						<div class="avaliable-widgets__controls">
							<div
								class="avaliable-widgets__control"
								v-for="(option, index) in pageOptions.archive_product_available_widgets.options">
								<cx-vui-switcher
									:key="index"
									:name="`archive-product-avaliable-widget-${option.value}`"
									:label="option.label"
									:wrapper-css="[ 'equalwidth' ]"
									return-true="true"
									return-false="false"
									v-model="pageOptions.archive_product_available_widgets.value[option.value]"
								>
								</cx-vui-switcher>
							</div>
						</div>
					</div>

					<div class="avaliable-widgets">
						<div class="avaliable-widgets__option-info">
							<div class="avaliable-widgets__option-info-name"><?php _e( 'Archive Category Available Widgets', 'ava-woo-builder' ); ?></div>
							<div class="avaliable-widgets__option-info-desc"><?php _e( 'List of widgets that will be available when editing the archive category template', 'ava-woo-builder' ); ?></div>
						</div>
						<div class="avaliable-widgets__controls">
							<div
								class="avaliable-widgets__control"
								v-for="(option, index) in pageOptions.archive_category_available_widgets.options">
								<cx-vui-switcher
									:key="index"
									:name="`archive-category-avaliable-widget-${option.value}`"
									:label="option.label"
									:wrapper-css="[ 'equalwidth' ]"
									return-true="true"
									return-false="false"
									v-model="pageOptions.archive_category_available_widgets.value[option.value]"
								>
								</cx-vui-switcher>
							</div>
						</div>
					</div>

					<div class="avaliable-widgets">
						<div class="avaliable-widgets__option-info">
							<div class="avaliable-widgets__option-info-name"><?php _e( 'Shop Product Available Widgets', 'ava-woo-builder' ); ?></div>
							<div class="avaliable-widgets__option-info-desc"><?php _e( 'List of widgets that will be available when editing the archive product template', 'ava-woo-builder' ); ?></div>
						</div>
						<div class="avaliable-widgets__controls">
							<div
								class="avaliable-widgets__control"
								v-for="(option, index) in pageOptions.shop_product_available_widgets.options">
								<cx-vui-switcher
									:key="index"
									:name="`shop-product-avaliable-widget-${option.value}`"
									:label="option.label"
									:wrapper-css="[ 'equalwidth' ]"
									return-true="true"
									return-false="false"
									v-model="pageOptions.shop_product_available_widgets.value[option.value]"
								>
								</cx-vui-switcher>
							</div>
						</div>
					</div>

				</cx-vui-tabs-panel>

				<cx-vui-tabs-panel
					name="product-thumb-effect"
					label="<?php _e( 'Product Thumb Effect', 'ava-woo-builder' ); ?>"
					key="product-thumb-effect">

					<cx-vui-switcher
						name="enable_product_thumb_effect"
						label="<?php _e( 'Enable Thumbnails Effect', 'ava-woo-builder' ); ?>"
						description="<?php _e( 'Enable thumbnails switch on hover', 'ava-woo-builder' ); ?>"
						:wrapper-css="[ 'equalwidth' ]"
						return-true="true"
						return-false="false"
						v-model="pageOptions['enable_product_thumb_effect'].value">
					</cx-vui-switcher>

					<cx-vui-select
						name="product_thumb_effect"
						label="<?php _e( 'Thumbnails Effect', 'ava-elements' ); ?>"
						description="<?php _e( 'Choose thumbnails hover effect', 'ava-elements' ); ?>"
						:wrapper-css="[ 'equalwidth' ]"
						size="fullwidth"
						:options-list="pageOptions.product_thumb_effect.options"
						v-model="pageOptions.product_thumb_effect.value">
					</cx-vui-select>

				</cx-vui-tabs-panel>

				<?php do_action( 'ava-woo-builder/settings-page-template/tabs-end' ); ?>
			</cx-vui-tabs>
		</div>
	</div>
</div>
