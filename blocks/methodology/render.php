<?php
/**
 * @var array $attributes
 */
$eyebrow = $attributes['eyebrow'] ?? '';
$title = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$steps = $attributes['steps'] ?? [];
?>
<section id="methodology" class="min-h-screen w-full relative cinematic-section bg-[#fcf9f8] py-10 md:py-16">
  <div class="container-custom w-full">
    <div class="max-w-3xl mb-16" data-animate="fade-up">
      <span class="text-overline-lg text-secondary mb-6 block"><?php echo wp_kses_post($eyebrow); ?></span>
      <h2 class="text-h2 text-[#001b35] mb-8"><?php echo wp_kses_post($title); ?></h2>
      <p class="text-body-lg text-on-surface-variant"><?php echo wp_kses_post($description); ?></p>
    </div>

    <div class="js-methodology-tabs w-full overflow-x-auto hide-scrollbar mb-12 border-b border-black/10 cursor-grab active:cursor-grabbing select-none" data-animate="fade-up">
      <div class="flex w-max min-w-full">
        <?php foreach ($steps as $index => $step) : ?>
          <button
            type="button"
            class="js-methodology-tab-btn min-w-[180px] md:min-w-[200px] flex-1 text-center pb-4 text-h4 transition-all duration-300 relative <?php echo 0 === $index ? 'text-[#001b35]' : 'text-on-surface-variant/50 hover:text-[#001b35]/70'; ?>"
            data-step-index="<?php echo (int) $index; ?>"
          >
            <span class="text-secondary mr-2 text-sm align-top"><?php echo esc_html($step['number']); ?></span>
            <?php echo esc_html($step['title']); ?>
            <span class="js-methodology-tab-underline absolute bottom-0 left-0 w-full h-1 bg-secondary <?php echo 0 === $index ? '' : 'hidden'; ?>"></span>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="bg-white shadow-xl border border-black/5 rounded-action overflow-hidden transition-all duration-500" data-animate="fade-up">
      <?php foreach ($steps as $index => $step) : ?>
        <div class="js-methodology-panel flex flex-col md:flex-row min-h-[400px] <?php echo 0 === $index ? '' : 'hidden'; ?>" data-step-index="<?php echo (int) $index; ?>">
          <div class="w-full md:w-1/2 p-12 flex flex-col justify-center">
            <span class="block text-h1 text-secondary/20 mb-4 font-mono"><?php echo esc_html($step['number']); ?></span>
            <h3 class="text-h2 text-[#001b35] mb-6"><?php echo esc_html($step['title']); ?></h3>
            <p class="text-body-lg text-on-surface-variant leading-relaxed"><?php echo wp_kses_post($step['description']); ?></p>
          </div>
          <div class="w-full md:w-1/2 h-64 md:h-auto relative overflow-hidden">
            <img src="<?php echo esc_url(MOSALAM_THEME_URI . '/assets/images/' . $step['image']); ?>" alt="<?php echo esc_attr($step['title']); ?>" class="w-full h-full object-cover" referrerpolicy="no-referrer">
            <div class="absolute inset-0 bg-[#001b35]/10 mix-blend-multiply"></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
