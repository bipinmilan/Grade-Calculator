/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
(function(){
  "use strict";
  const burger = document.getElementById('burger');
  const navLinks = document.getElementById('navLinks');

  burger.addEventListener('click', () => navLinks.classList.toggle('open'));

  // Close the mobile menu after tapping a normal (non-parent) link
  navLinks.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
      if (!link.closest('li').classList.contains('has-submenu')){
        navLinks.classList.remove('open');
      }
    });
  });

  // Submenu toggle (mobile tap, or keyboard on desktop)
  navLinks.querySelectorAll('.submenu-toggle').forEach(btn => {
    btn.addEventListener('click', function(e){
      e.preventDefault();
      const li = btn.closest('li');
      const isOpen = li.classList.toggle('submenu-open');
      btn.setAttribute('aria-expanded', isOpen);
    });
  });
})();