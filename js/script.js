document.addEventListener('DOMContentLoaded', function () {
  // AOS (Animate On Scroll) initialization
  if (typeof AOS !== 'undefined') {
    AOS.init({
      duration: 1000,
      once: true,
      offset: 80
    });
  }

  // Hero background video: pause (but keep visible) for users who prefer
  // reduced motion, so it shows as a static frame instead of animating.
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.querySelectorAll('.hero-video').forEach(function (v) {
      v.pause();
    });
  }

  // Mobile nav toggle
  const navToggle = document.getElementById('navToggle');
  const mainNav = document.getElementById('mainNav');
  if (navToggle) {
    navToggle.addEventListener('click', function () {
      mainNav.classList.toggle('open');
    });
  }

  // Mobile dropdown toggle (tap to expand submenu)
  document.querySelectorAll('.has-dropdown > a').forEach(function (link) {
    link.addEventListener('click', function (e) {
      if (window.innerWidth <= 720) {
        const parent = link.parentElement;
        if (parent.querySelector('.dropdown')) {
          e.preventDefault();
          parent.classList.toggle('open');
        }
      }
    });
  });

  // Lab report: print / save as PDF button
  const printReportBtn = document.getElementById('printReportBtn');
  if (printReportBtn) {
    printReportBtn.addEventListener('click', function () {
      window.print();
    });
  }

  // Generic tab system: elements with data-tab-group / data-tab
  document.querySelectorAll('[data-tab-btn]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      const group = btn.getAttribute('data-tab-group');
      const target = btn.getAttribute('data-tab-btn');
      document.querySelectorAll('[data-tab-group="' + group + '"]').forEach(function (b) {
        b.classList.remove('active');
      });
      btn.classList.add('active');
      document.querySelectorAll('[data-tab-content][data-tab-group-content="' + group + '"]').forEach(function (c) {
        c.classList.remove('active');
      });
      const el = document.querySelector('[data-tab-content="' + target + '"][data-tab-group-content="' + group + '"]');
      if (el) el.classList.add('active');
    });
  });

  // Generic center-focus carousel (e.g. home page "Our Core Services"):
  // 3 boxes are visible on desktop — the middle box is bigger with its
  // content + Read More visible, while the left/right boxes peek in
  // smaller and dimmer. Arrows move one box at a time in an infinite
  // loop: after the last box the first one comes back, and vice versa.
  // Supports touch swipe.
  document.querySelectorAll('[data-carousel]').forEach(function (root) {
    var track = root.querySelector('[data-carousel-track]');
    var prevBtn = root.querySelector('[data-carousel-prev]');
    var nextBtn = root.querySelector('[data-carousel-next]');
    if (!track || !prevBtn || !nextBtn) return;

    var realSlides = Array.prototype.slice.call(track.children);
    var realTotal = realSlides.length;
    if (realTotal === 0) return;

    var visible = getVisibleCount();
    var realHTML = realSlides.map(function (s) { return s.outerHTML; }).join('');
    var slides = [];
    var index = 0;   // index of the centered (active) card
    var cloneCount = 0;
    var snapTimer = null;
    var snapHandler = null;

    function getVisibleCount() {
      return window.innerWidth >= 640 ? 3 : 1;
    }

    // Rebuild the track with cloned cards on both ends so the loop is
    // seamless: [clones of the last cards] [real cards] [clones of the
    // first cards]. When the active card slides onto a clone, it is
    // snapped back to the matching real card invisibly.
    function build() {
      // Keep the current real card across a resize rebuild.
      var prevReal = slides.length ? index - cloneCount : 0;
      if (prevReal < 0) prevReal = 0;
      if (prevReal > realTotal - 1) prevReal = realTotal - 1;

      cloneCount = Math.min(visible, realTotal);
      var head = '';
      for (var i = realTotal - cloneCount; i < realTotal; i++) head += realSlides[i].outerHTML;
      var tail = '';
      for (var i = 0; i < cloneCount; i++) tail += realSlides[i].outerHTML;
      track.innerHTML = head + realHTML + tail;
      slides = Array.prototype.slice.call(track.children);
      index = cloneCount + prevReal;
      update(false);
    }

    function cancelSnap() {
      if (snapTimer !== null) {
        clearTimeout(snapTimer);
        snapTimer = null;
      }
      if (snapHandler) {
        track.removeEventListener('transitionend', snapHandler);
        snapHandler = null;
      }
    }

    function update(animate) {
      var slideW = 100 / visible;
      if (animate === false) {
        track.style.transition = 'none';
      }
      // Center the active card in the viewport.
      track.style.transform = 'translateX(' + (50 - (index + 0.5) * slideW) + '%)';
      if (animate === false) {
        void track.offsetWidth; // flush so the new position applies instantly
        track.style.transition = '';
      }

      // Spotlight: the centered card is bigger and fully visible; cards
      // further away shrink and dim.
      slides.forEach(function (slide, i) {
        var dist = i - index;
        var isFocus = dist === 0;
        slide.classList.toggle('is-active', isFocus);
        var scale = isFocus ? 1.06 : (Math.abs(dist) === 1 ? 0.92 : 0.88);
        var opacity = isFocus ? '1' : (Math.abs(dist) === 1 ? '0.85' : '0.6');
        slide.style.transform = 'scale(' + scale + ')';
        slide.style.opacity = opacity;
        slide.style.zIndex = isFocus ? 20 : (Math.abs(dist) === 1 ? 10 : 5);
      });
    }

    // After sliding onto a clone, snap back to the matching real card
    // without animation so the wrap-around is invisible.
    function scheduleSnap() {
      cancelSnap();
      var done = false;
      var finish = function () {
        if (done) return;
        done = true;
        if (index < cloneCount) {
          index += realTotal;
          update(false);
        } else if (index >= cloneCount + realTotal) {
          index -= realTotal;
          update(false);
        }
      };
      snapHandler = function (e) {
        if (e.target !== track || e.propertyName !== 'transform') return;
        cancelSnap();
        finish();
      };
      track.addEventListener('transitionend', snapHandler);
      // Fallback (e.g. reduced motion or cancelled transitions).
      var dur = parseFloat(window.getComputedStyle(track).transitionDuration) || 0.6;
      snapTimer = setTimeout(finish, dur * 1000 + 120);
    }

    // Hide the buttons when there is nothing to loop.
    if (realTotal <= 1) {
      prevBtn.hidden = true;
      nextBtn.hidden = true;
    }

    prevBtn.addEventListener('click', function () {
      cancelSnap();
      index -= 1;
      update(true);
      if (index < cloneCount) {
        scheduleSnap();
      }
    });

    nextBtn.addEventListener('click', function () {
      cancelSnap();
      index += 1;
      update(true);
      if (index >= cloneCount + realTotal) {
        scheduleSnap();
      }
    });

    // Rebuild if the visible count changes on resize (debounced).
    var resizeTimer = null;
    window.addEventListener('resize', function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function () {
        var v = getVisibleCount();
        if (v !== visible) {
          visible = v;
          build();
        }
      }, 120);
    });

    // Swipe support on touch devices.
    var startX = null;
    var viewport = root.querySelector('.carousel-viewport');
    if (viewport) {
      viewport.addEventListener('touchstart', function (e) {
        startX = e.touches[0].clientX;
      }, { passive: true });
      viewport.addEventListener('touchend', function (e) {
        if (startX === null) return;
        var delta = e.changedTouches[0].clientX - startX;
        if (Math.abs(delta) > 40) {
          if (delta < 0) {
            nextBtn.click();
          } else {
            prevBtn.click();
          }
        }
        startX = null;
      }, { passive: true });
    }

    build();
  });
});
