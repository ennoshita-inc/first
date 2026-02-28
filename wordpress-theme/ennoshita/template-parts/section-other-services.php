<?php
/**
 * その他のサービス セクション
 * page-service.php で使用。現在のページと一致するサービスをスキップ。
 */
$services     = ennoshita_get_services();
$current_path = trailingslashit(wp_make_link_relative(get_permalink()));
?>
<section class="section section--gray" aria-labelledby="other-services-title">
  <div class="container">
    <div class="section-header">
      <p class="section-header__label">Other Services</p>
      <h2 class="section-header__title" id="other-services-title">その他のサービス</h2>
      <span class="section-header__line" aria-hidden="true"></span>
    </div>

    <div class="services__grid services__grid--compact">
      <?php foreach ($services as $svc) :
        $svc_url  = home_url($svc['slug']);
        $svc_path = trailingslashit(wp_make_link_relative($svc_url));
        if ($svc_path === $current_path) continue;
      ?>
        <article class="service-card">
          <span class="service-card__number"><?php echo esc_html($svc['number']); ?></span>
          <div class="service-card__icon" aria-hidden="true">
            <?php echo $svc['icon']; ?>
          </div>
          <h3 class="service-card__title"><?php echo esc_html($svc['title']); ?></h3>
          <p class="service-card__subtitle"><?php echo esc_html($svc['subtitle']); ?></p>
          <a href="<?php echo esc_url($svc_url); ?>" class="service-card__link">
            詳しく見る
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
