<?php
/**
 * Template Name: お問い合わせページ
 */
get_header();

if (have_posts()) : the_post();
?>

  <div class="page-header">
    <div class="container">
      <h1 class="page-header__title">お問い合わせ</h1>
      <p class="page-header__subtitle">まずはお気軽にご相談ください。ご相談は無料です。</p>
    </div>
  </div>

  <?php ennoshita_breadcrumb(); ?>

  <div class="page-content">
    <div class="container">

      <?php
      $contact_status = isset($_GET['contact']) ? sanitize_text_field($_GET['contact']) : '';
      if ($contact_status === 'success') : ?>
        <div class="contact-alert contact-alert--success" role="alert">
          <p>お問い合わせありがとうございます。内容を確認の上、担当者よりご連絡いたします。</p>
        </div>
      <?php elseif ($contact_status === 'error') : ?>
        <div class="contact-alert contact-alert--error" role="alert">
          <p>送信に失敗しました。必須項目をご確認の上、もう一度お試しください。</p>
        </div>
      <?php endif; ?>

      <div class="contact-info__grid reveal">
        <div class="contact-info__item">
          <div class="contact-info__icon" aria-hidden="true">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </div>
          <h2 class="contact-info__title">お問い合わせ</h2>
          <p class="contact-info__text">下記フォームよりご連絡ください</p>
        </div>
      </div>

      <div class="contact-form reveal">
        <div class="entry-content">
          <?php
          $content = get_the_content();
          if ($content) :
            the_content();
          else :
            // Contact Form 7 未設定時のフォールバック
          ?>
            <p class="contact-form__setup-hint">
              お問い合わせフォームを表示するには、WordPress管理画面でこのページの本文に
              Contact Form 7 のショートコードを貼り付けてください。<br>
              例: <code>[contact-form-7 id="xxx" title="お問い合わせ"]</code>
            </p>
            <form class="contact-form__fallback" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
              <input type="hidden" name="action" value="ennoshita_contact">
              <?php wp_nonce_field('ennoshita_contact_nonce', '_wpnonce_contact'); ?>

              <div class="form-group">
                <label for="contact-company">会社名 <span class="form-required">*</span></label>
                <input type="text" id="contact-company" name="company" required>
              </div>

              <div class="form-group">
                <label for="contact-name">お名前 <span class="form-required">*</span></label>
                <input type="text" id="contact-name" name="name" required>
              </div>

              <div class="form-group">
                <label for="contact-email">メールアドレス <span class="form-required">*</span></label>
                <input type="email" id="contact-email" name="email" required>
              </div>

              <div class="form-group">
                <label for="contact-phone">電話番号</label>
                <input type="tel" id="contact-phone" name="phone">
              </div>

              <div class="form-group">
                <label for="contact-subject">ご相談内容 <span class="form-required">*</span></label>
                <select id="contact-subject" name="subject" required>
                  <option value="">選択してください</option>
                  <option value="人材育成サービスについて">人材育成サービスについて</option>
                  <option value="人事制度構築支援について">人事制度構築支援について</option>
                  <option value="組織開発支援について">組織開発支援について</option>
                  <option value="その他のご相談">その他のご相談</option>
                </select>
              </div>

              <div class="form-group">
                <label for="contact-message">メッセージ <span class="form-required">*</span></label>
                <textarea id="contact-message" name="message" rows="6" required></textarea>
              </div>

              <!-- honeypot: スパムボット対策（非表示フィールド） -->
              <div class="form-group" style="position:absolute;left:-9999px" aria-hidden="true">
                <label for="contact-website">ウェブサイト</label>
                <input type="text" id="contact-website" name="website" tabindex="-1" autocomplete="off">
              </div>

              <div class="form-group form-group--consent">
                <label class="form-consent">
                  <input type="checkbox" name="privacy_consent" value="1" required>
                  <span><a href="<?php echo esc_url(home_url('/privacy/')); ?>" target="_blank" rel="noopener">プライバシーポリシー</a>に同意の上、送信してください。<span class="form-required">*</span></span>
                </label>
              </div>

              <div class="form-group form-group--center">
                <button type="submit" class="btn btn--primary btn--large">
                  送信する
                  <svg class="btn__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </button>
              </div>
            </form>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>

<?php
endif;
get_footer();
?>
