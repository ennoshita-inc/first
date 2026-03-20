<?php
/**
 * Template Name: プライバシーポリシー
 */
get_header();

if (have_posts()) : the_post();
?>

  <div class="page-header">
    <div class="container">
      <h1 class="page-header__title">プライバシーポリシー</h1>
      <p class="page-header__subtitle">Privacy Policy</p>
    </div>
  </div>

  <?php ennoshita_breadcrumb(); ?>

  <section class="section">
    <div class="container container--narrow">
      <div class="entry-content entry-content--spaced reveal">
        <?php
        $content = get_the_content();
        if (trim($content)) :
            the_content();
        else :
        ?>
        <p class="privacy-note">以下は標準的なプライバシーポリシーのテンプレートです。WordPress管理画面でこのページの本文を編集して、貴社の実態に合わせた内容に更新してください。</p>

        <h2>1. 個人情報の取得について</h2>
        <p>株式会社えんのした（以下「当社」）は、お問い合わせフォーム、資料ダウンロード、セミナー申込み等を通じて、お客様の個人情報（氏名、会社名、メールアドレス、電話番号等）を取得することがあります。</p>

        <h2>2. 個人情報の利用目的</h2>
        <p>取得した個人情報は、以下の目的で利用いたします。</p>
        <ul>
          <li>お問い合わせへの回答・対応</li>
          <li>サービスに関する情報提供・ご提案</li>
          <li>セミナー・イベントのご案内</li>
          <li>メールマガジンの配信（ご同意いただいた場合）</li>
          <li>契約の履行・アフターフォロー</li>
          <li>サービス改善のための統計データ作成（個人を特定しない形式）</li>
        </ul>

        <h2>3. 個人情報の第三者提供について</h2>
        <p>当社は、法令に基づく場合を除き、お客様の同意なく個人情報を第三者に提供することはありません。</p>

        <h2>4. 個人情報の安全管理</h2>
        <p>当社は、個人情報の漏洩、滅失、毀損等を防止するため、適切な安全管理措置を講じます。</p>

        <h2>5. Cookieの使用について</h2>
        <p>当サイトでは、利便性向上およびアクセス解析のためにCookieを使用しています。Cookie同意バナーにて「同意する」を選択された場合にのみ、Google Analytics等のトラッキングツールが有効化されます。「拒否する」を選択された場合、これらのツールは読み込まれません。</p>

        <h2>6. アクセス解析ツールについて</h2>
        <p>当サイトでは、Googleによるアクセス解析ツール「Google Analytics」を利用しています。Google Analyticsはデータの収集のためにCookieを使用します。このデータは匿名で収集されており、個人を特定するものではありません。Google Analyticsの利用規約については、<a href="https://marketingplatform.google.com/about/analytics/terms/jp/" target="_blank" rel="noopener">Google アナリティクス利用規約</a>をご確認ください。</p>

        <h2>7. 個人情報の開示・訂正・削除</h2>
        <p>お客様は、当社が保有する個人情報について、開示・訂正・削除を求めることができます。ご希望の場合は、下記お問い合わせ先までご連絡ください。</p>

        <h2>8. プライバシーポリシーの変更</h2>
        <p>当社は、必要に応じて本ポリシーを変更することがあります。変更した場合は、当サイトにて公表いたします。</p>

        <h2>9. お問い合わせ先</h2>
        <p>
          株式会社えんのした<br>
          所在地: <?php echo esc_html(get_theme_mod('ennoshita_address', '岡山県岡山市 磨屋町ビル8階')); ?><br>
          <?php $phone = get_theme_mod('ennoshita_phone'); if ($phone) : ?>
            電話: <?php echo esc_html($phone); ?><br>
          <?php endif; ?>
          お問い合わせフォーム: <a href="<?php echo esc_url(home_url('/contact/')); ?>">こちら</a>
        </p>

        <p class="privacy-date">制定日: 2024年4月1日<br>最終改定日: <?php echo wp_date('Y年n月j日'); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </section>

<?php
endif;
get_footer();
?>
