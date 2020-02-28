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
			$( document ).on( 'wc_update_cart added_to_cart', AvaWooBuilder.avaCartPopupOpen);

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

			AvaWooBuilder.initCarousel( $target, $target.data( 'slider_options' ) );

		},

		widgetCategories: function ( $scope ) {

			var $target = $scope.find( '.ava-woo-carousel' );

			if ( ! $target.length ) {
				return;
			}

			AvaWooBuilder.initCarousel( $target, $target.data( 'slider_options' ) );

		},

		reInitCarousel: function( event, $scope ) {
			AvaWooBuilder.widgetProducts( $scope );
		},

		initCarousel: function( $target, options ) {

			var mobileSlides, tabletSlides, desktopSlides, defaultOptions, visibleSlides,
				$slidesCount = $target.find('.swiper-slide').length;
			
			if ( options.slidesToShow.mobile ) {
				mobileSlides = options.slidesToShow.mobile;
			} else {
				mobileSlides = 1;
			}

			if ( options.slidesToShow.tablet ) {
				tabletSlides = options.slidesToShow.tablet;
			} else {
				tabletSlides = 1 === options.slidesToShow.desktop ? 1 : 2;
			}
			
			desktopSlides = options.slidesToShow.desktop;
		
			if( $( window ).width() < 768 ) {
				visibleSlides = mobileSlides;
			} else if ( $( window ).width() < 1025 ) {
				visibleSlides = tabletSlides;
			} else {
				visibleSlides = desktopSlides;
			}

			defaultOptions = {
				slidesPerView: desktopSlides,
				breakpoints: {
					768: {
						slidesPerView: mobileSlides,
						slidesPerGroup: 1,
					},
					1025: {
						slidesPerView: tabletSlides,
						slidesPerGroup: 1,
					},
				},
				pagination: {
					el: '.swiper-pagination',
					clickable: true,
				},
				navigation: {
					nextEl: '.ava-swiper-button-next',
					prevEl: '.ava-swiper-button-prev',
				},
			};
			
			if ( $slidesCount > visibleSlides ) {
				new Swiper($target, $.extend( {}, defaultOptions, options ) );
				$target.find( '.ava-arrow' ).show();
			} else {
				$target.find( '.ava-arrow' ).hide();
			}
		},
		
		avaCartPopupOpen: function ( event ) {
			var $target_enable = $( event.currentTarget.activeElement ).parents('.ava-woo-products, .ava-woo-products-list, .ava-woo-builder-archive-add-to-cart').data('cart-popup-enable'),
				$target_id     = $( event.currentTarget.activeElement ).parents('.ava-woo-products, .ava-woo-products-list, .ava-woo-builder-archive-add-to-cart').data('cart-popup-id');
			
			$target_id = $($target_id)[0];
			
			if ( $target_enable ) {
				$( window ).trigger( {
					type: 'ava-popup-open-trigger',
					popupData: {
						popupId: 'ava-popup-' + $target_id
					}
				} );
			}
		}

	};

	$( window ).on( 'elementor/frontend/init', AvaWooBuilder.init );

}( jQuery, window.elementorFrontend ) );