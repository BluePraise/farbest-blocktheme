(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		var cards = document.querySelectorAll('.grid-card');

		cards.forEach(function (card) {
			card.addEventListener('click', function (e) {
				if (e.target.closest('.card-contact-link')) return;

				var isOpen = card.classList.contains('is-open');
				cards.forEach(function (c) { c.classList.remove('is-open'); });
				if (!isOpen) card.classList.add('is-open');
			});
		});

		document.addEventListener('click', function (e) {
			if (!e.target.closest('.grid-card')) {
				cards.forEach(function (c) { c.classList.remove('is-open'); });
			}
		});
	});
}());
