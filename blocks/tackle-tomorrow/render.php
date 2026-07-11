<?php
/**
 * @var array $attributes
 */
$title = $attributes['title'] ?? '';
$cards = $attributes['cards'] ?? [];
?>
<section class="w-full relative bg-secondary text-white text-center py-16 md:py-20 lg:py-24">
  <div class="container-custom">
    <div class="mx-auto">
      <h2 class="text-h1 mb-10 md:mb-12" data-animate="fade-up"><?php echo wp_kses_post($title); ?></h2>
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 md:gap-8 text-left" data-animate-group="fade-up">
        <?php foreach ($cards as $index => $card) : ?>
          <div class="p-6 md:p-8 lg:p-10 border border-white/20 hover:bg-white/5 transition-all <?php echo 2 === $index ? 'md:col-span-2 xl:col-span-1' : ''; ?>" data-animate-item>
            <h3 class="text-h3 mb-4"><?php echo esc_html($card['title']); ?></h3>
            <p class="text-white/70 text-body-sm mb-8"><?php echo wp_kses_post($card['description']); ?></p>
            <button type="button" class="flex items-center gap-4 text-overline group">
              <?php echo esc_html($card['ctaLabel']); ?>
              <svg class="w-4 h-4 group-hover:translate-x-2 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14" /><path d="m12 5 7 7-7 7" /></svg>
            </button>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
