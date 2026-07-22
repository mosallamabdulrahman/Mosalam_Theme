<?php
/**
 * @var array $attributes
 */
$eyebrow = $attributes['eyebrow'] ?? '';
$title = $attributes['title'] ?? '';
$members = $attributes['members'] ?? [];
?>
<section class="py-10 md:py-16 bg-surface-container-low border-t border-black/5">
  <div class="container-custom">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-4" data-animate="fade-up">
      <h2 class="text-h2 text-primary"><?php echo wp_kses_post($title); ?></h2>
      <span class="text-secondary font-bold uppercase tracking-[0.2em] text-xs"><?php echo wp_kses_post($eyebrow); ?></span>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8" data-animate-group="fade-up">
      <?php foreach ($members as $member) : ?>
        <div class="group cursor-pointer bg-white shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden" data-animate-item>
          <div class="aspect-[4/5] overflow-hidden bg-black/5 relative">
            <?php
            $image_url = $member['image'] ?? '';
            if ( ! empty( $image_url ) && ! preg_match( '~^(?:https?:)?/~i', $image_url ) ) {
                $image_url = MOSALAM_THEME_URI . '/' . $image_url;
            }
            ?>
            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 grayscale group-hover:grayscale-0" alt="<?php echo esc_attr($member['name']); ?>" src="<?php echo esc_url($image_url); ?>" referrerpolicy="no-referrer" loading="lazy">
            <div class="absolute inset-0 bg-primary/20 opacity-0 group-hover:opacity-100 transition-opacity mix-blend-overlay"></div>
          </div>
          <div class="p-6">
            <h4 class="text-h4 text-primary mb-1"><?php echo esc_html($member['name']); ?></h4>
            <p class="text-secondary text-[10px] font-bold uppercase tracking-widest"><?php echo esc_html($member['role']); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
