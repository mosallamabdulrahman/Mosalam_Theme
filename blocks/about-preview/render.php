<?php
/**
 * @var array $attributes
 */
$eyebrow = $attributes['eyebrow'] ?? '';
$title = $attributes['title'] ?? '';
$paragraph1 = $attributes['paragraph1'] ?? '';
$paragraph2 = $attributes['paragraph2'] ?? '';
$image = $attributes['image'] ?? '';
$stats = $attributes['stats'] ?? [];
?>
<section id="about" class="min-h-screen w-full relative cinematic-section bg-white py-24">
  <div class="container-custom w-full">
    <div class="flex flex-col lg:flex-row gap-16 items-center">
      <div class="w-full lg:w-1/2" data-animate="fade-right">
        <span class="text-overline-lg text-secondary mb-6 block"><?php echo wp_kses_post($eyebrow); ?></span>
        <h2 class="text-h2 text-[#001b35] mb-8"><?php echo wp_kses_post($title); ?></h2>
        <p class="text-body-lg text-on-surface-variant mb-6"><?php echo wp_kses_post($paragraph1); ?></p>
        <p class="text-body-lg text-on-surface-variant mb-12"><?php echo wp_kses_post($paragraph2); ?></p>
        <div class="grid grid-cols-2 gap-8" data-animate-group="fade-up">
          <?php foreach ($stats as $stat) : ?>
            <div class="border-l-4 border-secondary pl-6" data-animate-item>
              <h4 class="text-h1 text-[#001b35] mb-2"><?php echo esc_html($stat['value']); ?></h4>
              <p class="text-body-sm text-on-surface-variant"><?php echo esc_html($stat['label']); ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="w-full lg:w-1/2 h-[600px] relative" data-animate="fade-left">
        <img class="w-full h-full object-cover rounded-lg shadow-2xl" alt="Team collaboration" src="<?php echo esc_url($image); ?>" referrerpolicy="no-referrer">
        <div class="absolute inset-0 bg-[#001b35]/10 rounded-lg"></div>
      </div>
    </div>
  </div>
</section>
