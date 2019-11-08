(function( $ ) {

	'use strict';

	var AvaWooTemplatePopup = {

		init: function() {

			var self = this;

			$( document )
				.on( 'click.AvaWooTemplatePopup', '.page-title-action', self.openPopup )
				.on( 'click.AvaWooTemplatePopup', '.ava-template-popup__overlay', self.closePopup )
				.on( 'change.AvaWooTemplatePopup', '#template_type', self.switchTemplates )
				.on( 'click.AvaWooTemplatePopup', '.ava-template-popup__item--uncheck', self.uncheckItem )
				.on( 'click.AvaWooTemplatePopup', '.ava-template-popup__label', self.isCheckedItem );

		},

		switchTemplates: function() {
			var $this = $( this ),
				value = $this.find( 'option:selected' ).val();

			if ( '' !== value ) {
				$( '.predesigned-row.template-' + value ).addClass( 'is-active' ).siblings().removeClass( 'is-active' );
			}
		},

		isCheckedItem: function() {
			var $this = $( this ),
				value = $this.find('input'),
				checked = value.prop( "checked" );

			AvaWooTemplatePopup.uncheckAll();

			if( checked ){
				$this.addClass( 'is--checked');
			}
		},

		uncheckAll: function() {
			var item = $( '.ava-template-popup__label' );

			if( item.hasClass('is--checked') ){
				item.removeClass('is--checked');
				item.find('input').prop( "checked", false );
			}
		},

		uncheckItem: function() {
			var $this = $( this ),
				label = $this.parent().find('.ava-template-popup__label'),
				input = label.find('input'),
				checked = input.prop( "checked" );

			if( checked ){
				input.prop( "checked", false );
				label.removeClass('is--checked');
			}
		},

		openPopup: function( event ) {
			event.preventDefault();
			$( '.ava-template-popup' ).addClass( 'ava-template-popup-active' );

			AvaWooTemplatePopup.uncheckAll();
		},

		closePopup: function() {
			$( '.ava-template-popup' ).removeClass( 'ava-template-popup-active' );
		}

	};

	AvaWooTemplatePopup.init();

})( jQuery );