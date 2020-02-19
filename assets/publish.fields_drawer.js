(function ($) {

	'use strict';

	var SLIDE_DELAY = 0;

	var sels = {
		sidebar: 'fieldset.secondary.column',
		hook: '.js-fields-drawer-hook',
		ctn: '.js-fields-drawer',
		trigger: '.js-fields-drawer-trigger',
		fieldsCtn: '.js-fields-drawer-fields-ctn'
	};

	var classes = {
		ctn: 'fields-drawer-ctn',
		fields: 'fields-drawer-fields-ctn',
		trigger: 'fields-drawer-trigger'
	};

	var onTriggerClick = function () {
		var t = $(this);
		var ctn = t.closest(sels.ctn);
		var fields = ctn.find(sels.fieldsCtn);

		if (ctn.hasClass('is-opened')) {
			fields.slideUp(SLIDE_DELAY);
			ctn.addClass('is-closed').removeClass('is-opened');
		} else {
			fields.slideDown(SLIDE_DELAY);
			ctn.addClass('is-opened').removeClass('is-closed');
		}

	};

	var isClosed = function (element) {
		return element.attr('data-open') === 'no';
	};

	var moveFields = function () {
		var t = $(this);
		var fieldsCtn = t.find(sels.fieldsCtn);
		var fields = t.nextUntil(sels.ctn);
		fields.detach().appendTo(fieldsCtn);
	};

	var generateDrawer = function () {
		var t = $(this);
		var name = t.attr('data-name');

		var ctn = $('<div />')
					.addClass(sels.ctn.replace('.',''))
					.addClass(classes.ctn);

		var trigger = $('<div />').text(name)
						.addClass(sels.trigger.replace('.',''))
						.addClass(classes.trigger);

		var fieldsCtn = $('<div />')
						.addClass(sels.fieldsCtn.replace('.',''))
						.addClass(classes.fields);

		ctn.addClass(!!isClosed(t) ? 'is-closed' : 'is-opened');

		ctn.append(trigger).append(fieldsCtn);
		ctn.insertAfter(t);
		t.remove();
	};

	var init = function () {
		var scope = window.Symphony.Elements.contents;
		var hooks = scope.find(sels.hook);
		// Set the page as drawer activated for CSS adjustments
		if (!!hooks.length) {
			window.Symphony.Elements.body.addClass('has-drawers');
		}

		hooks.each(generateDrawer);
		scope.find(sels.ctn).each(moveFields);

		scope.find(sels.ctn + '.is-closed').each(function () {
			$(this).find(sels.fieldsCtn).hide();
		});

		scope.on('click', sels.trigger, onTriggerClick);
	};

	$(init);


})(jQuery);
