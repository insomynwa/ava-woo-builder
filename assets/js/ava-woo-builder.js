( function( $, elementorFrontend ) {

	"use strict";

	var AvaWooBuilder = {

		init: function() {

			var widgets = {
				'ava-single-images.default' : AvaWooBuilder.productImages,
				'ava-single-add-to-cart.default' : AvaWooBuilder.addToCart,
				'ava-single-tabs.default' : AvaWooBuilder.productTabs,
				'ava-woo-products.default' : AvaWooBuilder.widgetProducts,
				'ava-woo-categories.default' : AvaWooBuilder.widgetCategories,
			};

			$.each( widgets, function( widget, callback ) {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/' + widget, callback );
			});

			$( document ).on( 'ava-filter-content-rendered', AvaWooBuilder.reInitCarousel );
			elementorFrontend.hooks.addFilter( 'ava-popup/widget-extensions/popup-data', AvaWooBuilder.prepareAvaPopup );
			$( window ).on( 'ava-popup/render-content/ajax/success', AvaWooBuilder.avaPopupLoaded );

		},

		avaPopupLoaded : function( event, popupData ){
			setTimeout( function(){
				$( window ).trigger('resize');

				$( '.ava-popup .woocommerce-product-gallery.images' ).each( function(e) {
					$( this ).wc_product_gallery();
				} );
			}, 500);
		},

		prepareAvaPopup: function( popupData, widgetData, $scope, event ) {

			if ( widgetData['is-ava-woo-builder'] ) {
				var $product;
				popupData['isAvaWooBuilder'] = true;
				popupData['templateId'] = widgetData['ava-woo-builder-qv-template'];

				if( $scope.hasClass( 'elementor-widget-ava-woo-products' ) || $scope.hasClass( 'elementor-widget-ava-woo-products-list' ) ){
					$product     = $( event.target ).parents( '.ava-woo-builder-product' );
				} else {
					$product     = $scope.parents( '.ava-woo-builder-product' );
				}

				if( $product.length ){
					popupData['productId'] = $product.data( 'product-id' );
				}
			}

			return popupData;

		},

		productImages: function( $scope ) {
			$scope.find( '.ava-single-images__loading' ).remove();

			if ( $('body').hasClass( 'single-product' ) ) {
				return;
			}

			$scope.find( '.woocommerce-product-gallery' ).each( function() {
				$( this ).wc_product_gallery();
			} );

		},

		addToCart: function( $scope ) {

			if ( $('body').hasClass( 'single-product' ) ) {
				return;
			}

			if ( typeof wc_add_to_cart_variation_params !== 'undefined' ) {
				$scope.find( '.variations_form' ).each( function() {
					$( this ).wc_variation_form();
				});
			}

		},

		productTabs: function( $scope ) {

			$scope.find( '.ava-single-tabs__loading' ).remove();

			if ( $('body').hasClass( 'single-product' ) ) {
				return;
			}

			var hash  = window.location.hash;
			var url   = window.location.href;
			var $tabs = $scope.find( '.wc-tabs, ul.tabs' ).first();

			$tabs.find( 'a' ).addClass( 'elementor-clickable' );

			$scope.find( '.wc-tab, .woocommerce-tabs .panel:not(.panel .panel)' ).hide();

			if ( hash.toLowerCase().indexOf( 'comment-' ) >= 0 || hash === '#reviews' || hash === '#tab-reviews' ) {
				$tabs.find( 'li.reviews_tab a' ).click();
			} else if ( url.indexOf( 'comment-page-' ) > 0 || url.indexOf( 'cpage=' ) > 0 ) {
				$tabs.find( 'li.reviews_tab a' ).click();
			} else if ( hash === '#tab-additional_information' ) {
				$tabs.find( 'li.additional_information_tab a' ).click();
			} else {
				$tabs.find( 'li:first a' ).click();
			}

		},

		widgetProducts: function ( $scope ) {

			var $target = $scope.find( '.ava-woo-carousel' );

			if ( ! $target.length ) {
				return;
			}

			AvaWooBuilder.initCarousel( $target.find( '.ava-woo-products' ), $target.data( 'slider_options' ) );

		},

		widgetCategories: function ( $scope ) {

			var $target = $scope.find( '.ava-woo-carousel' );

			if ( ! $target.length ) {
				return;
			}

			AvaWooBuilder.initCarousel( $target.find( '.ava-woo-categories' ), $target.data( 'slider_options' ) );

		},

		reInitCarousel: function( event, $scope ) {
			AvaWooBuilder.widgetProducts( $scope );
		},

		initCarousel: function( $target, options ) {

			var tabletSlides, mobileSlides, defaultOptions, slickOptions;

			if ( options.slidesToShow.tablet ) {
				tabletSlides = options.slidesToShow.tablet;
			} else {
				tabletSlides = 1 === options.slidesToShow.desktop ? 1 : 2;
			}

			if ( options.slidesToShow.mobile ) {
				mobileSlides = options.slidesToShow.mobile;
			} else {
				mobileSlides = 1;
			}

			options.slidesToShow = options.slidesToShow.desktop;

			defaultOptions = {
				customPaging: function(slider, i) {
					return $( '<span />' ).text( i + 1 );
				},
				dotsClass: 'ava-slick-dots',
				responsive: [
					{
						breakpoint: 1025,
						settings: {
							slidesToShow: tabletSlides,
						}
					},
					{
						breakpoint: 768,
						settings: {
							slidesToShow: mobileSlides,
							slidesToScroll: 1
						}
					}
				]
			};

			slickOptions = $.extend( {}, defaultOptions, options );

			$target.slick( slickOptions );
		},

	};

	$( window ).on( 'elementor/frontend/init', AvaWooBuilder.init );

}( jQuery, window.elementorFrontend ) );