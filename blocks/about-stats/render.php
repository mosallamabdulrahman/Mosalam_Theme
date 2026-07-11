<?php
/**
 * @var array $attributes
 */
$items = $attributes['items'] ?? [];
?>
<section class="py-24 bg-surface-container-low">
  <div class="container-custom">
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-[2px] bg-outline-variant/20 shadow-sm overflow-hidden" data-animate-group="fade-up">
      <?php foreach ($items as $item) : ?>
        <div class="bg-white p-10 flex flex-col justify-between aspect-square hover:bg-surface-container-low transition-colors duration-500" data-animate-item>
          <span class="text-on-surface-variant text-sm font-medium"><?php echo esc_html($item['label']); ?></span>
          <div class="space-y-2">
            <span class="block text-4xl font-black <?php echo !empty($item['highlight']) ? 'text-secondary' : 'text-primary'; ?>"><?php echo esc_html($item['value']); ?></span>
            <span class="block text-on-surface-variant text-[10px] uppercase tracking-widest gap-2"><?php echo esc_html($item['sublabel']); ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
