<?php
/**
 * 共通プロセスセクション（導入の流れ）
 * front-page.php, page-service.php で再利用
 */
$process_id = isset($args['id']) ? $args['id'] : 'process-title';
?>
<section class="section section--gray" aria-labelledby="<?php echo esc_attr($process_id); ?>">
  <div class="container">
    <div class="section-header reveal">
      <p class="section-header__label">Process</p>
      <h2 class="section-header__title" id="<?php echo esc_attr($process_id); ?>">サービス導入の流れ</h2>
      <span class="section-header__line" aria-hidden="true"></span>
      <p class="section-header__description">
        お問い合わせから導入まで、4つのステップでサポートします。
      </p>
    </div>

    <div class="process__steps">
      <?php
      $steps = [
        ['title' => 'お問い合わせ',     'text' => 'まずはお気軽にご連絡ください。ご相談は無料です。'],
        ['title' => 'ヒアリング',       'text' => '組織の現状と課題を丁寧にお伺いします。'],
        ['title' => 'ご提案・お見積り', 'text' => '最適なプランをご提案し、お見積りを提出します。'],
        ['title' => 'サービス開始',     'text' => 'プログラムを実施し、組織の変革を支援します。'],
      ];
      foreach ($steps as $i => $step) :
      ?>
        <div class="process__step reveal reveal--delay-<?php echo $i + 1; ?>">
          <div class="process__step-number"><?php echo $i + 1; ?></div>
          <h3 class="process__step-title"><?php echo esc_html($step['title']); ?></h3>
          <p class="process__step-text"><?php echo esc_html($step['text']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
