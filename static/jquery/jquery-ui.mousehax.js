'use strict';

(function($) {

	var fix_zoom_event = function(e) {
		if (!e) return e;
		var zoom	= parseFloat($('#body').css('zoom')) || 1;
		e.pageX		= (e.pageX		- ((1 - zoom) * $(window).scrollLeft())) / zoom;
		e.pageY		= (e.pageY		- ((1 - zoom) * $(window).scrollTop( ))) / zoom;
		e.screenX	= (e.screenX	- ((1 - zoom) * $(window).scrollLeft())) / zoom;
		e.screenY	= (e.screenY	- ((1 - zoom) * $(window).scrollTop( ))) / zoom;
		e.clientX	= (e.clientX	- ((1 - zoom) * $(window).scrollLeft())) / zoom;
		e.clientY	= (e.clientY	- ((1 - zoom) * $(window).scrollTop( ))) / zoom;
		return e;
	};


	$.fn.touchMoveEnd = function(callback, timeout) {
		$(this).on('touchmove', function(){
			var that = $(this);
			if (that.data('touchMoveTimeout')) {
				clearTimeout(that.data('touchMoveTimeout'));
			}
			that.data('touchMoveTimeout', setTimeout(callback, timeout||250));
		});
	};


	$.fn.scrollEnd = function(callback, timeout) {
		$(this).scroll(function(){
			var that = $(this);
			if (that.data('scrollTimeout')) {
				clearTimeout(that.data('scrollTimeout'));
			}
			that.data('scrollTimeout', setTimeout(callback, timeout||250));
		});
	};


	$.ui.mouse.prototype._mouseCaptureHAX = $.ui.mouse.prototype._mouseCapture;
	$.ui.mouse.prototype._mouseCapture = function(e, p1, p2, p3, p4) {
		return this._mouseCaptureHAX(fix_zoom_event(e), p1, p2, p3, p4);
	};


	$.ui.mouse.prototype._mouseDelayMetHAX = $.ui.mouse.prototype._mouseDelayMet;
	$.ui.mouse.prototype._mouseDelayMet = function(e, p1, p2, p3, p4) {
		return this._mouseDelayMetHAX(fix_zoom_event(e), p1, p2, p3, p4);
	};


	$.ui.mouse.prototype._mouseDestroyHAX = $.ui.mouse.prototype._mouseDestroy;
	$.ui.mouse.prototype._mouseDestroy = function(e, p1, p2, p3, p4) {
		return this._mouseDestroyHAX(fix_zoom_event(e), p1, p2, p3, p4);
	};


	$.ui.mouse.prototype._mouseDistanceMetHAX = $.ui.mouse.prototype._mouseDistanceMet;
	$.ui.mouse.prototype._mouseDistanceMet = function(e, p1, p2, p3, p4) {
		return this._mouseDistanceMetHAX(fix_zoom_event(e), p1, p2, p3, p4);
	};

/*
	$.ui.mouse.prototype._mouseDownHAX = $.ui.mouse.prototype._mouseDown;
	$.ui.mouse.prototype._mouseDown = function(e, p1, p2, p3, p4) {
		return this._mouseDownHAX(fix_zoom_event(e), p1, p2, p3, p4);
	}
*/

	$.ui.mouse.prototype._mouseDragHAX = $.ui.mouse.prototype._mouseDrag;
	$.ui.mouse.prototype._mouseDrag = function(e, p1, p2, p3, p4) {
		return this._mouseDragHAX(fix_zoom_event(e), p1, p2, p3, p4);
	};


	$.ui.mouse.prototype._mouseInitHAX = $.ui.mouse.prototype._mouseInit;
	$.ui.mouse.prototype._mouseInit = function(e, p1, p2, p3, p4) {
		return this._mouseInitHAX(fix_zoom_event(e), p1, p2, p3, p4);
	};


	$.ui.mouse.prototype._mouseMoveHAX = $.ui.mouse.prototype._mouseMove;
	$.ui.mouse.prototype._mouseMove = function(e, p1, p2, p3, p4) {
		if (this.options.disabled) return;
		return this._mouseMoveHAX(fix_zoom_event(e), p1, p2, p3, p4);
	};


	$.ui.mouse.prototype._mouseStartHAX = $.ui.mouse.prototype._mouseStart;
	$.ui.mouse.prototype._mouseStart = function(e, p1, p2, p3, p4) {
		if (this.options.disabled) return;
		return this._mouseStartHAX(fix_zoom_event(e), p1, p2, p3, p4);
	};


	$.ui.mouse.prototype._mouseStopHAX = $.ui.mouse.prototype._mouseStop;
	$.ui.mouse.prototype._mouseStop = function(e, p1, p2, p3, p4) {
		if (this.options.disabled) return;
		return this._mouseStopHAX(fix_zoom_event(e), p1, p2, p3, p4);
	};


	$.ui.mouse.prototype._mouseUpHAX = $.ui.mouse.prototype._mouseUp;
	$.ui.mouse.prototype._mouseUp = function(e, p1, p2, p3, p4) {
		return this._mouseUpHAX(fix_zoom_event(e), p1, p2, p3, p4);
	};

})(jQuery);
