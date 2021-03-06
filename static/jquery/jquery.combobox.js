(function($) {
	$.widget('custom.combobox', {
		_create: function() {
			this.wrapper = $('<span>')
				.addClass('custom-combobox')
				.insertAfter( this.element );

			this.element.hide();
			this._createAutocomplete();
			this._createShowAllButton();
		},

		_createAutocomplete: function() {
			var selected = this.element.children(':selected');
			var value = selected.val() ? selected.text() : '';

			this.input = $('<input>')
				.appendTo(this.wrapper)
				.val(value)
				.attr('title', '')
				.attr('name', this.element.attr('name'))
				.addClass('custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left')
				.autocomplete({
					delay:0,
					minLength:0,
					source:$.proxy(this, '_source')
				});

			this.element.attr('name', '');

			this._on(this.input, {
				autocompleteselect: function(event, ui) {
					ui.item.option.selected = true;
					this._trigger('select', event, {item: ui.item.option});
				},

				autocompletechange: "_removeIfInvalid"
			});
		},

		_createShowAllButton: function() {
			var input = this.input, wasOpen = false;

			$('<a>')
				.attr('tabIndex', -1)
				.attr('title', 'Show All Items')
				.appendTo(this.wrapper)
				.button({
					icons: {
						primary: 'ui-icon-triangle-1-s'
					},
					text: false
				})
				.removeClass('ui-corner-all')
				.addClass('custom-combobox-toggle ui-corner-right')
				.mousedown(function() {
					wasOpen = input.autocomplete('widget').is(':visible');
				})
				.click(function() {
					input.focus();

					// Close if already visible
					if (wasOpen) return;

					// Pass empty string as value to search for, displaying all results
					input.autocomplete('search', '');
				});
		},

		_source: function(request, response) {
			var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), 'i');
			response(this.element.children('option').map(function(){
				var text = $(this).text();
				if ( this.value && ( !request.term || matcher.test(text) ) ) {
					return { label:text, value:text, option:this };
				}
			}));
		},

		_destroy: function() {
			this.wrapper.remove();
			this.element.show();
		}
	});
})(jQuery);
