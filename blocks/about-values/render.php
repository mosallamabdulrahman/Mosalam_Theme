<?php
/**
 * @var array $attributes
 */
$eyebrow = $attributes['eyebrow'] ?? '';
$title = $attributes['title'] ?? '';
$values = $attributes['values'] ?? [];

function mosalam_value_icon_paths($name)
{
    $icons = [
        'shield' => '<path d="M20 13c0 5-3.5 7.5-7.7 8.9a1 1 0 0 1-.6 0C7.5 20.5 4 18 4 13V6a1 1 0 0 1 .6-.9l7-3a1 1 0 0 1 .8 0l7 3a1 1 0 0 1 .6.9Z" /><path d="m9 12 2 2 4-4" />',
        'heart' => '<path d="M19.5 12.6 12 20l-7.5-7.4A5 5 0 0 1 12 5a5 5 0 0 1 7.5 7.6Z" />',
        'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M22 21v-2a4 4 0 0 0-3-3.9" /><path d="M16 3.1a4 4 0 0 1 0 7.8" />',
        'zap' => '<path d="M13 2 3 14h9l-1 8 10-12h-9Z" />',
        'home' => '<path d="m3 11 9-9 9 9" /><path d="M5 10v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V10" /><path d="M9 21v-6h6v6" />',
    ];

    return $icons[$name] ?? $icons['shield'];
}
?>
<section class="py-32 bg-surface">
  <div class="container-custom text-center mb-20" data-animate="fade-up">
    <span class="text-secondary font-bold tracking-[0.2em] text-xs uppercase mb-4 block"><?php echo wp_kses_post($eyebrow); ?></span>
    <h2 class="text-h2 text-primary"><?php echo wp_kses_post($title); ?></h2>
  </div>
  <div class="container-custom grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-y-16 gap-x-8" data-animate-group="fade-up">
    <?php foreach ($values as $value) : ?>
      <div class="text-center group" data-animate-item>
        <div class="w-20 h-20 bg-surface-container-low flex items-center justify-center mx-auto mb-8 group-hover:bg-secondary group-hover:text-white transition-all duration-500 rounded-none">
          <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo mosalam_value_icon_paths($value['icon']); ?></svg>
        </div>
        <h4 class="font-bold text-primary mb-4 text-h4"><?php echo esc_html($value['title']); ?></h4>
        <p class="text-sm text-on-surface-variant leading-relaxed max-w-[200px] mx-auto"><?php echo wp_kses_post($value['description']); ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>
