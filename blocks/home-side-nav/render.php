<?php
/**
 * @var array $attributes
 * Fixed left-side section nav (desktop only). Active-section highlighting,
 * tone (light/dark) switching and hide-near-footer behavior are handled by
 * assets/js/theme.js via IntersectionObserver.
 */
$items = $attributes['items'] ?? [];
?>
<nav id="home-side-nav" class="js-side-nav fixed left-0 top-1/2 -translate-y-1/2 z-50 hidden xl:block pl-3 w-36 overflow-visible">
  <ul class="relative flex flex-col">
    <?php foreach ($items as $index => $item) :
        $is_active = 0 === $index;
        $is_dark = 'light' === $item['tone'];
        $bar_tone_class = $is_dark
            ? 'bg-[#001b35] shadow-[0_0_12px_rgba(0,27,53,0.18)]'
            : 'bg-white shadow-[0_0_12px_rgba(255,255,255,0.55)]';
        $label_tone_class = $is_dark
            ? 'text-white bg-[#001b35]/90 backdrop-blur-xl drop-shadow-[0_2px_10px_rgba(255,255,255,0.15)]'
            : 'text-white bg-[#001b35]/80 backdrop-blur-xl drop-shadow-[0_2px_10px_rgba(0,27,53,0.95)]';
        ?>
      <li
        class="js-side-nav-item group relative flex flex-col transition-all duration-500 <?php echo $is_active ? 'mb-16 mt-4' : 'mb-12'; ?>"
        data-index="<?php echo (int) $index; ?>"
        data-target="<?php echo esc_attr($item['target']); ?>"
        data-tone="<?php echo esc_attr($item['tone']); ?>"
        data-active="<?php echo $is_active ? '1' : '0'; ?>"
      >
        <a href="#<?php echo esc_attr($item['target']); ?>" class="js-side-nav-link flex flex-col justify-center py-2 relative">
          <div class="js-side-nav-bar h-[3px] transition-all duration-500 ease-out <?php echo $is_active ? 'w-20' : 'w-10 group-hover:w-16'; ?> <?php echo esc_attr($bar_tone_class); ?>"></div>
          <span class="js-side-nav-label text-[11px] font-bold tracking-wide leading-tight max-w-[6.75rem] whitespace-normal transition-all duration-500 ease-out absolute top-full mt-1 left-0 rounded-action px-1.5 py-1 shadow-[0_8px_22px_rgba(0,27,53,0.28)] <?php echo $is_active ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-2 group-hover:opacity-100 group-hover:translate-y-0'; ?> <?php echo esc_attr($label_tone_class); ?>">
            <?php echo esc_html($item['label']); ?>
          </span>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>
