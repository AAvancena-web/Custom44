/**
 * Custom 44 theme scripts. Vanilla JS, no dependencies.
 */
(function () {
  'use strict';

  var doc = document.documentElement;
  doc.classList.remove('no-js');
  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* Header state + scroll progress ------------------------------------- */
  var header = document.getElementById('site-header');
  var progress = document.querySelector('.scroll-progress');
  var toTop = document.querySelector('.to-top');
  var toTopRing = toTop ? toTop.querySelector('.to-top__bar') : null;
  if (toTop) toTop.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' }); });
  var ticking = false;
  function onScroll() {
    var y = window.scrollY || window.pageYOffset;
    if (header) header.classList.toggle('is-scrolled', y > 10);
    var max = document.documentElement.scrollHeight - window.innerHeight;
    var ratio = max > 0 ? Math.min(y / max, 1) : 0;
    if (progress) progress.style.transform = 'scaleX(' + ratio + ')';
    if (toTop) {
      toTop.classList.toggle('is-visible', y > 600);
      if (toTopRing) toTopRing.style.strokeDashoffset = (188.5 * (1 - ratio)).toFixed(1);
    }
    parallax();
    ticking = false;
  }
  window.addEventListener('scroll', function () {
    if (!ticking) { window.requestAnimationFrame(onScroll); ticking = true; }
  }, { passive: true });

  /* Parallax images ------------------------------------------------------ */
  var parallaxEls = reduceMotion ? [] : Array.prototype.slice.call(document.querySelectorAll('[data-parallax]'));
  function parallax() {
    var vh = window.innerHeight;
    parallaxEls.forEach(function (el) {
      var wrap = el.closest('[data-parallax-wrap]') || el.parentElement;
      var rect = wrap.getBoundingClientRect();
      if (rect.bottom < 0 || rect.top > vh) return;
      var speed = parseFloat(el.getAttribute('data-parallax')) || 0.1;
      var offset = (rect.top + rect.height / 2 - vh / 2) * speed;
      el.style.transform = 'translate3d(0,' + (-offset).toFixed(1) + 'px,0) scale(1.1)';
    });
  }
  onScroll();

  /* Mobile drawer ------------------------------------------------------- */
  var drawer = document.getElementById('mobile-drawer');
  var drawerOverlay = document.querySelector('.drawer-overlay[data-drawer-close]');
  var drawerToggle = document.querySelector('[data-drawer-toggle]');
  function setDrawer(open) {
    if (!drawer) return;
    drawer.classList.toggle('is-open', open);
    if (drawerOverlay) drawerOverlay.classList.toggle('is-open', open);
    drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
    if (drawerToggle) drawerToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    document.body.style.overflow = open ? 'hidden' : '';
    if (open) { var f = drawer.querySelector('a, button'); if (f) f.focus(); }
  }
  if (drawerToggle) drawerToggle.addEventListener('click', function () { setDrawer(!drawer.classList.contains('is-open')); });
  document.querySelectorAll('[data-drawer-close]').forEach(function (el) {
    el.addEventListener('click', function () { setDrawer(false); });
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { setDrawer(false); setSearch(false); setFilters(false); }
  });

  // Sub menu toggles inside the drawer.
  document.querySelectorAll('.mobile-nav .menu-item-has-children').forEach(function (li) {
    var btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'submenu-toggle';
    btn.setAttribute('aria-expanded', 'false');
    btn.setAttribute('aria-label', 'Show sub menu');
    btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>';
    li.insertBefore(btn, li.querySelector('.sub-menu'));
    btn.addEventListener('click', function () {
      var open = li.classList.toggle('is-open');
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  });

  /* Search panel -------------------------------------------------------- */
  var searchToggle = document.querySelector('[data-search-toggle]');
  var searchPanel = document.getElementById('search-panel');
  function setSearch(open) {
    if (!searchPanel) return;
    searchPanel.classList.toggle('is-open', open);
    if (searchToggle) searchToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    if (open) { var i = searchPanel.querySelector('input[type="search"]'); if (i) setTimeout(function () { i.focus(); }, 50); }
  }
  if (searchToggle) searchToggle.addEventListener('click', function () { setSearch(!searchPanel.classList.contains('is-open')); });

  /* Shop filter drawer -------------------------------------------------- */
  var sidebar = document.getElementById('shop-sidebar');
  var filterOverlay = document.querySelector('.drawer-overlay[data-filter-close]');
  var filterToggle = document.querySelector('[data-filter-toggle]');
  function setFilters(open) {
    if (!sidebar) return;
    sidebar.classList.toggle('is-open', open);
    if (filterOverlay) filterOverlay.classList.toggle('is-open', open);
    if (filterToggle) filterToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    document.body.style.overflow = open ? 'hidden' : '';
  }
  if (filterToggle) filterToggle.addEventListener('click', function () { setFilters(true); });
  document.querySelectorAll('[data-filter-close]').forEach(function (el) {
    el.addEventListener('click', function () { setFilters(false); });
  });

  /* Reveal on scroll (banner content is never hidden) ------------------- */
  var revealEls = document.querySelectorAll('.reveal, [data-observe]');
  if ('IntersectionObserver' in window && !reduceMotion) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.14, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('is-visible'); });
  }

  /* Counters ------------------------------------------------------------ */
  var counters = document.querySelectorAll('[data-count]');
  function runCounter(el) {
    var target = parseFloat(el.getAttribute('data-count')) || 0;
    var decimals = parseInt(el.getAttribute('data-decimals') || '0', 10);
    var fmt = function (v) {
      return decimals ? v.toFixed(decimals) : Math.round(v).toLocaleString('en-AU');
    };
    if (reduceMotion) { el.textContent = fmt(target); return; }
    var start = null, dur = 1800;
    function step(ts) {
      if (!start) start = ts;
      var p = Math.min((ts - start) / dur, 1);
      var eased = 1 - Math.pow(1 - p, 4);
      el.textContent = fmt(target * eased);
      if (p < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }
  if ('IntersectionObserver' in window) {
    var cio = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) { runCounter(entry.target); cio.unobserve(entry.target); }
      });
    }, { threshold: 0.5 });
    counters.forEach(function (el) { cio.observe(el); });
  } else {
    counters.forEach(runCounter);
  }

  /* Carousel ------------------------------------------------------------ */
  document.querySelectorAll('[data-carousel]').forEach(function (carousel) {
    var track = carousel.querySelector('.carousel__track');
    var section = carousel.closest('section') || document;
    var prev = section.querySelector('[data-carousel-prev]');
    var next = section.querySelector('[data-carousel-next]');
    var bar = carousel.querySelector('[data-carousel-bar]');
    if (!track) return;
    function page() { return track.clientWidth * 0.9; }
    function update() {
      var max = track.scrollWidth - track.clientWidth;
      if (prev) prev.disabled = track.scrollLeft <= 4;
      if (next) next.disabled = track.scrollLeft >= max - 4;
      if (bar) {
        var ratio = track.clientWidth / track.scrollWidth;
        bar.style.width = Math.max(ratio * 100, 10) + '%';
        bar.style.transform = 'translateX(' + (max > 0 ? (track.scrollLeft / max) * ((1 / Math.max(ratio, 0.1)) - 1) * 100 : 0) + '%)';
      }
    }
    if (prev) prev.addEventListener('click', function () { track.scrollBy({ left: -page(), behavior: 'smooth' }); });
    if (next) next.addEventListener('click', function () { track.scrollBy({ left: page(), behavior: 'smooth' }); });
    track.addEventListener('scroll', function () { requestAnimationFrame(update); }, { passive: true });
    window.addEventListener('resize', update);
    update();
  });

  /* Spotlight hover on service cards ---------------------------------- */
  document.querySelectorAll('[data-spotlight]').forEach(function (card) {
    card.addEventListener('pointermove', function (e) {
      var r = card.getBoundingClientRect();
      card.style.setProperty('--mx', (e.clientX - r.left) + 'px');
      card.style.setProperty('--my', (e.clientY - r.top) + 'px');
    });
  });

  /* FAQ: only one open at a time --------------------------------------- */
  var faqs = document.querySelectorAll('.faq details');
  faqs.forEach(function (d) {
    d.addEventListener('toggle', function () {
      if (d.open) faqs.forEach(function (o) { if (o !== d) o.open = false; });
    });
  });

  /* Product page: highlight active bulk tier from quantity inputs ------ */
  var tiers = document.querySelector('[data-tiers]');
  if (tiers) {
    var cells = tiers.querySelectorAll('[data-min]');
    var form = document.querySelector('form.cart');
    var calc = function () {
      if (!form) return;
      var total = 0;
      form.querySelectorAll('input[type="number"], input.qty').forEach(function (i) {
        total += parseInt(i.value, 10) || 0;
      });
      var active = null;
      cells.forEach(function (c) {
        c.classList.remove('is-active');
        if (total >= parseInt(c.getAttribute('data-min'), 10)) active = c;
      });
      if (active) active.classList.add('is-active');
    };
    if (form) {
      form.addEventListener('input', calc);
      form.addEventListener('change', calc);
      calc();
    }
  }
})();
