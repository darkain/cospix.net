'use strict';


/*
 * Text'N'Tags (textntags)
 * Version 0.1.2
 * Written by: Daniel Zahariev
 *
 * Dependencies: jQuery, jQuery.widget(), jQuery.position() (from jQuery UI), underscore.js
 *
 * License: MIT License - http://www.opensource.org/licenses/mit-license.php
 */
(function ($, _, undefined) {

	// Keys "enum"
	var KEY = {
		V: 86, Z: 90, BACKSPACE: 8, TAB: 9, RETURN: 13, ESC: 27, LEFT: 37, UP: 38,
		RIGHT: 39, DOWN: 40, COMMA: 188, SPACE: 32, HOME: 36, END: 35, 'DELETE': 46
	};

	var REGEX_ESCAPE_CHARS = ['[', '^', '$', '.', '|', '?', '*', '+', '(', ')', '\\'];

	var defaultSettings = {
		onDataRequest   : $.noop,
		realValOnSubmit : true,
		triggers        : {'@' : {}},
		templates       : {
			wrapper           : _.template('<div class="textntags-wrapper"></div>'),
			beautifier        : _.template('<div class="textntags-beautifier"><div></div></div>'),
			tagHighlight      : _.template('<strong class="<%= class_name %>"><span><%- title %></span></strong>'),
			tagList           : _.template('<div class="textntags-tag-list"></div>'),
			tagsListItem      : _.template('<li><%= title %></li>'),
			tagsListItemImage : _.template('<img src="<%= img %>" />'),
			tagsListItemIcon  : _.template('<div class="icon <%= no_img_class %>"></div>')
		}
	};

	var trigger_defaults = {
		minChars        : 2,
		uniqueTags      : true,
		showImageOrIcon : true,
		keys_map        : {id: 'id', title: 'name', description: '', img: 'avatar', no_img_class: 'icon', type: 'type'},
		syntax          : _.template('@[[<%= id %>:<%= type %>:<%= title %>]]'),
		parser          : /(@)\[\[(\d+):([\w\s\.\-]+):([\w\s@\.,-\/#!$%\^&\*;:{}=\-_`~()]+)\]\]/gi,
		parserGroups    : {id: 2, type: 3, title: 4},
		classes         : {
			tagsDropDown      : '',
			tagActiveDropDown : 'active',
			tagHighlight      : ''
		}
	};

	function transformObjectPropertiesFn(keys_map) {
		return function (obj, localToPublic) {
			var new_obj = {};
			if (localToPublic) {
				_.each(keys_map, function (v, k) { new_obj[v] = obj[k]; });
			} else {
				_.each(keys_map, function (v, k) { new_obj[k] = obj[v]; });
			}
			return new_obj;
		};
	}
	var transformObjectProperties = _.memoize(transformObjectPropertiesFn);

	var utils = {
		htmlEncode: function (str) {
			return _.escape(str);
		},
		highlightTerm: function (value, term) {
			if (!term && !term.length) {
				return value;
			}
			return value.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + term + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<b>$1</b>");
		},
		// Derived from jQuery.selection by Iwasaki Koji (@madapaja) http://blog.madapaja.net
		setCaretPosition: function (element, caretPos) {
			element.each(function () {
				this.focus();
				try {
					if (this.createTextRange) {
						var range = this.createTextRange();

						if (window.navigator.userAgent.toLowerCase().indexOf('msie') >= 0) {
							caretPos = this.value.substr(0, caretPos).replace(/\r/g, '').length;
						}

						range.collapse(true);
						range.moveStart('character', caretPos);
						range.moveEnd('character', 0);

						range.select();
					} else if (this.setSelectionRange) {
						this.setSelectionRange(caretPos, caretPos);
					}
				} catch (e) {}
			});
		},
		getCaretPosition: function (element) {
			var result = {start: 0, end: 0};

			if (element.length < 1) return result;

			element = element[0];

			if (!element.value) return result;

			try {
				if (window.getSelection) {
					result.start = element.selectionStart;
					result.end = element.selectionEnd;
				} else if (document.selection) {
					element.focus();

					var range = document.selection.createRange(),
						range2 = document.body.createTextRange(),
						tmpLength;

					try {
						range2.moveToElementText(element);
						range2.setEndPoint('StartToStart', range);
					} catch (e) {
						range2 = element.createTextRange();
						range2.setEndPoint('StartToStart', range);
					}

					result.start = element.value.length - range2.text.length;
					result.end = result.start + range.text.length;
				}
			} catch (e) {}

			return result;
		}
	};

	function beautifiedReplace(text) {
		return text.replace(/\n/g, '<br />&shy;').replace(/ {2}/g, ' &nbsp;');
	}

	function pushDiffText(text, diff_text, currentTagPosition, startPosition, endPosition) {
		if (currentTagPosition >= startPosition && currentTagPosition < endPosition) {
			text.push(beautifiedReplace(_.escape(diff_text.substr(0, currentTagPosition - startPosition))),
					  '<span class="textntags-caret-position">', diff_text[currentTagPosition], '</span>',
					  beautifiedReplace(_.escape(diff_text.substr(currentTagPosition - startPosition + 1))));
		} else {
			text.push(beautifiedReplace(_.escape(diff_text)));
		}
	}

	$.widget('ui.textntags', {
		version: '0.1.2',
		options: defaultSettings,

		currentTagPosition: 0,
		editorSelectionLength: 0,
		editorTextLength: 0,
		editorKeyCode: 0,
		editorAddingTag: false,
		editorInPasteMode: false,
		editorPasteStartPosition: 0,
		editorPasteCutCharacters: 0,

		_create: function () {
			var triggers = this.options.triggers;

			_.each(triggers, function (val, key) {
				triggers[key] = $.extend(true, {}, trigger_defaults, val);
				if (REGEX_ESCAPE_CHARS.indexOf(key) > 0) {
				  var regex_key = "\\" + key;
				} else {
				  var regex_key = key;
				}
				// FIXME: makes stupid assumption
				triggers[key].finder = new RegExp(regex_key + '\\w+(\\s+\\w+)?\\s?$', 'gi');
			});

			this.elEditor = this.element;
			this._on({
				click:    this._onEditorClick,
				keydown:  this._onEditorKeyDown,
				keypress: this._onEditorKeyPress,
				keyup:    this._onEditorKeyUp,
				input:    this._onEditorInput,
				blur:     this._onEditorBlur
			});

			this.elContainer = this.elEditor.wrapAll($(this.options.templates.wrapper())).parent();

			if (this.options.realValOnSubmit) {
				this._on(this.elEditor.closest('form'), {
					'submit.textntags': function (event) {
						this.elContainer.css('visibility', 'hidden');
						this.elEditor.val(getTaggedText());
					}
				});
			}

			var instance = this;

			this.elTagList = $(this.options.templates.tagList())
				.appendTo(this.elContainer)
				.on('mousedown', 'li', function (event) {
					instance._addTag($(this).data('tag'));
					return false;
				});

			this.elBeautifier = $(this.options.templates.beautifier()).prependTo(this.elContainer);

			this._initState();
		},

		/***** PRIVATE *****/

		_initState: function () {
			var text_with_tags = this._getEditorValue(), initialState = this.parseTaggedText(text_with_tags);

			this.tagsCollection = initialState.tagsCollection;
			this.elEditor.val(initialState.plain_text);
			this._updateBeautifier();

			if (this.tagsCollection.length > 0) {
				var addedTags = _.uniq(_.map(this.tagsCollection, function (tagPos) { return tagPos[3]; }));
				this._trigger('tagsAdded', null, [addedTags]); // FIXME: ??
			}
		},

		_getEditorValue: function () {
			return this.elEditor.val();
		},

		_getBeautifiedText: function () {
			var plain_text = this._getEditorValue(),
				position = 0, beautified_text, triggers = this.options.triggers,
				templates = this.options.templates;

			beautified_text = _.map(this.tagsCollection, function (tagPos) {
				var text = [],
					diff_pos = tagPos[0] - position,
					diff_text = diff_pos > 0 ? plain_text.substr(position, diff_pos) : '',
					objPropTransformer = transformObjectProperties(triggers[tagPos[2]].keys_map),
					tagMarkup = templates.tagHighlight({
						title: objPropTransformer(tagPos[3], false).title,
						class_name: triggers[tagPos[2]].classes.tagHighlight
					});

				pushDiffText(text, diff_text, this.currentTagPosition, position, tagPos[0]);

				text.push(tagMarkup);

				position = tagPos[0] + tagPos[1];

				return text.join('');
			});

			pushDiffText(beautified_text, plain_text.substr(position), this.currentTagPosition, position,
						 plain_text.length);

			return beautified_text.join('') + '&shy;';
		},

		_getTaggedText: function () {
			var plain_text = this._getEditorValue(),
				position = 0, tagged_text, triggers = this.options.triggers;

			tagged_text = _.map(this.tagsCollection, function (tagPos) {
				var diff_pos = tagPos[0] - position,
					diff_text = diff_pos > 0 ? plain_text.substr(position, diff_pos) : '',
					objPropTransformer = transformObjectProperties(triggers[tagPos[2]].keys_map),
					tagText = triggers[tagPos[2]].syntax(objPropTransformer(tagPos[3], false));

				position = tagPos[0] + tagPos[1];
				return diff_text + tagText;
			});

			return tagged_text.join('') + plain_text.substr(position);
		},

		_updateBeautifier: function () {
			this.elBeautifier.find('div').html(this._getBeautifiedText());
			this.elEditor.css('height', this.elBeautifier.outerHeight() + 'px');
		},

		_checkForTrigger: function (look_ahead) {
			look_ahead = look_ahead || 0;

			var sStart = utils.getCaretPosition(this.elEditor).start,
				left_text = this.elEditor.val().substr(0, sStart + look_ahead),
				found_trigger, found_trigger_char = null, query;

			if (!left_text || !left_text.length) {
				return;
			}

			found_trigger = _.find(this.options.triggers, function (trigger, tchar) {
				var matches = left_text.match(trigger.finder);
				if (matches) {
					found_trigger_char = tchar;
					query = matches[0].substr(tchar.length);
					return true;
				}
				return false;
			});

			if (!found_trigger_char || (found_trigger &&(query.length < found_trigger.minChars))) {
				this._hideTagList();
			} else {
				this.currentDataQuery = query;
				this.currentTriggerChar = found_trigger_char;
				this.currentTagPosition = left_text.length - query.length - found_trigger_char.length;
				this._delay(this._searchTags);
			}
		},

		_onEditorClick: function (event) {
			this._checkForTrigger(0);
		},

		_onEditorKeyDown: function (e) {
			var keys = KEY, // store in local var for faster lookup
				selection = utils.getCaretPosition(this.elEditor),
				sStart = selection.start,
				sEnd = selection.end,
				plain_text = this.elEditor.val();

			this.editorSelectionLength = sEnd - sStart;
			this.editorTextLength = plain_text.length;
			this.editorKeyCode = e.keyCode;

			switch (e.keyCode) {
				case keys.UP:
				case keys.DOWN:
					if (!this.elTagList.is(':visible')) {
						return true;
					}

					var elCurrentTagListItem = null;
					if (e.keyCode == keys.DOWN) {
						if (this.elTagListItemActive && this.elTagListItemActive.length) {
							this.elCurrentTagListItem = this.elTagListItemActive.next();
						} else {
							this.elCurrentTagListItem = this.elTagList.find('li').first();
						}
					} else {
						if (this.elTagListItemActive && this.elTagListItemActive.length) {
							this.elCurrentTagListItem = this.elTagListItemActive.prev();
						} else {
							this.elCurrentTagListItem = this.elTagList.find('li').last();
						}
					}

					this._selectTagListItem(this.elCurrentTagListItem,
											this.options.triggers[this.currentTriggerChar].classes.tagActiveDropDown);
					return false;

				case keys.RETURN:
				case keys.TAB:
					if (this.elTagListItemActive && this.elTagListItemActive.length) {
						this.editorAddingTag = true;
						this.elTagListItemActive.trigger('mousedown');
						return false;
					}
					return true;

				case keys.BACKSPACE:
				case keys['DELETE']:
					if (e.keyCode == keys.BACKSPACE && sStart == sEnd && sStart > 0) {
						sStart -= 1;
					}
					if (e.keyCode == keys['DELETE']) {
						sEnd += 1;
					}
					if(sEnd > sStart) {
						this._removeTagsInRange(sStart, sEnd);
						this._shiftTagsPosition(sStart, sStart - sEnd);
					}
					return true;

				case keys.LEFT:
				case keys.RIGHT:
				case keys.HOME:
				case keys.END:
					this._delay(this._checkForTrigger);
					break;

				case keys.V:
					// checking for paste
					if (e.ctrlKey) {
						this.editorInPasteMode = true;
						this.editorPasteStartPosition = sStart;
						this.editorPasteCutCharacters = sEnd - sStart;
						this._removeTagsInRange(sStart, sEnd);
					}
					break;

				case keys.Z:
					if (e.ctrlKey) {
						// forbid undo
						return false;
					}
					break;
			}

			return true;
		},

		_onEditorKeyPress: function (e) {
			if (e.keyCode == KEY.RETURN) {
				this._updateBeautifier();
			}
			if (this.editorAddingTag) {
				if (e.keyCode == KEY.RETURN || e.keyCode == KEY.TAB) {
					e.preventDefault();
				}
				this.editorAddingTag = false;
			}
		},

		_onEditorKeyUp: function (e) {
			if (this.editorInPasteMode) {
				this.editorInPasteMode = false;

				if (this.editorSelectionLength > 0) {
					return;
				}

				var selection = utils.getCaretPosition(this.elEditor),
					sStart = selection.start,
					sEnd = selection.end;

				this._shiftTagsPosition(this.editorPasteStartPosition,
										sEnd - this.editorPasteStartPosition - this.editorPasteCutCharacters);
				this._updateBeautifier();
			}
		},

		_onEditorInput: function (e) {
			if (this.editorKeyCode != KEY.BACKSPACE && this.editorKeyCode != KEY['DELETE']) {
				if (this.editorSelectionLength > 0) {
					// delete of selection occured
					var selection = utils.getCaretPosition(this.elEditor),
						sStart = selection.start,
						selectionLength = this.editorSelectionLength,
						sEnd = sStart + selectionLength,
						tags_shift_positions = this.elEditor.val().length - this.editorTextLength;
					this._removeTagsInRange(sStart, sEnd);
					this._shiftTagsPosition(sEnd, tags_shift_positions);
				} else if (!this.editorInPasteMode) {
					// char input - shift with 1
					var selection = utils.getCaretPosition(this.elEditor),
						sStart = selection.start,
						sEnd = selection.end,
						selectionLength = sEnd - sStart;

					if (this.editorKeyCode == KEY.RETURN) {
						this._shiftTagsPosition(sStart - 1, 1);
						this._removeTagsInRange(sStart, sStart);
					} else {
						this._shiftTagsPosition(sStart, 1);
						this._removeTagsInRange(sStart, sStart + 1);
					}
				}
			}

			this._updateBeautifier();

			this._checkForTrigger(1);
		},

		_onEditorBlur: function (e) {
			this._delay(this._hideTagList, 100);
		},

		_hideTagList: function () {
			this.elTagListItemActive = null;
			this.elTagList.hide().empty();
		},

		_removeTagsInRange: function (start, end) {
			var removedTags = [];
			this.tagsCollection = _.filter(this.tagsCollection, function (tagPos) {
				var s = tagPos[0], e = s + tagPos[1],
					inRange = ((s >= start && s < end) || (e > start && e <= end) || (s < start && e > end));
				if (inRange) {
					removedTags.push(tagPos[3]);
				}
				return !inRange;
			});

			if (removedTags.length > 0) {
				this._trigger('tagsRemoved', null, [removedTags]); // FIXME: ??
			}
		},

		_shiftTagsPosition: function (afterPosition, position_shift) {
			// FIXME: _.each(...) instead?
			this.tagsCollection = _.map(this.tagsCollection, function (tagPos) {
				if (tagPos[0] >= afterPosition) {
					tagPos[0] += position_shift;
				}
				return tagPos;
			});
		},

		_addTag: function (tag) {
			var trigger = this.options.triggers[this.currentTriggerChar],
				objPropTransformer = transformObjectProperties(trigger.keys_map),
				localTag = objPropTransformer(tag, false),
				plain_text = this._getEditorValue(),
				sStart = utils.getCaretPosition(this.elEditor).start,
				tagStart = sStart - this.currentTriggerChar.length - this.currentDataQuery.length,
				newCaretPosition = tagStart + localTag.title.length,
				left_text = plain_text.substr(0, tagStart),
				right_text = plain_text.substr(sStart),
				new_text = left_text + localTag.title + right_text;

			// shift the tags after the current new one
			this._shiftTagsPosition(sStart, newCaretPosition - sStart);

			// explicitly convert to string for comparisons later
			tag[trigger.keys_map.id] = '' + tag[trigger.keys_map.id];

			this.tagsCollection.push([tagStart, localTag.title.length, this.currentTriggerChar, tag]);
			this.tagsCollection = _.sortBy(this.tagsCollection, function (t) { return t[0]; });

			this.currentTriggerChar = '';
			this.currentDataQuery = '';
			this._hideTagList();

			this.elEditor.val(new_text);
			this._updateBeautifier();

			this.elEditor.focus();
			utils.setCaretPosition(this.elEditor, newCaretPosition);

			this._trigger('tagsAdded', null, [[tag]]); // FIXME: ??
		},

		_selectTagListItem: function (tagItem, class_name) {
			if (tagItem && tagItem.length) {
				tagItem.addClass(class_name);
				tagItem.siblings().removeClass(class_name);
				this.elTagListItemActive = tagItem;
			} else {
				this.elTagListItemActive.removeClass(class_name);
				this.elTagListItemActive = null;
			}
		},

		_populateTagList: function (query, triggerChar, results) {
			var trigger = this.options.triggers[triggerChar],
				templates = this.options.templates;

			this._updateBeautifier();

			if (trigger.uniqueTags) {
				// Filter items that has already been mentioned
				var id_key = trigger.keys_map.id,
					tagIds = _.map(this.tagsCollection, function (tagPos) { return tagPos[3][id_key]; });
				results = _.reject(results, function (item) {
					// converting to string ids
					return _.include(tagIds, '' + item[id_key]);
				});
			}

			if (!results.length) {
				return;
			}

			var tagsDropDown = $("<ul />").addClass(trigger.classes.tagsDropDown).appendTo(this.elTagList),
				imgOrIconTpl = trigger.showImageOrIcon ?  templates.tagsListItemImage : templates.tagsListItemIcon,
				objPropTransformer = transformObjectProperties(trigger.keys_map),
				instance = this;

			_.each(results, function (tag, index) {
				var tagItem, localTag = objPropTransformer(tag, false);
				localTag.title = utils.highlightTerm(utils.htmlEncode(localTag.title), query);
				tagItem = $(templates.tagsListItem(localTag)).data('tag', tag);
				if (localTag.img) {
					tagItem = tagItem.prepend(imgOrIconTpl(localTag));
				}
				tagItem.appendTo(tagsDropDown);

				if (index === 0) {
					instance._selectTagListItem(tagItem, trigger.classes.tagActiveDropDown);
				}
			});

			this.elTagList.show();
			this.elTagList.position({
				my: 'left top', at: 'left bottom+2', of: this.elBeautifier.find('span.textntags-caret-position')
			});
		},

		_searchTags: function () {
			var instance = this,
				query = this.currentDataQuery,
				triggerChar = this.currentTriggerChar;

			this._hideTagList();
			this.options.onDataRequest.call(
				this, 'search', query, triggerChar,
				function (responseData) {
					instance._populateTagList(query, triggerChar, responseData);
				}
			);
		},

		/***** PUBLIC *****/

		value: function (newValue) {
			if (_.isString(newValue)) {
				var removedTags = _.uniq(_.map(this.tagsCollection, function (tagPos) { return tagPos[3]; }));
				this._trigger('tagsRemoved', null, [removedTags]); // FIXME: ??
				this.elEditor.val(newValue);
				this._initState();
				return;
			} else {
				return this.tagsCollection.length ? this._getTaggedText() : this._getEditorValue();
			}
		},

		getTags: function () {
			var tags = _.map(this.tagsCollection, function (tagPos) { return tagPos[3]; });

			return _.uniq(tags);
		},

		getTagsMap: function () {
			return this.tagsCollection;
		},

		getTagsMapFacebook: function () {
			var fbTagsCollection = {}, triggers = this.options.triggers;

			_.each(this.tagsCollection, function (tagPos) {
				var objPropTransformer = transformObjectProperties(triggers[tagPos[2]].keys_map),
					localTag = objPropTransformer(tagPos[3], false);
				fbTagsCollection[tagPos[0]] = [{
					id: localTag.id,
					name: localTag.title,
					type: localTag.type,
					offset: tagPos[0],
					length: tagPos[1]
				}];
			});

			return fbTagsCollection;
		},

		parseTaggedText: function (tagged_text) {
			if (_.isString(tagged_text) == false) {
				return null;
			}
			var plain_text = '' + tagged_text, tagsColl = [], triggers = this.options.triggers;

			_.each(triggers, function (opts, tchar) {
				var parts = tagged_text.split(opts.parser),
					idx = 0, pos = 0, len = parts.length,
					found_tag, found_len, part_len,
					max_group = _.max(opts.parserGroups);

				while (idx < len) {
					if (parts[idx] == tchar) {
						found_tag = {};
						_.each(opts.parserGroups, function (v, k) {
							found_tag[opts.keys_map[k]] = parts[idx + v - 1];
							if (k == 'title') {
								found_len = parts[idx + v - 1].length;
							}
						});
						tagsColl.push([pos, found_len, tchar, found_tag]);
						part_len = found_len;
						idx += max_group;
					} else {
						part_len = parts[idx].length;
						idx += 1;
					}
					pos += part_len;
				}
			});

			tagsColl = _.sortBy(tagsColl, function (tagPos) { return tagPos[0]; });

			_.each(triggers, function (opts, tchar) {
				plain_text = plain_text.replace(opts.parser, '$' + opts.parserGroups.title);
			});

			return {
				plain_text: plain_text,
				tagged_text: tagged_text,
				tagsCollection: tagsColl
			};
		}
	});

})(jQuery, _);
