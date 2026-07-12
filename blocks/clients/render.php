<?php
/**
 * @var array $attributes
 */
$eyebrow = $attributes['eyebrow'] ?? '';
$title = $attributes['title'] ?? '';
$clients = $attributes['clients'] ?? [];
?>
<section id="clients" class="w-full relative bg-white py-10 md:py-16 border-b border-black/5">
  <div class="container-custom w-full">
    <div class="text-center mb-12" data-animate="fade-up">
      <span class="text-overline-lg text-secondary mb-4 block"><?php echo wp_kses_post($eyebrow); ?></span>
      <h2 class="text-h2 text-[#001b35]"><?php echo wp_kses_post($title); ?></h2>
    </div>
    <div class="flex flex-wrap justify-center items-center gap-12 md:gap-24 opacity-60 grayscale" data-animate-group="fade-in">
      <?php foreach ($clients as $client) : ?>
        <div class="text-2xl font-bold font-mono text-[#001b35]" data-animate-item><?php echo esc_html($client); ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
