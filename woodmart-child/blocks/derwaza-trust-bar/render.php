<?php
/**
 * Render template for the Derwaza Trust Bar block.
 *
 * @var array $attributes
 */

$items = $attributes['items'] ?? [];
$bg_color = $attributes['bgColor'] ?? '#ffffff';
$text_color = $attributes['textColor'] ?? '#1b1c1c';
$icon_color = $attributes['iconColor'] ?? '#8B5E3C';

if (empty($items)) {
    return;
}
?>
<div class="derwaza-trust-bar-wrapper w-full max-w-[1200px] mx-auto px-4 relative z-10 mb-10" data-animate="fade-in">
    <div 
        class="rounded-[20px] shadow-[0_10px_35px_rgba(0,0,0,0.05)] border border-black/[0.04] p-5 md:p-6 transition-all duration-300"
        style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
    >
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-y-6 lg:gap-y-0 lg:divide-x lg:divide-black/10 rtl:lg:divide-x-reverse">
            <?php foreach ($items as $item) : 
                $title = $item['title'] ?? '';
                $subtitle = $item['subtitle'] ?? '';
                $icon_svg = $item['iconSvg'] ?? '';
                ?>
                <div class="flex items-center gap-4 py-2 px-6 lg:justify-center">
                    
                    <!-- SVG Icon -->
                    <?php if (!empty($icon_svg)) : ?>
                        <div 
                            class="flex-shrink-0 w-8 h-8 flex items-center justify-center derwaza-trust-icon"
                            style="color: <?php echo esc_attr($icon_color); ?>;"
                        >
                            <?php echo $icon_svg; // Raw SVG output as requested ?>
                        </div>
                    <?php endif; ?>

                    <!-- Text Container -->
                    <div class="flex flex-col">
                        <span class="font-bold text-sm md:text-base leading-tight">
                            <?php echo esc_html($title); ?>
                        </span>
                        <span class="text-xs opacity-75 mt-0.5">
                            <?php echo esc_html($subtitle); ?>
                        </span>
                    </div>
                    
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
