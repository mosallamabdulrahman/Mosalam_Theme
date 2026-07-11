<?php
/**
 * @var array $attributes
 */
$title = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$items = $attributes['items'] ?? [];
$highlight_label = $attributes['highlightLabel'] ?? '';
$highlight_title = $attributes['highlightTitle'] ?? '';
$highlight_description = $attributes['highlightDescription'] ?? '';
?>
<section class="py-32 bg-surface relative overflow-hidden">
  <div class="container-custom grid grid-cols-1 lg:grid-cols-12 gap-16 relative z-10">
    <div class="lg:col-span-5 relative" data-animate="fade-right">
      <div class="lg:sticky top-32">
        <h2 class="text-h2 text-primary mb-8"><?php echo wp_kses_post($title); ?></h2>
        <div class="w-16 h-1 bg-secondary mb-8"></div>
        <p class="text-on-surface-variant text-body-lg"><?php echo wp_kses_post($description); ?></p>
      </div>
    </div>
    <div class="lg:col-span-7 space-y-12" data-animate-group="fade-up">
      <?php foreach ($items as $item) : ?>
        <div class="group border-b border-black/5 pb-10 hover:-translate-y-1 transition-all duration-300" data-animate-item>
          <h3 class="text-h3 text-primary mb-4 flex items-center gap-4">
            <span class="text-secondary font-mono tracking-tighter"><?php echo esc_html($item['number']); ?></span> <?php echo esc_html($item['title']); ?>
          </h3>
          <p class="text-on-surface-variant text-body leading-relaxed pl-12"><?php echo wp_kses_post($item['description']); ?></p>
        </div>
      <?php endforeach; ?>

      <div class="p-10 bg-primary text-white relative overflow-hidden shadow-2xl mt-16 group" data-animate-item>
        <div class="absolute inset-0 bg-gradient-to-br from-secondary/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10">
          <div class="flex justify-between items-start mb-6">
            <svg class="w-10 h-10 text-secondary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.7 8.9a1 1 0 0 1-.6 0C7.5 20.5 4 18 4 13V6a1 1 0 0 1 .6-.9l7-3a1 1 0 0 1 .8 0l7 3a1 1 0 0 1 .6.9Z" /><path d="m9 12 2 2 4-4" /></svg>
            <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-white/50"><?php echo esc_html($highlight_label); ?></span>
          </div>
          <h4 class="text-h3 mb-4"><?php echo wp_kses_post($highlight_title); ?></h4>
          <p class="text-white/80 font-light text-body-lg leading-relaxed"><?php echo wp_kses_post($highlight_description); ?></p>
        </div>
      </div>
    </div>
  </div>
</section>
