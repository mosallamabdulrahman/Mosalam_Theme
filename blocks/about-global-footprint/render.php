<?php
/**
 * @var array $attributes
 */
$eyebrow = $attributes['eyebrow'] ?? '';
$title = $attributes['title'] ?? '';
$offices = $attributes['offices'] ?? [];
$map_image = $attributes['mapImage'] ?? '';
$overlay_label = $attributes['overlayLabel'] ?? '';
$overlay_address = $attributes['overlayAddress'] ?? '';
$overlay_phone_label = $attributes['overlayPhoneLabel'] ?? '';
$overlay_phone = $attributes['overlayPhone'] ?? '';
$badge_text = $attributes['badgeText'] ?? '';
?>
<section id="location" class="py-32 bg-primary overflow-hidden relative">
  <div class="container-custom grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
    <div class="space-y-12" data-animate="fade-right">
      <div>
        <span class="text-secondary font-bold tracking-[0.2em] text-xs uppercase mb-4 block"><?php echo wp_kses_post($eyebrow); ?></span>
        <h2 class="text-white text-h1 leading-tight"><?php echo wp_kses_post($title); ?></h2>
      </div>
      <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-10 space-y-8">
        <?php foreach ($offices as $index => $office) : ?>
          <div class="<?php echo $index > 0 ? 'py-8 border-t border-white/10' : ''; ?>">
            <h4 class="text-tertiary text-[10px] font-bold uppercase tracking-[0.2em] mb-4"><?php echo wp_kses_post($office['label']); ?></h4>
            <p class="text-white text-2xl font-light leading-relaxed whitespace-pre-line"><?php echo wp_kses_post($office['text']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="relative" data-animate="fade-left">
      <div class="aspect-square bg-primary_container border border-white/10 relative group overflow-hidden shadow-2xl">
        <img class="w-full h-full object-cover opacity-60 mix-blend-luminosity" alt="Dark stylized technical map" src="<?php echo esc_url($map_image); ?>" referrerpolicy="no-referrer" loading="lazy">
        <div class="absolute inset-0 flex items-center justify-center p-8">
          <div class="w-full max-w-sm bg-surface p-8 shadow-2xl relative">
            <div class="mb-6">
              <h5 class="text-secondary text-[10px] font-bold uppercase tracking-widest mb-2"><?php echo wp_kses_post($overlay_label); ?></h5>
              <p class="text-primary text-sm font-medium leading-relaxed whitespace-pre-line"><?php echo wp_kses_post($overlay_address); ?></p>
            </div>
            <div>
              <h5 class="text-secondary text-[10px] font-bold uppercase tracking-widest mb-2"><?php echo wp_kses_post($overlay_phone_label); ?></h5>
              <p class="text-primary text-lg font-bold"><?php echo wp_kses_post($overlay_phone); ?></p>
            </div>
            <div class="absolute -top-4 -right-4 bg-tertiary text-white p-4 shadow-lg">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 4.9-8 12-8 12S4 14.9 4 10a8 8 0 1 1 16 0Z" /><circle cx="12" cy="10" r="3" /></svg>
            </div>
          </div>
        </div>
        <div class="absolute top-6 left-6 bg-secondary px-4 py-2 text-white text-[10px] font-bold uppercase tracking-[0.2em] shadow-lg">
          <?php echo wp_kses_post($badge_text); ?>
        </div>
      </div>
    </div>
  </div>
</section>
