<?php
/**
 * 固定ページテンプレート (汎用)
 */
get_header();

if (have_posts()) : the_post();
?>

  <div class="page-header">
    <div class="container">
      <h1 class="page-header__title"><?php the_title(); ?></h1>
      <?php if (has_excerpt()) : ?>
        <p class="page-header__subtitle"><?php echo esc_html(get_the_excerpt()); ?></p>
      <?php endif; ?>
    </div>
  </div>

  <?php ennoshita_breadcrumb(); ?>

  <div class="page-content">
    <div class="container container--narrow">
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    </div>
  </div>

<?php
endif;
get_footer();
?>
