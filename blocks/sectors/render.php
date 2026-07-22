<?php
/**
 * @var array $attributes
 */
$eyebrow = $attributes['eyebrow'] ?? '';
$title = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$sectors = $attributes['sectors'] ?? [];
?>
<section id="sectors" class="w-full relative lg:min-h-screen bg-[#fcf9f8] flex flex-col justify-between">
  <div class="w-full flex flex-col h-full justify-between">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:flex lg:flex-row w-full" data-animate-group="fade-in">
      <?php foreach ($sectors as $sector) :
          $sector_image = $sector['image'];
          if ( empty( $sector_image ) || strpos( $sector_image, 'googleusercontent.com' ) !== false || strpos( $sector_image, 'unsplash.com' ) !== false ) {
              $slug = strtolower( trim( preg_replace('/[^A-Za-z0-9-]+/', '-', $sector['title']) ) );
              $sector_image = MOSALAM_THEME_URI . '/assets/images/' . $slug . '.webp';
          }
      ?>
        <div class="w-full lg:w-1/4 h-64 sm:h-80 lg:h-[50vh] relative overflow-hidden group" data-animate-item>
          <img class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000" src="<?php echo esc_url($sector_image); ?>" referrerpolicy="no-referrer" alt="<?php echo esc_attr($sector['title']); ?>" loading="lazy">
          <div class="absolute inset-0 bg-primary/60 flex items-end p-12">
            <div>
              <h4 class="text-white text-h3 mb-4"><?php echo esc_html($sector['title']); ?></h4>
              <p class="text-white/60 text-body-sm opacity-0 group-hover:opacity-100 transition-opacity"><?php echo esc_html($sector['description']); ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="flex items-center justify-center py-16 md:py-24 lg:h-[50vh] lg:py-0 bg-white w-full">
      <div class="container-custom flex justify-center w-full">
        <div class="max-w-4xl text-center" data-animate="fade-up">
          <span class="text-overline-lg text-secondary mb-8 block"><?php echo wp_kses_post($eyebrow); ?></span>
          <h2 class="text-h2 text-primary mb-8"><?php echo wp_kses_post($title); ?></h2>
          <p class="text-body-lg text-on-surface-variant"><?php echo wp_kses_post($description); ?></p>
        </div>
      </div>
    </div>
  </div>
</section>
