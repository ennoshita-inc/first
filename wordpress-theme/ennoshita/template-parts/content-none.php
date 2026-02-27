<?php
/**
 * コンテンツが見つからない場合のテンプレート
 */
?>
<div class="content-none">
  <h2 class="content-none__title">記事が見つかりませんでした</h2>
  <p class="content-none__text">
    <?php if (is_search()) : ?>
      「<?php echo esc_html(get_search_query()); ?>」に一致する記事はありませんでした。<br>別のキーワードでお試しください。
    <?php else : ?>
      まだ投稿がありません。
    <?php endif; ?>
  </p>

  <?php if (is_search()) : ?>
    <div class="content-none__search">
      <?php get_search_form(); ?>
    </div>
  <?php else : ?>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">トップページへ</a>
  <?php endif; ?>
</div>
