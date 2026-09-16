(function () {
  'use strict';

  var STORAGE_KEY = 'klimaturiec_cookie_consent';
  var banner = document.getElementById('cookie-banner');
  var fab = document.getElementById('cookie-fab');
  if (!banner) return;

  function getConsent() {
    try {
      return localStorage.getItem(STORAGE_KEY);
    } catch (e) {
      return null;
    }
  }

  function setConsent(value) {
    try {
      localStorage.setItem(STORAGE_KEY, value);
    } catch (e) {
      // localStorage nedostupný (súkromné okno a pod.) - lišta sa zobrazí nabudúce znova, nie je to kritické
    }
  }

  function showFab() {
    if (fab) fab.classList.add('is-visible');
  }

  function hideFab() {
    if (fab) fab.classList.remove('is-visible');
  }

  function showBanner() {
    hideFab();
    banner.hidden = false;
    // malé oneskorenie, aby prehliadač stihol aplikovať počiatočný stav pred animáciou
    window.requestAnimationFrame(function () {
      banner.classList.add('is-visible');
    });
  }

  function hideBanner() {
    banner.classList.remove('is-visible');
    window.setTimeout(function () {
      banner.hidden = true;
    }, 350);
    showFab();
  }

  // Malé okrúhle tlačidlo (cookie-fab) ostáva natrvalo viditeľné po tom, čo používateľ
  // raz rozhodol (prijal alebo odmietol) - je to jeho trvalý prístup k opätovnému nastaveniu.
  if (getConsent()) {
    showFab();
  } else {
    showBanner();
  }

  var acceptBtn = document.getElementById('cookie-accept');
  var rejectBtn = document.getElementById('cookie-reject');

  if (acceptBtn) {
    acceptBtn.addEventListener('click', function () {
      setConsent('all');
      hideBanner();
    });
  }
  if (rejectBtn) {
    rejectBtn.addEventListener('click', function () {
      setConsent('necessary');
      hideBanner();
    });
  }

  // Odkaz v pätičke aj okrúhle tlačidlo "Nastavenia cookies" - umožnia súhlas kedykoľvek zmeniť
  document.querySelectorAll('[data-cookie-settings]').forEach(function (el) {
    el.addEventListener('click', function (e) {
      e.preventDefault();
      showBanner();
    });
  });
})();
