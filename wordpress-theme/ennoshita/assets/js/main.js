/**
 * えんのした テーマ — main.js v5.0
 *
 * 機能:
 * 1. ページローディング演出
 * 2. スティッキーヘッダー (スクロール検知)
 * 3. ハンバーガーメニュー (キーボード対応)
 * 4. スムーススクロール (アンカーリンク)
 * 5. Intersection Observer スクロールリビール
 * 6. トップへ戻るボタン
 * 7. Cookie同意バナー
 * 8. カルーセル (導入事例スライダー: タッチ対応・自動再生)
 * 9. 数字カウントアップアニメーション
 */

(function () {
  'use strict';

  // ===== 0. ページローディング =====
  var pageLoading = document.querySelector('.page-loading');
  if (pageLoading) {
    window.addEventListener('load', function () {
      setTimeout(function () {
        pageLoading.classList.add('is-loaded');
      }, 200);
    });
    // Fallback: force hide after 3 seconds
    setTimeout(function () {
      if (pageLoading) pageLoading.classList.add('is-loaded');
    }, 3000);
  }

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


  // ===== 5. トップへ戻るボタン =====
  var backToTop = document.querySelector('.back-to-top');
  if (backToTop) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 600) {
        backToTop.classList.add('is-visible');
      } else {
        backToTop.classList.remove('is-visible');
      }
    }, { passive: true });

    backToTop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }


  // ===== 6. Cookie同意バナー + GA4/GTM遅延読み込み =====
  var cookieConsent = document.getElementById('cookie-consent');
  var cookieAccept = document.getElementById('cookie-accept');
  var cookieReject = document.getElementById('cookie-reject');

  // GA4/GTMを読み込む関数（同意後にのみ実行）
  function loadAnalytics() {
    var configEl = document.getElementById('ennoshita-analytics-config');
    if (!configEl) return;
    try {
      var config = JSON.parse(configEl.textContent);
      if (config.gtm) {
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer',config.gtm);
      } else if (config.ga4) {
        var s = document.createElement('script');
        s.async = true;
        s.src = 'https://www.googletagmanager.com/gtag/js?id=' + config.ga4;
        document.head.appendChild(s);
        window.dataLayer = window.dataLayer || [];
        function gtag(){window.dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', config.ga4);
      }
    } catch (e) { /* ignore */ }
  }

  if (cookieConsent && cookieAccept) {
    var consentState = localStorage.getItem('cookie_consent');

    if (consentState === 'accepted') {
      // 既に同意済み → GA4/GTMを読み込む
      loadAnalytics();
    } else if (!consentState) {
      // 未回答 → バナー表示
      setTimeout(function () {
        cookieConsent.classList.add('is-visible');
      }, 1500);
    }
    // 'rejected' の場合はGA4/GTMを読み込まない

    cookieAccept.addEventListener('click', function () {
      localStorage.setItem('cookie_consent', 'accepted');
      cookieConsent.classList.remove('is-visible');
      loadAnalytics();
    });

    if (cookieReject) {
      cookieReject.addEventListener('click', function () {
        localStorage.setItem('cookie_consent', 'rejected');
        cookieConsent.classList.remove('is-visible');
      });
    }
  }


  // ===== 7. 数字カウントアップ =====
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

  // ===== 8. カルーセル（導入事例スライダー） =====
  document.querySelectorAll('[data-carousel]').forEach(function (carousel) {
    var track = carousel.querySelector('.carousel-track');
    var slides = carousel.querySelectorAll('.carousel-slide');
    var dots = carousel.querySelectorAll('.carousel-dot');
    var prevBtn = carousel.querySelector('.carousel-prev');
    var nextBtn = carousel.querySelector('.carousel-next');
    var currentIndex = 0;
    var slideCount = slides.length;
    var autoPlayTimer = null;
    var touchStartX = 0;
    var touchEndX = 0;

    if (slideCount <= 1) return;

    function goToSlide(index) {
      if (index < 0) index = slideCount - 1;
      if (index >= slideCount) index = 0;
      currentIndex = index;
      track.style.transform = 'translateX(-' + (currentIndex * 100) + '%)';
      dots.forEach(function (dot, i) {
        dot.classList.toggle('active', i === currentIndex);
      });
    }

    function startAutoPlay() {
      stopAutoPlay();
      autoPlayTimer = setInterval(function () {
        goToSlide(currentIndex + 1);
      }, 5000);
    }

    function stopAutoPlay() {
      if (autoPlayTimer) {
        clearInterval(autoPlayTimer);
        autoPlayTimer = null;
      }
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', function () {
        goToSlide(currentIndex - 1);
        startAutoPlay();
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', function () {
        goToSlide(currentIndex + 1);
        startAutoPlay();
      });
    }

    dots.forEach(function (dot, i) {
      dot.addEventListener('click', function () {
        goToSlide(i);
        startAutoPlay();
      });
    });

    // Touch / swipe support
    carousel.addEventListener('touchstart', function (e) {
      touchStartX = e.changedTouches[0].screenX;
      stopAutoPlay();
    }, { passive: true });

    carousel.addEventListener('touchend', function (e) {
      touchEndX = e.changedTouches[0].screenX;
      var diff = touchStartX - touchEndX;
      if (Math.abs(diff) > 50) {
        if (diff > 0) {
          goToSlide(currentIndex + 1);
        } else {
          goToSlide(currentIndex - 1);
        }
      }
      startAutoPlay();
    }, { passive: true });

    // Pause on hover
    carousel.addEventListener('mouseenter', stopAutoPlay);
    carousel.addEventListener('mouseleave', startAutoPlay);

    startAutoPlay();
  });


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

      var display = current.toLocaleString();
      el.innerHTML = display + (suffixText ? '<small>' + suffixText + '</small>' : '');

      if (progress < 1) {
        requestAnimationFrame(update);
      }
    }

    requestAnimationFrame(update);
  }

})();
