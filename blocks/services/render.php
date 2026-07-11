<?php
/**
 * @var array $attributes
 */
$eyebrow = $attributes['eyebrow'] ?? '';
$title = $attributes['title'] ?? '';
$categories = $attributes['categories'] ?? [];
?>
<section id="services" class="min-h-screen w-full relative cinematic-section bg-[#001b35] py-24">
  <div class="container-custom w-full">
    <div class="max-w-3xl mb-16" data-animate="fade-up">
      <span class="text-overline-lg text-secondary mb-4 block"><?php echo wp_kses_post($eyebrow); ?></span>
      <h2 class="text-h1 text-white"><?php echo wp_kses_post($title); ?></h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-animate-group="fade-up">
      <?php foreach ($categories as $category) : ?>
        <div class="bg-white p-8 flex flex-col h-full border-t-4 border-secondary hover:-translate-y-2 hover:shadow-2xl transition-all duration-300" data-animate-item>
          <h3 class="text-h3 text-[#001b35] mb-4"><?php echo esc_html($category['title']); ?></h3>
          <p class="text-body-sm text-on-surface-variant mb-8"><?php echo wp_kses_post($category['description']); ?></p>
          <div>
            <h4 class="text-overline text-secondary mb-4">Specific Services</h4>
            <div class="flex flex-col gap-2">
              <?php foreach ($category['links'] as $link) : ?>
                <a href="<?php echo esc_url($link['url']); ?>" class="group flex items-center justify-between p-3 rounded-action bg-[#fcf9f8] hover:bg-[#001b35] transition-all duration-300">
                  <span class="text-body-sm font-medium text-[#001b35] group-hover:text-white transition-colors"><?php echo esc_html($link['label']); ?></span>
                  <svg class="w-4 h-4 text-secondary transform -translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14" /><path d="m12 5 7 7-7 7" /></svg>
                </a>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
