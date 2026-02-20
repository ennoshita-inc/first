/**
 * 株式会社えんのした - メインJavaScript
 */

document.addEventListener('DOMContentLoaded', () => {
  // ============================================
  // ハンバーガーメニュー（改善13: モバイル対応）
  // ============================================
  const hamburger = document.querySelector('.hamburger');
  const nav = document.querySelector('.nav');

  if (hamburger && nav) {
    hamburger.addEventListener('click', () => {
      const isOpen = nav.classList.toggle('is-open');
      hamburger.classList.toggle('is-active', isOpen);
      hamburger.setAttribute('aria-expanded', String(isOpen));
      hamburger.setAttribute('aria-label', isOpen ? 'メニューを閉じる' : 'メニューを開く');

      // メニューが開いている間、背景スクロールを無効化
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    // ESCキーでメニューを閉じる（アクセシビリティ）
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && nav.classList.contains('is-open')) {
        nav.classList.remove('is-open');
        hamburger.classList.remove('is-active');
        hamburger.setAttribute('aria-expanded', 'false');
        hamburger.setAttribute('aria-label', 'メニューを開く');
        document.body.style.overflow = '';
        hamburger.focus();
      }
    });
  }

  // ============================================
  // スティッキーヘッダーの背景変更
  // ============================================
  const header = document.querySelector('.header');
  if (header) {
    const onScroll = () => {
      header.classList.toggle('is-scrolled', window.scrollY > 10);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  // ============================================
  // スムーススクロール（アンカーリンク）
  // ============================================
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', (e) => {
      const targetId = anchor.getAttribute('href');
      if (targetId === '#') return;

      const target = document.querySelector(targetId);
      if (target) {
        e.preventDefault();
        const headerHeight = header ? header.offsetHeight : 0;
        const targetPosition = target.getBoundingClientRect().top + window.scrollY - headerHeight;
        window.scrollTo({ top: targetPosition, behavior: 'smooth' });

        // モバイルメニューが開いていれば閉じる
        if (nav && nav.classList.contains('is-open')) {
          nav.classList.remove('is-open');
          hamburger.classList.remove('is-active');
          hamburger.setAttribute('aria-expanded', 'false');
          document.body.style.overflow = '';
        }
      }
    });
  });
});
