<?php
/**
 * @var array $attributes
 */
$eyebrow = $attributes['eyebrow'] ?? '';
$title = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$background_image = $attributes['backgroundImage'] ?? '';
if ( empty( $background_image ) || strpos( $background_image, 'googleusercontent.com' ) !== false || strpos( $background_image, 'unsplash.com' ) !== false ) {
    $background_image = MOSALAM_THEME_URI . '/assets/images/digital-matrix-background.webp';
}
$features = $attributes['features'] ?? [];
?>
<section id="ai" class="min-h-screen w-full relative cinematic-section text-white py-10 md:py-16">
  <div class="cinematic-bg">
    <img class="w-full h-full object-cover" alt="digital matrix background" src="<?php echo esc_url($background_image); ?>" referrerpolicy="no-referrer">
    <div class="absolute inset-0 bg-[#001b35]/90"></div>
  </div>
  <div class="cinematic-content container-custom w-full">
    <div class="max-w-3xl" data-animate="fade-up">
      <span class="text-overline-lg text-secondary-fixed mb-6 block"><?php echo wp_kses_post($eyebrow); ?></span>
      <h2 class="text-h1 mb-8"><?php echo wp_kses_post($title); ?></h2>
      <p class="text-body-lg text-white/70 mb-10 md:mb-16"><?php echo wp_kses_post($description); ?></p>
      <div class="flex flex-col gap-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12" data-animate-group="fade-up">
          <?php foreach ($features as $feature) : ?>
            <div class="border-l border-white/20 pl-8" data-animate-item>
              <h4 class="text-h4 mb-4"><?php echo esc_html($feature['title']); ?></h4>
              <p class="text-body-sm text-white/50"><?php echo wp_kses_post($feature['description']); ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
