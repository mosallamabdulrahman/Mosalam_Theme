<?php
/**
 * @var array $attributes
 */
$eyebrow = $attributes['eyebrow'] ?? '';
$title = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$background_image = $attributes['backgroundImage'] ?? '';
?>
<section class="relative h-[450px] flex items-center overflow-hidden bg-primary">
  <div class="absolute inset-0 z-0">
    <img class="w-full h-full object-cover opacity-30 mix-blend-overlay" alt="High-end architectural office interior" src="<?php echo esc_url($background_image); ?>" referrerpolicy="no-referrer">
    <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/90 to-primary/40"></div>
  </div>
  <div class="relative z-10 container-custom w-full py-24">
    <div class="max-w-3xl py-24" data-animate-group="fade-up">
      <span class="text-tertiary font-bold tracking-[0.2em] text-xs uppercase mb-6 block" data-animate-item><?php echo wp_kses_post($eyebrow); ?></span>
      <h1 class="text-white text-h1 mb-8" data-animate-item><?php echo wp_kses_post($title); ?></h1>
      <p class="text-white/80 text-body-lg font-light leading-relaxed" data-animate-item><?php echo wp_kses_post($description); ?></p>
    </div>
  </div>
</section>
