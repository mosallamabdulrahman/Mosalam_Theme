<?php
/**
 * @var array $attributes
 */
$eyebrow = $attributes['eyebrow'] ?? '';
$title_line1 = $attributes['titleLine1'] ?? '';
$title_line2 = $attributes['titleLine2'] ?? '';
$badge_label = $attributes['badgeLabel'] ?? '';
$badge_text = $attributes['badgeText'] ?? '';
$paragraphs = $attributes['paragraphs'] ?? [];
?>
<section class="py-10 md:py-16 bg-surface">
  <div class="container-custom grid grid-cols-1 md:grid-cols-2 gap-20 items-start">
    <div data-animate="fade-right">
      <span class="text-secondary font-bold tracking-[0.2em] text-xs uppercase mb-4 block"><?php echo wp_kses_post($eyebrow); ?></span>
      <h2 class="text-primary text-h2 mb-4"><?php echo wp_kses_post($title_line1); ?><br><?php echo wp_kses_post($title_line2); ?></h2>
      <div class="inline-block px-4 py-2 bg-primary/5 border-l-4 border-secondary mt-4">
        <p class="text-primary font-bold text-sm uppercase tracking-wider">
          <?php echo wp_kses_post($badge_label); ?> <span class="text-on-surface-variant font-medium normal-case"><?php echo wp_kses_post($badge_text); ?></span>
        </p>
      </div>
    </div>
    <div class="space-y-6 text-on-surface-variant text-body-lg leading-relaxed" data-animate="fade-left">
      <?php foreach ($paragraphs as $paragraph) : ?>
        <p><?php echo wp_kses_post($paragraph); ?></p>
      <?php endforeach; ?>
    </div>
  </div>
</section>
