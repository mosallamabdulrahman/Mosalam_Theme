<?php
/**
 * @var array $attributes
 */
$cards = $attributes['cards'] ?? [];

function mosalam_amv_offset_class($index)
{
    if (1 === $index) {
        return 'lg:-mt-12';
    }
    if (2 === $index) {
        return 'lg:mt-12';
    }
    return '';
}
?>
<section class="py-32 bg-surface-container-low">
  <div class="container-custom p-0 md:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" data-animate-group="fade-up">
      <?php foreach ($cards as $index => $card) :
          $is_dark = !empty($card['dark']);
          ?>
        <div class="p-12 aspect-[4/5] flex flex-col justify-between relative overflow-hidden group <?php echo esc_attr(mosalam_amv_offset_class($index)); ?> <?php echo $is_dark ? 'bg-primary text-white shadow-2xl z-10' : 'bg-white shadow-sm'; ?>" data-animate-item>
          <?php if ($is_dark) : ?>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-primary_container opacity-50"></div>
          <?php endif; ?>
          <span class="font-black text-8xl absolute top-8 right-8 group-hover:scale-110 transition-transform duration-700 <?php echo $is_dark ? 'text-white/5' : 'text-primary/5'; ?>"><?php echo esc_html($card['number']); ?></span>
          <div class="relative z-10 mt-auto">
            <h3 class="text-h3 mb-6 <?php echo $is_dark ? '' : 'text-primary'; ?>"><?php echo esc_html($card['title']); ?></h3>
            <p class="leading-relaxed text-body <?php echo $is_dark ? 'text-slate-300' : 'text-on-surface-variant'; ?>"><?php echo wp_kses_post($card['description']); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
