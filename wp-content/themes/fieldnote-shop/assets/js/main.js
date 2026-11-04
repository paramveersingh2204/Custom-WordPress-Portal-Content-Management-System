/**
 * Fieldnote Shop — progressive enhancement.
 * Without JS the menu is fully visible and submenus open on focus-within.
 */
(function () {
	'use strict';

	var toggle = document.querySelector('.menu-toggle');
	var navWrap = document.getElementById('primary-menu-wrap');
	var status = document.getElementById('fns-status');
	var desktop = window.matchMedia('(min-width: 48em)');

	/* ---- Mobile menu ------------------------------------------------- */
	function setMenu(open) {
		if (!toggle || !navWrap) { return; }
		toggle.setAttribute('aria-expanded', String(open));
		navWrap.classList.toggle('is-open', open);
	}

	if (toggle && navWrap) {
		toggle.addEventListener('click', function () {
			setMenu(toggle.getAttribute('aria-expanded') !== 'true');
		});
		desktop.addEventListener('change', function () { setMenu(false); });
	}

	/* ---- Submenus: a real button per parent, not hover-only --------------- */
	var parents = document.querySelectorAll('#primary-menu .menu-item-has-children');

	function closeSub(li, returnFocus) {
		var btn = li.querySelector(':scope > .submenu-toggle');
		li.classList.remove('is-open');
		if (btn) {
			btn.setAttribute('aria-expanded', 'false');
			if (returnFocus) { btn.focus(); }
		}
	}

	parents.forEach(function (li, i) {
		var link = li.querySelector(':scope > a');
		var sub = li.querySelector(':scope > .sub-menu');
		if (!link || !sub) { return; }

		sub.id = sub.id || 'submenu-' + i;

		var btn = document.createElement('button');
		btn.type = 'button';
		btn.className = 'submenu-toggle';
		btn.setAttribute('aria-expanded', 'false');
		btn.setAttribute('aria-controls', sub.id);
		btn.setAttribute('aria-label', 'Submenu for ' + link.textContent.trim());
		link.after(btn);

		btn.addEventListener('click', function () {
			var open = li.classList.toggle('is-open');
			btn.setAttribute('aria-expanded', String(open));
		});

		li.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && li.classList.contains('is-open')) {
				e.stopPropagation();
				closeSub(li, true);
			}
		});

		li.addEventListener('focusout', function (e) {
			if (e.relatedTarget && !li.contains(e.relatedTarget)) { closeSub(li, false); }
		});
	});

	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && toggle && toggle.getAttribute('aria-expanded') === 'true' && !desktop.matches) {
			setMenu(false);
			toggle.focus();
		}
	});

	document.addEventListener('click', function (e) {
		parents.forEach(function (li) {
			if (!li.contains(e.target)) { closeSub(li, false); }
		});
	});

	/* ---- Live-region announcements for cart changes (WCAG 4.1.3) ------------- */
	function announce(message) {
		if (!status) { return; }
		status.textContent = '';
		window.setTimeout(function () { status.textContent = message; }, 60);
	}

	if (window.jQuery) {
		window.jQuery(document.body)
			.on('added_to_cart', function () { announce('Item added to your cart.'); })
			.on('removed_from_cart', function () { announce('Item removed from your cart.'); })
			.on('updated_cart_totals', function () { announce('Cart updated.'); });
	}
})();
