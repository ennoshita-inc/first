<?php
/**
 * 資料ダウンロードCTA（リードマグネット）
 * カスタマイザーでURLが設定されている場合のみ表示
 */
$lm_url   = get_theme_mod('ennoshita_lead_magnet_url');
if (!$lm_url) return;

$lm_title = get_theme_mod('ennoshita_lead_magnet_title', '無料ダウンロード資料');
$lm_desc  = get_theme_mod('ennoshita_lead_magnet_description', '「組織診断チェックリスト」を無料でお届けします。自社の組織課題を可視化する第一歩にご活用ください。');
$lm_btn   = get_theme_mod('ennoshita_lead_magnet_button_text', '無料でダウンロード');
?>
<aside class="lead-magnet reveal" aria-label="無料資料ダウンロード">
  <div class="lead-magnet__inner">
    <div class="lead-magnet__icon" aria-hidden="true">
      <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><polyline points="9 15 12 18 15 15"/></svg>
    </div>
    <div class="lead-magnet__body">
      <p class="lead-magnet__title"><?php echo esc_html($lm_title); ?></p>
      <p class="lead-magnet__text"><?php echo esc_html($lm_desc); ?></p>
    </div>
    <a href="<?php echo esc_url($lm_url); ?>" class="btn btn--primary">
      <?php echo esc_html($lm_btn); ?>
      <svg class="btn__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
    </a>
  </div>
</aside>
