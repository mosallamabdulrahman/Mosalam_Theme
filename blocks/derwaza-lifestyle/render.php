<?php
/**
 * Render template for the Derwaza Shop by Lifestyle block.
 *
 * @var array $attributes
 */

$section_title = $attributes['sectionTitle'] ?? 'Shop by Lifestyle';
$items         = $attributes['items'] ?? [];

if (empty($items)) {
    return;
}

$theme_uri = MOSALAM_THEME_URI;
$def_images = [
    $theme_uri . '/assets/images/portfolio/life-travel.png',
    $theme_uri . '/assets/images/portfolio/life-office.png',
    $theme_uri . '/assets/images/portfolio/life-fitness.png',
    $theme_uri . '/assets/images/portfolio/life-smart.png',
    $theme_uri . '/assets/images/portfolio/life-car.png'
];
?>

<div class="derwaza-lifestyle-wrapper w-full max-w-[1400px] mx-auto px-4 md:px-6 relative z-10 mb-12" data-animate="fade-up" data-animate-delay="150">
    
    <?php if (!empty($section_title)) : ?>
        <h2 class="text-xl md:text-2xl font-extrabold text-[#111111] mb-6 font-sans">
            <?php echo esc_html($section_title); ?>
        </h2>
    <?php endif; ?>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 font-sans">
        <?php foreach ($items as $idx => $item) : 
            $title       = $item['title'] ?? '';
            $link_label  = $item['linkLabel'] ?? 'Shop Now';
            $link_url    = $item['linkUrl'] ?? '#';
            $bg_color    = $item['bgColor'] ?? '#eedec9';
            $fallback    = $def_images[$idx] ?? '';
            $image_url   = !empty($item['imageUrl']) ? $item['imageUrl'] : $fallback;
            ?>
            <a 
                href="<?php echo esc_url($link_url); ?>" 
                class="group relative overflow-hidden bg-white border border-[#eceef1] rounded-[20px] flex flex-col h-auto shadow-sm hover:shadow-md transition-all duration-300"
            >
                <!-- Top Image -->
                <div class="relative w-full aspect-[16/10] overflow-hidden bg-gray-50">
                    <img 
                        src="<?php echo esc_url($image_url); ?>" 
                        alt="<?php echo esc_attr($title); ?>" 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        referrerpolicy="no-referrer"
                    />
                </div>
                
                <!-- Bottom Custom Strip -->
                <div 
                    class="p-3.5 flex flex-col items-center justify-center text-center transition-colors duration-300"
                    style="background-color: <?php echo esc_attr($bg_color); ?>;"
                >
                    <span class="font-extrabold text-[13px] md:text-[14px] text-[#111111] leading-tight line-clamp-1">
                        <?php echo esc_html($title); ?>
                    </span>
                    <span class="text-[10px] md:text-[11px] font-extrabold text-[#8c8c8c] mt-1 group-hover:text-[#111111] transition-colors duration-300 uppercase tracking-wider">
                        <?php echo esc_html($link_label); ?>
                    </span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php
