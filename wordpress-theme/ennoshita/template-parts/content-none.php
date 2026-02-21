<?php
/**
 * コンテンツが見つからない場合のテンプレート
 */
?>
<div style="text-align: center; padding: var(--space-4xl) 0;">
  <h2 style="font-size: var(--font-size-2xl); margin-bottom: var(--space-md);">記事が見つかりませんでした</h2>
  <p style="color: var(--color-text-secondary); margin-bottom: var(--space-2xl);">
    <?php if (is_search()) : ?>
      「<?php echo esc_html(get_search_query()); ?>」に一致する記事はありませんでした。<br>別のキーワードでお試しください。
    <?php else : ?>
      まだ投稿がありません。
    <?php endif; ?>
  </p>

  <?php if (is_search()) : ?>
    <div style="max-width: 480px; margin: 0 auto;">
      <?php get_search_form(); ?>
    </div>
  <?php else : ?>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">トップページへ</a>
  <?php endif; ?>
</div>
