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

  /* Homepage: bulk savings calculator ---------------------------------- */
  var money = function (n) { return '$' + n.toLocaleString('en-AU', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); };
  document.querySelectorAll('[data-calc]').forEach(function (calc) {
    var range = calc.querySelector('input[type="range"]');
    var tierBtns = calc.querySelectorAll('[data-qty]');
    var qtyOut = calc.querySelector('[data-calc-qty]');
    var eachOut = calc.querySelector('[data-calc-each]');
    var noteOut = calc.querySelector('[data-calc-note]');
    var base = parseFloat(calc.getAttribute('data-base')) || 0;
    var print = parseFloat(calc.getAttribute('data-print')) || 0;
    if (!range) return;
    function update() {
      var qty = parseInt(range.value, 10) || 1;
      var off = 0, active = null;
      tierBtns.forEach(function (b) {
        b.classList.remove('is-active');
        if (qty >= parseInt(b.getAttribute('data-qty'), 10)) { active = b; off = parseInt(b.getAttribute('data-off'), 10); }
      });
      if (active) active.classList.add('is-active');
      var each = base * (1 - off / 100) + print;
      qtyOut.textContent = qty + (qty === 1 ? ' item' : ' items');
      eachOut.textContent = money(each);
      noteOut.textContent = off ? 'each, ' + off + '% off applied' : 'each, add ' + (parseInt(tierBtns[0].getAttribute('data-qty'), 10) - qty) + ' more for 15% off';
      var min = parseFloat(range.min) || 0, max = parseFloat(range.max) || 100;
      range.style.setProperty('--fill', ((qty - min) / (max - min) * 100) + '%');
    }
    range.addEventListener('input', update);
    tierBtns.forEach(function (b) {
      b.addEventListener('click', function () { range.value = b.getAttribute('data-qty'); update(); });
    });
    update();
  });

  /* Homepage: value pack size tabs ------------------------------------- */
  var packTabs = document.querySelectorAll('[data-pack-size]');
  packTabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      var size = tab.getAttribute('data-pack-size');
      packTabs.forEach(function (t) { var on = t === tab; t.classList.toggle('is-active', on); t.setAttribute('aria-selected', on ? 'true' : 'false'); });
      document.querySelectorAll('[data-packs] .pack-card').forEach(function (c) { c.hidden = c.getAttribute('data-size') !== size; });
    });
  });

  /* Category banner: "Read more" for the clamped description ----------- */
  document.querySelectorAll('[data-clamp]').forEach(function (desc) {
    var btn = desc.parentElement.querySelector('[data-clamp-toggle]');
    if (!btn) return;
    if (desc.scrollHeight > desc.clientHeight + 2) btn.hidden = false;
    btn.addEventListener('click', function () {
      var open = desc.classList.toggle('is-open');
      btn.textContent = open ? 'Read less' : 'Read more';
    });
  });

  /* Product page: size chart popup ------------------------------------ */
  var sizeChart = document.querySelector('[data-size-chart]');
  if (sizeChart) {
    if (sizeChart.parentNode !== document.body) document.body.appendChild(sizeChart);
    var openChart = function (e) {
      if (e) e.preventDefault();
      if (typeof sizeChart.showModal === 'function') sizeChart.showModal();
      else sizeChart.setAttribute('open', '');
    };
    var closeChart = function () {
      if (typeof sizeChart.close === 'function') sizeChart.close();
      else sizeChart.removeAttribute('open');
    };
    document.addEventListener('click', function (e) {
      if (e.target.closest('[data-size-chart-open]')) openChart(e);
      else if (e.target.closest('[data-size-chart-close]') || e.target === sizeChart) closeChart();
    });
    // "Size chart" link next to the sizes step of the configurator.
    var sizesLabel = document.querySelector('.c44-sizes');
    sizesLabel = sizesLabel && sizesLabel.parentNode.querySelector('.c44-opt__label');
    if (sizesLabel) {
      var link = document.createElement('button');
      link.type = 'button';
      link.className = 'c44-size-link';
      link.setAttribute('data-size-chart-open', '');
      link.textContent = 'Size chart';
      sizesLabel.appendChild(link);
    }
  }

  /* Product page: tiers, unlock progress and running totals ------------ */
  var form = document.querySelector('.pdp__summary form.cart') || document.querySelector('form.cart');
  var tiers = document.querySelector('[data-tiers]');
  var totals = document.querySelector('[data-totals]');
  var parseMoney = function (t) { var m = (t || '').replace(/,/g, '').match(/\$?\s*(\d+(?:\.\d+)?)/); return m ? parseFloat(m[1]) : 0; };

  // Put the totals box right above the add to quote button.
  if (totals && form) {
    var submit = form.querySelector('.single_add_to_cart_button, [type="submit"]');
    if (submit) {
      var anchor = submit.closest('.woocommerce-variation-add-to-cart') || submit;
      anchor.parentNode.insertBefore(totals, anchor);
    } else {
      form.appendChild(totals);
    }
  }

  function qtyInputs() {
    return form ? form.querySelectorAll('input[type="number"], input.qty') : [];
  }
  function tierFor(qty) {
    var found = { off: 0 };
    if (!tiers) return found;
    tiers.querySelectorAll('[data-min]').forEach(function (c) {
      var min = parseInt(c.getAttribute('data-min'), 10);
      if (qty >= min) found = { off: parseInt(c.getAttribute('data-off'), 10), el: c };
    });
    return found;
  }
  function updatePdp() {
    if (!form) return;
    var qty = 0, garment = 0;
    var base = totals ? parseFloat(totals.getAttribute('data-base')) || 0 : 0;
    qtyInputs().forEach(function (i) {
      var n = Math.max(parseInt(i.value, 10) || 0, 0);
      qty += n;
      var price = parseFloat(i.getAttribute('data-price'));
      if (isNaN(price)) {
        var lbl = i.closest('label');
        price = lbl && lbl.querySelector('small') ? parseMoney(lbl.querySelector('small').textContent) : base;
      }
      garment += n * price;
    });
    var prints = 0;
    form.querySelectorAll('input[type="checkbox"]:checked').forEach(function (c) {
      var p = parseFloat(c.getAttribute('data-price'));
      if (isNaN(p)) { var l = c.closest('label'); p = l && l.querySelector('small') ? parseMoney(l.querySelector('small').textContent) : 0; }
      prints += p;
    });
    var tier = tierFor(qty);

    if (tiers) {
      var cells = tiers.querySelectorAll('[data-min]');
      cells.forEach(function (c) { c.classList.toggle('is-active', c === tier.el); });
      var next = null;
      cells.forEach(function (c) { if (!next && qty < parseInt(c.getAttribute('data-min'), 10)) next = c; });
      var bar = tiers.querySelector('[data-tiers-bar]');
      var msg = tiers.querySelector('[data-tiers-msg]');
      var mins = Array.prototype.map.call(cells, function (c) { return parseInt(c.getAttribute('data-min'), 10); });
      // Progress: each tier owns an equal slice of the bar.
      var pct = 100;
      if (next) {
        var idx = mins.indexOf(parseInt(next.getAttribute('data-min'), 10));
        var lo = idx > 0 ? mins[idx - 1] : 0, hi = mins[idx];
        pct = ((idx + (qty - lo) / (hi - lo)) / mins.length) * 100;
      }
      if (bar) bar.style.width = Math.max(0, Math.min(pct, 100)) + '%';
      if (msg) {
        if (next) {
          var need = parseInt(next.getAttribute('data-min'), 10) - qty;
          msg.innerHTML = 'Add <b>' + need + ' more</b> to unlock <b>' + next.getAttribute('data-off') + '% off</b>';
        } else {
          msg.innerHTML = '<b>Top tier unlocked:</b> ' + tier.off + '% off every item';
        }
      }
    }

    if (totals) {
      var total = garment * (1 - tier.off / 100) + prints * qty;
      totals.querySelector('[data-total-qty]').textContent = qty;
      totals.querySelector('[data-total-price]').textContent = money(total);
      var note = totals.querySelector('[data-total-note]');
      if (note) {
        note.textContent = !qty ? 'Enter quantities to see your total. Bulk discount applied automatically.'
          : tier.off ? 'Includes ' + tier.off + '% bulk discount, you save ' + money(garment * tier.off / 100) + '.'
          : 'Add ' + (parseInt(tiers ? tiers.querySelector('[data-min]').getAttribute('data-min') : 5, 10) - qty) + ' more for 15% off.';
      }
      totals.classList.toggle('has-qty', qty > 0);
    }
  }
  if (form) {
    form.addEventListener('input', updatePdp);
    form.addEventListener('change', updatePdp);
    updatePdp();
  }

  // Rating link opens the reviews tab.
  document.querySelectorAll('[data-open-tab]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var tab = document.querySelector('.wc-tabs a[href="' + a.getAttribute('href') + '"]');
      if (!tab) return;
      e.preventDefault();
      tab.click();
      var wrap = tab.closest('.woocommerce-tabs');
      if (wrap) wrap.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' });
    });
  });

  /* Product page: colour swatches ------------------------------------- */
  var COLOURS = {
    black: '#111111', white: '#ffffff', navy: '#1b2340', 'french navy': '#1f2a4d', royal: '#2453b8', 'royal blue': '#2453b8', blue: '#2a64c5',
    'sky': '#8fbce6', 'sky blue': '#8fbce6', 'light blue': '#a9cbea', 'arctic blue': '#9ec9e2', aqua: '#2ec4c6', teal: '#127a7a', petrol: '#1d4b5a',
    red: '#cc1f2d', maroon: '#6b1424', burgundy: '#6b1424', cardinal: '#9a1b2f', pink: '#f2b8c6', 'hot pink': '#e8478b', coral: '#f47c6b',
    orange: '#f26a1b', 'safety orange': '#ff6a00', yellow: '#ffd200', 'safety yellow': '#e9f500', gold: '#e5b335', mustard: '#d9a21b',
    lime: '#b8e000', green: '#2e8b3d', 'kelly green': '#2e9b46', bottle: '#1f4a35', 'bottle green': '#1f4a35', forest: '#244a33', army: '#4f5537', khaki: '#a99c74', olive: '#5a5a33', sage: '#a7b39a', mint: '#bfe3d0',
    grey: '#9ea2a8', gray: '#9ea2a8', 'grey marle': '#b5b7ba', marle: '#b5b7ba', charcoal: '#3a3d42', 'coal': '#3a3d42', 'asphalt': '#4a4c50', silver: '#c7c9cc', stone: '#d6cfc1',
    natural: '#efe9dc', ecru: '#ece5d3', cream: '#f3ecd8', bone: '#e6dfcf', sand: '#d9c7a5', tan: '#c49a6c', brown: '#6b4a2e', chocolate: '#4a2f1e',
    purple: '#5b3a91', lavender: '#b9a8d9', violet: '#6a3fa0'
  };
  function colourOf(name) {
    var n = (name || '').toLowerCase().replace(/[^a-z /&+-]/g, '').trim();
    if (COLOURS[n]) return COLOURS[n];
    var parts = n.split(/\s*[\/&+]\s*|\s+and\s+/).filter(Boolean);
    if (parts.length > 1) {
      var a = colourOf(parts[0]), b = colourOf(parts[1]);
      if (a && b) return 'linear-gradient(135deg, ' + a + ' 0 50%, ' + b + ' 50% 100%)';
    }
    var words = n.split(' ');
    for (var i = words.length - 1; i >= 0; i--) { if (COLOURS[words[i]]) return COLOURS[words[i]]; }
    return null;
  }
  function decorate(swatch, name) {
    var c = colourOf(name);
    if (!c) return false;
    swatch.style.setProperty('--swatch', c);
    swatch.classList.add('is-colour');
    swatch.setAttribute('title', name);
    if (/^#f[0-9a-f]{5}$|^#e[c-f][0-9a-f]{4}$/i.test(c)) swatch.classList.add('is-light');
    return true;
  }

  // a) Theme / quote plugin radio swatches (.c44-swatch).
  document.querySelectorAll('.c44-swatches').forEach(function (group) {
    var opt = group.closest('.c44-opt');
    var label = opt ? opt.querySelector('.c44-opt__label') : null;
    var swatches = group.querySelectorAll('.c44-swatch');
    var any = false;
    swatches.forEach(function (sw) { if (decorate(sw, sw.textContent.trim())) any = true; });
    if (!any) return;
    group.classList.add('c44-swatches--colour');
    var current = document.createElement('span');
    current.className = 'c44-opt__current';
    if (label) label.appendChild(current);
    function sync() {
      var on = group.querySelector('input:checked');
      current.textContent = on ? on.closest('.c44-swatch').textContent.trim() : '';
    }
    group.addEventListener('change', sync);
    sync();
  });

  // b) WooCommerce variation dropdowns for colour attributes.
  document.querySelectorAll('.variations select').forEach(function (select) {
    if (!/colou?r/i.test(select.name || select.id || '')) return;
    var opts = Array.prototype.filter.call(select.options, function (o) { return o.value; });
    if (!opts.length || !opts.some(function (o) { return colourOf(o.text); })) return;
    var row = document.createElement('div');
    row.className = 'c44-swatches c44-swatches--colour c44-swatches--select';
    row.setAttribute('role', 'radiogroup');
    opts.forEach(function (o) {
      var b = document.createElement('button');
      b.type = 'button';
      b.className = 'c44-swatch';
      b.setAttribute('role', 'radio');
      b.innerHTML = '<span>' + o.text + '</span>';
      decorate(b, o.text);
      b.addEventListener('click', function () {
        select.value = o.value;
        select.dispatchEvent(new Event('change', { bubbles: true }));
        if (window.jQuery) window.jQuery(select).trigger('change');
        sync();
      });
      row.appendChild(b);
    });
    function sync() {
      row.querySelectorAll('.c44-swatch').forEach(function (b, i) {
        var on = opts[i].value === select.value;
        b.classList.toggle('is-selected', on);
        b.setAttribute('aria-checked', on ? 'true' : 'false');
      });
    }
    select.addEventListener('change', sync);
    select.classList.add('c44-visually-hidden');
    select.parentNode.insertBefore(row, select);
    sync();
  });
})();
