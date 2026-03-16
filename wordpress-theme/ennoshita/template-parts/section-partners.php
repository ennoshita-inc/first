<?php
/**
 * パートナー・メディア掲載ロゴウォール
 * トップページで使用 — B2B信頼性向上
 */
$has_logos = false;
for ($i = 1; $i <= 6; $i++) {
    if (get_theme_mod("ennoshita_partner_logo_{$i}")) {
        $has_logos = true;
        break;
    }
}
if (!$has_logos) return;
?>

<section class="section section--partners" aria-labelledby="partners-title">
  <div class="container">
    <div class="section-header reveal">
      <p class="section-header__label">Partners</p>
      <h2 class="section-header__title" id="partners-title">パートナー・メディア掲載</h2>
      <span class="section-header__line" aria-hidden="true"></span>
    </div>
    <div class="partners__grid reveal">
      <?php for ($i = 1; $i <= 6; $i++) :
        $logo_url = get_theme_mod("ennoshita_partner_logo_{$i}");
        $name     = get_theme_mod("ennoshita_partner_name_{$i}");
        if (!$logo_url) continue;
      ?>
        <div class="partners__item">
          <img src="<?php echo esc_url($logo_url); ?>"
               alt="<?php echo esc_attr($name ?: 'パートナー企業'); ?>"
               class="partners__logo" loading="lazy">
        </div>
      <?php endfor; ?>
    </div>
  </div>
</section>
