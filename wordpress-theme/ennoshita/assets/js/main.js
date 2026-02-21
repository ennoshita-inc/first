/**
 * えんのした テーマ — main.js v3.0
 *
 * 機能:
 * 1. スティッキーヘッダー (スクロール検知)
 * 2. ハンバーガーメニュー (キーボード対応)
 * 3. スムーススクロール (アンカーリンク)
 * 4. Intersection Observer スクロールリビール
 * 5. 数字カウントアップアニメーション
 */

(function () {
  'use strict';

  // ===== 1. スティッキーヘッダー =====
  const header = document.querySelector('.site-header');
  if (header) {
    let lastScroll = 0;
    const scrollThreshold = 10;

    window.addEventListener('scroll', function () {
      const currentScroll = window.scrollY;
      if (currentScroll > scrollThreshold) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }
      lastScroll = currentScroll;
    }, { passive: true });
  }


  // ===== 2. ハンバーガーメニュー =====
  const hamburger = document.querySelector('.hamburger');
  const mainNav = document.querySelector('.main-nav');
  const navOverlay = document.querySelector('.nav-overlay');

  function openMenu() {
    hamburger.setAttribute('aria-expanded', 'true');
    hamburger.setAttribute('aria-label', 'メニューを閉じる');
    mainNav.classList.add('is-open');
    navOverlay.classList.add('is-active');
    document.body.style.overflow = 'hidden';

    // Focus first link
    const firstLink = mainNav.querySelector('a');
    if (firstLink) firstLink.focus();
  }

  function closeMenu() {
    hamburger.setAttribute('aria-expanded', 'false');
    hamburger.setAttribute('aria-label', 'メニューを開く');
    mainNav.classList.remove('is-open');
    navOverlay.classList.remove('is-active');
    document.body.style.overflow = '';
    hamburger.focus();
  }

  function toggleMenu() {
    const isOpen = hamburger.getAttribute('aria-expanded') === 'true';
    if (isOpen) {
      closeMenu();
    } else {
      openMenu();
    }
  }

  if (hamburger && mainNav) {
    hamburger.addEventListener('click', toggleMenu);

    if (navOverlay) {
      navOverlay.addEventListener('click', closeMenu);
    }

    // ESC key to close
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && mainNav.classList.contains('is-open')) {
        closeMenu();
      }
    });

    // Close on nav link click (mobile)
    mainNav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        if (mainNav.classList.contains('is-open')) {
          closeMenu();
        }
      });
    });

    // Focus trap within mobile nav
    mainNav.addEventListener('keydown', function (e) {
      if (e.key !== 'Tab') return;
      if (!mainNav.classList.contains('is-open')) return;

      const focusable = mainNav.querySelectorAll('a, button');
      const firstFocusable = focusable[0];
      const lastFocusable = focusable[focusable.length - 1];

      if (e.shiftKey) {
        if (document.activeElement === firstFocusable) {
          e.preventDefault();
          lastFocusable.focus();
        }
      } else {
        if (document.activeElement === lastFocusable) {
          e.preventDefault();
          firstFocusable.focus();
        }
      }
    });
  }


  // ===== 3. スムーススクロール =====
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      const targetId = this.getAttribute('href');
      if (targetId === '#') return;

      const target = document.querySelector(targetId);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });


  // ===== 4. Intersection Observer — Scroll Reveal =====
  const revealElements = document.querySelectorAll('.reveal, .reveal--left, .reveal--right, .reveal--scale');

  if (revealElements.length > 0 && 'IntersectionObserver' in window) {
    const revealObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          revealObserver.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.15,
      rootMargin: '0px 0px -40px 0px',
    });

    revealElements.forEach(function (el) {
      revealObserver.observe(el);
    });
  } else {
    // Fallback: show all immediately
    revealElements.forEach(function (el) {
      el.classList.add('is-visible');
    });
  }


  // ===== 5. 数字カウントアップ =====
  const countElements = document.querySelectorAll('[data-count]');

  if (countElements.length > 0 && 'IntersectionObserver' in window) {
    const countObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          animateCount(entry.target);
          countObserver.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.5,
    });

    countElements.forEach(function (el) {
      countObserver.observe(el);
    });
  }

  function animateCount(el) {
    const target = parseInt(el.getAttribute('data-count'), 10);
    const suffix = el.querySelector('small');
    const suffixText = suffix ? suffix.textContent : '';
    const duration = 2000;
    const startTime = performance.now();

    function easeOutExpo(t) {
      return t === 1 ? 1 : 1 - Math.pow(2, -10 * t);
    }

    function update(currentTime) {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const easedProgress = easeOutExpo(progress);
      const current = Math.round(easedProgress * target);

      el.innerHTML = current + (suffixText ? '<small>' + suffixText + '</small>' : '');

      if (progress < 1) {
        requestAnimationFrame(update);
      }
    }

    requestAnimationFrame(update);
  }

})();
