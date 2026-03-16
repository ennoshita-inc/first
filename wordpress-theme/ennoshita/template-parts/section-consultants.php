<?php
/**
 * コンサルタント紹介セクション
 * サービスページやaboutページで使用
 */
$consultant_query = new WP_Query([
    'post_type'      => 'team_member',
    'posts_per_page' => 6,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
]);

if (!$consultant_query->have_posts()) return;
?>

<section class="section section--gray" aria-labelledby="consultants-title">
  <div class="container">
    <div class="section-header reveal">
      <p class="section-header__label">Consultants</p>
      <h2 class="section-header__title" id="consultants-title">担当コンサルタント</h2>
      <span class="section-header__line" aria-hidden="true"></span>
      <p class="section-header__description">B2Bコンサルティングの成否は「誰がやるか」で決まります。</p>
    </div>

    <div class="consultants__grid">
      <?php
      $delay = 1;
      while ($consultant_query->have_posts()) : $consultant_query->the_post();
        $position    = get_post_meta(get_the_ID(), '_team_position', true);
        $specialty   = get_post_meta(get_the_ID(), '_team_specialty', true);
        $credentials = get_post_meta(get_the_ID(), '_team_credentials', true);
      ?>
      <div class="consultant-card reveal reveal--delay-<?php echo min($delay++, 3); ?>">
        <div class="consultant-card__photo">
          <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('blog-card', ['class' => 'consultant-card__img', 'loading' => 'lazy']); ?>
          <?php else : ?>
            <div class="consultant-card__placeholder" aria-hidden="true">
              <?php echo ennoshita_icon('users', 48); ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="consultant-card__info">
          <?php if ($position) : ?>
            <p class="consultant-card__position"><?php echo esc_html($position); ?></p>
          <?php endif; ?>
          <h3 class="consultant-card__name"><?php the_title(); ?></h3>
          <?php if ($specialty) : ?>
            <p class="consultant-card__specialty"><?php echo esc_html($specialty); ?></p>
          <?php endif; ?>
          <?php if ($credentials) : ?>
            <ul class="consultant-card__creds">
              <?php foreach (array_filter(explode("\n", $credentials)) as $cred) : ?>
                <li><?php echo esc_html(trim($cred)); ?></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
