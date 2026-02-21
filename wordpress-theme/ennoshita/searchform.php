<?php
/**
 * カスタム検索フォーム
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
  <label class="screen-reader-text" for="search-field">検索:</label>
  <input type="search"
         id="search-field"
         class="search-form__input"
         placeholder="記事を検索..."
         value="<?php echo esc_attr(get_search_query()); ?>"
         name="s">
  <button type="submit" class="search-form__submit">検索</button>
</form>
