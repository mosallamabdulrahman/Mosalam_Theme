<?php
/**
 * @var array $attributes
 */
$eyebrow = $attributes['eyebrow'] ?? '';
$title_line1 = $attributes['titleLine1'] ?? '';
$title_line2 = $attributes['titleLine2'] ?? '';
$description = $attributes['description'] ?? '';
$background_image = $attributes['backgroundImage'] ?? '';
?>
<section class="relative h-[450px] flex items-center overflow-hidden bg-primary">
  <div class="absolute inset-0 z-0">
    <img class="w-full h-full object-cover opacity-40 mix-blend-overlay" alt="Sophisticated server room with deep blue ambient lighting" src="<?php echo esc_url($background_image); ?>" referrerpolicy="no-referrer">
    <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/80 to-transparent"></div>
  </div>
  <div class="relative z-10 container-custom w-full py-10 md:py-16">
    <div class="max-w-3xl py-10 md:py-16" data-animate-group="fade-up">
      <span class="text-tertiary font-bold tracking-[0.2em] text-xs uppercase mb-6 block" data-animate-item><?php echo wp_kses_post($eyebrow); ?></span>
      <h1 class="text-white text-h1 mb-4 flex flex-col" data-animate-item>
        <span><?php echo wp_kses_post($title_line1); ?></span>
        <span class="text-secondary text-sm font-bold tracking-[0.3em] uppercase mt-2"><?php echo wp_kses_post($title_line2); ?></span>
      </h1>
      <p class="text-white/80 text-body-lg font-light leading-relaxed" data-animate-item><?php echo wp_kses_post($description); ?></p>
    </div>
  </div>
</section>
