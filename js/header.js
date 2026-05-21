( function () {
	'use strict';

	const header    = document.getElementById( 'farbest-header' );
	const hamburger = document.querySelector( '.farbest-header__hamburger' );
	const drawer    = document.getElementById( 'farbest-mobile-menu' );
	const closeBtn  = document.querySelector( '.farbest-mobile-menu__close' );
	const overlay   = document.getElementById( 'farbest-mobile-overlay' );

	if ( ! header ) return;

	/* ── Clone desktop nav into mobile drawer ──────────────── */
	const desktopNav = document.querySelector( '.farbest-header__nav' );
	const mobileNav  = document.querySelector( '.farbest-mobile-menu__nav' );

	if ( desktopNav && mobileNav ) {
		mobileNav.innerHTML = desktopNav.innerHTML;
	}

	/* ── Set header height CSS var & apply box-shadow on scroll ── */
	const headerHeight = header.offsetHeight;
	document.documentElement.style.setProperty( '--farbest-header-height', headerHeight + 'px' );

	let ticking = false;

	window.addEventListener( 'scroll', function () {
		if ( ! ticking ) {
			window.requestAnimationFrame( function () {
				if ( window.scrollY > 10 ) {
					header.classList.add( 'is-sticky' );
				} else {
					header.classList.remove( 'is-sticky' );
				}
				ticking = false;
			} );
			ticking = true;
		}
	} );

	/* ── Mobile drawer ─────────────────────────────────────── */
	function openDrawer() {
		drawer.classList.add( 'is-open' );
		overlay.classList.add( 'is-visible' );
		drawer.setAttribute( 'aria-hidden', 'false' );
		hamburger.setAttribute( 'aria-expanded', 'true' );
		document.body.style.overflow = 'hidden';
		closeBtn.focus();
	}

	function closeDrawer() {
		drawer.classList.remove( 'is-open' );
		overlay.classList.remove( 'is-visible' );
		drawer.setAttribute( 'aria-hidden', 'true' );
		hamburger.setAttribute( 'aria-expanded', 'false' );
		document.body.style.overflow = '';
		hamburger.focus();
	}

	if ( hamburger ) hamburger.addEventListener( 'click', openDrawer );
	if ( closeBtn )  closeBtn.addEventListener( 'click', closeDrawer );
	if ( overlay )   overlay.addEventListener( 'click', closeDrawer );

	/* Close on Escape key */
	document.addEventListener( 'keydown', function ( e ) {
		if ( e.key === 'Escape' && drawer.classList.contains( 'is-open' ) ) {
			closeDrawer();
		}
	} );

} )();
