(function () {
  'use strict';

  // --- Mobile navigation --------------------------------------------
  var navOpenBtn = document.getElementById('nav-open');
  var navCloseBtn = document.getElementById('nav-close');
  var mobileNav = document.getElementById('mobile-nav');

  function openNav() {
    if (!mobileNav) return;
    mobileNav.classList.add('is-open');
    navOpenBtn && navOpenBtn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }

  function closeNav() {
    if (!mobileNav) return;
    mobileNav.classList.remove('is-open');
    navOpenBtn && navOpenBtn.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  navOpenBtn && navOpenBtn.addEventListener('click', openNav);
  navCloseBtn && navCloseBtn.addEventListener('click', closeNav);
  document.querySelectorAll('[data-nav-close]').forEach(function (el) {
    el.addEventListener('click', closeNav);
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeNav();
  });

  // --- Sticky header shadow on scroll --------------------------------
  var header = document.getElementById('site-header');
  var backToTop = document.getElementById('back-to-top');

  function onScroll() {
    var y = window.scrollY || window.pageYOffset;
    if (header) header.classList.toggle('is-scrolled', y > 10);
    if (backToTop) backToTop.classList.toggle('is-visible', y > 500);
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  backToTop && backToTop.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  // --- Scroll reveal ---------------------------------------------------
  var revealEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window && revealEls.length) {
    var io = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            io.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('is-visible'); });
  }

  // --- Gallery filter ---------------------------------------------------
  var filterBtns = document.querySelectorAll('.gallery-filter__btn');
  var galleryItems = document.querySelectorAll('.gallery-grid__item');

  filterBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      filterBtns.forEach(function (b) { b.classList.remove('is-active'); });
      btn.classList.add('is-active');
      var filter = btn.getAttribute('data-filter');

      galleryItems.forEach(function (item) {
        var match = filter === 'all' || item.getAttribute('data-category') === filter;
        item.classList.toggle('is-hidden', !match);
      });
    });
  });

  // --- Lightbox ---------------------------------------------------
  var lightbox = document.getElementById('lightbox');
  var lightboxImg = document.getElementById('lightbox-img');
  var lightboxCaption = document.getElementById('lightbox-caption');
  var lightboxClose = document.getElementById('lightbox-close');
  var lightboxPrev = document.getElementById('lightbox-prev');
  var lightboxNext = document.getElementById('lightbox-next');
  var lightboxLinks = Array.prototype.slice.call(document.querySelectorAll('[data-lightbox]'));
  var currentIndex = 0;

  function visibleLinks() {
    return lightboxLinks.filter(function (link) {
      var parent = link.closest('.gallery-grid__item');
      return !parent || !parent.classList.contains('is-hidden');
    });
  }

  function showLightbox(index) {
    var links = visibleLinks();
    if (!links.length || !lightbox) return;
    currentIndex = (index + links.length) % links.length;
    var link = links[currentIndex];
    lightboxImg.src = link.getAttribute('href');
    lightboxImg.alt = link.getAttribute('data-caption') || '';
    lightboxCaption.textContent = link.getAttribute('data-caption') || '';
    lightbox.classList.add('is-open');
    lightbox.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    if (!lightbox) return;
    lightbox.classList.remove('is-open');
    lightbox.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  lightboxLinks.forEach(function (link) {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      var links = visibleLinks();
      var index = links.indexOf(link);
      showLightbox(index === -1 ? 0 : index);
    });
  });

  lightboxClose && lightboxClose.addEventListener('click', closeLightbox);
  lightbox && lightbox.addEventListener('click', function (e) {
    if (e.target === lightbox) closeLightbox();
  });
  lightboxPrev && lightboxPrev.addEventListener('click', function () { showLightbox(currentIndex - 1); });
  lightboxNext && lightboxNext.addEventListener('click', function () { showLightbox(currentIndex + 1); });

  document.addEventListener('keydown', function (e) {
    if (!lightbox || !lightbox.classList.contains('is-open')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') showLightbox(currentIndex - 1);
    if (e.key === 'ArrowRight') showLightbox(currentIndex + 1);
  });
})();
