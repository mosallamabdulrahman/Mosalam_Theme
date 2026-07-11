<?php
/**
 * @var array $attributes
 */
$eyebrow = $attributes['eyebrow'] ?? '';
$title = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$sectors = $attributes['sectors'] ?? [];
?>
<section id="sectors" class="min-h-screen w-full relative cinematic-section bg-[#fcf9f8]">
  <div class="cinematic-bg flex flex-col">
    <div class="h-1/2 flex flex-col md:flex-row" data-animate-group="fade-in">
      <?php foreach ($sectors as $sector) : ?>
        <div class="w-full md:w-1/4 h-64 md:h-full relative overflow-hidden group" data-animate-item>
          <img class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000" src="<?php echo esc_url($sector['image']); ?>" referrerpolicy="no-referrer" alt="<?php echo esc_attr($sector['title']); ?>">
          <div class="absolute inset-0 bg-[#001b35]/60 flex items-end p-12">
            <div>
              <h4 class="text-white text-h3 mb-4"><?php echo esc_html($sector['title']); ?></h4>
              <p class="text-white/60 text-body-sm opacity-0 group-hover:opacity-100 transition-opacity"><?php echo esc_html($sector['description']); ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="h-1/2 flex items-center justify-center pad-element bg-white">
      <div class="container-custom flex justify-center w-full">
        <div class="max-w-4xl text-center" data-animate="fade-up">
          <span class="text-overline-lg text-secondary mb-8 block"><?php echo wp_kses_post($eyebrow); ?></span>
          <h2 class="text-h2 text-[#001b35] mb-8"><?php echo wp_kses_post($title); ?></h2>
          <p class="text-body-lg text-on-surface-variant"><?php echo wp_kses_post($description); ?></p>
        </div>
      </div>
    </div>
  </div>
</section>
