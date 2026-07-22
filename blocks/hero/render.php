<?php
/**
 * @var array $attributes
 */
$eyebrow = $attributes['eyebrow'] ?? '';
$title = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$cta_label = $attributes['ctaLabel'] ?? '';
$background_image = $attributes['backgroundImage'] ?? '';
if ( empty( $background_image ) || $background_image === 'abstract-high-tech-digital-background.webp' ) {
    $background_image = MOSALAM_THEME_URI . '/assets/images/abstract-high-tech-digital-background.webp';
}
$scroll_label = $attributes['scrollLabel'] ?? '';
?>
<section id="hero" class="w-full h-[600px] relative flex flex-col">
  <div class="flex-grow relative flex items-center w-full overflow-hidden">
    <div class="cinematic-bg absolute inset-0">
      <img class="w-full h-full object-cover" alt="abstract high-tech digital background" src="<?php echo esc_url($background_image); ?>" referrerpolicy="no-referrer" loading="eager" fetchpriority="high">
      <div class="absolute inset-0 bg-black/40"></div>
    </div>
    <div class="cinematic-content container-custom py-6 md:py-12">
      <div class="max-w-4xl" data-animate-group="fade-up">
        <span class="text-overline-lg text-secondary-fixed mb-8 block" data-animate-item><?php echo wp_kses_post($eyebrow); ?></span>
        <h1 class="text-h1 text-white mb-8" data-animate-item><?php echo wp_kses_post($title); ?></h1>
        <p class="text-body-lg text-white/80 mb-12 max-w-2xl" data-animate-item><?php echo wp_kses_post($description); ?></p>
        <div class="flex gap-6" data-animate-item>
          <button type="button" class="js-scroll-next bg-secondary text-white px-10 py-5 rounded-action text-overline-lg hover:bg-white hover:text-secondary transition-all flex items-center gap-4 group" data-scroll-target="clients">
            <?php echo wp_kses_post($cta_label); ?>
            <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14" /><path d="m12 5 7 7-7 7" /></svg>
          </button>
        </div>
      </div>
    </div>
    <button
      type="button"
      class="js-scroll-next absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-4 text-white/60 hover:text-white z-20 transition-all duration-500 group hover:-translate-y-1"
      aria-label="Scroll to the next section"
      data-scroll-target="clients"
    >
      <span class="text-[10px] uppercase tracking-[0.3em] transition-all duration-500 group-hover:text-secondary-fixed group-hover:tracking-[0.45em]"><?php echo esc_html($scroll_label); ?></span>
      <span class="w-[2px] h-12 bg-white/20 relative overflow-hidden transition-all duration-500 group-hover:h-13 group-hover:bg-white/35">
        <span class="absolute inset-x-0 top-0 h-10 bg-secondary-fixed animate-bounce shadow-[0_0_18px_rgba(221,225,255,0.85)]"></span>
      </span>
    </button>
  </div>
</section>
