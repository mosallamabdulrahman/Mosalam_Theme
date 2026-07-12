<?php
/**
 * @var array $attributes
 */
$eyebrow = $attributes['eyebrow'] ?? '';
$title = $attributes['title'] ?? '';
$offices = $attributes['offices'] ?? [];
?>
<section class="py-10 md:py-16 bg-surface-container-low border-t border-black/5">
  <div class="container-custom">
    <div class="mb-16" data-animate="fade-up">
      <span class="text-secondary font-bold tracking-[0.2em] text-xs uppercase mb-4 block"><?php echo wp_kses_post($eyebrow); ?></span>
      <h2 class="text-h2 text-primary"><?php echo wp_kses_post($title); ?></h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8" data-animate-group="fade-up">
      <?php foreach ($offices as $office) : ?>
        <div class="bg-white p-10 shadow-sm hover:shadow-xl transition-all duration-500 group relative overflow-hidden hover:-translate-y-1" data-animate-item>
          <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
            <svg class="w-32 h-32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 4.9-8 12-8 12S4 14.9 4 10a8 8 0 1 1 16 0Z" /><circle cx="12" cy="10" r="3" /></svg>
          </div>
          <h4 class="text-tertiary text-[10px] font-bold uppercase tracking-[0.2em] mb-4"><?php echo esc_html($office['label']); ?></h4>
          <h3 class="text-h3 text-primary mb-6"><?php echo esc_html($office['city']); ?></h3>
          <p class="text-on-surface-variant text-body leading-relaxed mb-8 whitespace-pre-line"><?php echo wp_kses_post($office['address']); ?></p>
          <p class="text-primary font-bold tracking-wider"><?php echo esc_html($office['phone']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
