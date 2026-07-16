<?php
/**
 * Render template for the Derwaza Hero Slider block.
 *
 * @var array $attributes
 */

$slides = $attributes['slides'] ?? [];
$autoplay_speed = $attributes['autoplaySpeed'] ?? 5000;

if (empty($slides)) {
    return;
}
?>
<div class="derwaza-slider-wrapper w-full  mx-auto rounded-b-[20px] overflow-hidden shadow-lg" data-animate="fade-in">
    <div class="swiper derwaza-swiper relative" data-autoplay="<?php echo esc_attr($autoplay_speed); ?>">
        <div class="swiper-wrapper">
            <?php foreach ($slides as $slide) : 
                $bg_color = $slide['bgColor'] ?? '#1a1a15';
                $text_color = $slide['textColor'] ?? '#ffffff';
                $eyebrow = $slide['eyebrow'] ?? '';
                $title = $slide['title'] ?? '';
                $btn_text = $slide['btnText'] ?? '';
                $btn_link = $slide['btnLink'] ?? '';
                $image_url = $slide['imageUrl'] ?? '';
                
                // Resolve local placeholders vs absolute uploads
                if (!empty($image_url) && strpos($image_url, '://') === false && strpos($image_url, '/') !== 0 && strpos($image_url, 'data:') !== 0) {
                    $image_url = MOSALAM_THEME_URI . '/assets/images/' . $image_url;
                }
                ?>
                <div class="swiper-slide relative overflow-hidden flex items-center min-h-[280px] md:min-h-[360px] lg:min-h-[420px] px-6 py-8 md:px-16 md:py-12 lg:px-24 lg:py-16" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
                    
                    <!-- Cover Background Image -->
                    <?php if (!empty($image_url)) : ?>
                        <img 
                            src="<?php echo esc_url($image_url); ?>" 
                            alt="<?php echo esc_attr($title); ?>" 
                            class="absolute inset-0 w-full h-full object-cover object-center z-0"
                            loading="eager"
                        />
                        <!-- Gradient Overlay for Legibility -->
                        <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/45 to-transparent rtl:bg-gradient-to-l z-10"></div>
                    <?php else : ?>
                        <div class="absolute inset-0 bg-gradient-to-tr from-black/30 to-black/5 z-0"></div>
                    <?php endif; ?>
                    
                    <!-- Content Container -->
                    <div class="w-full max-w-4xl flex flex-col items-start text-left rtl:text-right z-20 relative">
                        <?php if (!empty($eyebrow)) : ?>
                            <span class="text-xs md:text-sm font-semibold tracking-wider text-amber-500 mb-3 uppercase">
                                <?php echo esc_html($eyebrow); ?>
                            </span>
                        <?php endif; ?>
                        
                        <?php if (!empty($title)) : ?>
                            <h2 class="text-2xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6 max-w-2xl text-white">
                                <?php echo wp_kses_post($title); ?>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if (!empty($btn_text)) : ?>
                            <a href="<?php echo esc_url($btn_link); ?>" class="bg-[#8B5E3C] hover:bg-[#a06d48] text-white px-8 py-3.5 rounded-full text-xs md:text-sm font-bold tracking-wide transition-all duration-300 inline-flex items-center gap-2 mt-2 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                                <span><?php echo esc_html($btn_text); ?></span>
                                <svg class="w-4 h-4 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Custom Pagination (Dots) -->
        <div class="swiper-pagination derwaza-swiper-pagination !bottom-6"></div>

        <!-- Custom Navigation Buttons (Pure SVG, Custom Classes to avoid Swiper character overlaps) -->
        <div class="derwaza-swiper-btn-prev absolute left-6 top-1/2 -translate-y-1/2 w-11 h-11 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-all duration-300 backdrop-blur-md cursor-pointer select-none z-20 hover:scale-105 active:scale-95 border border-white/10">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
        </div>
        <div class="derwaza-swiper-btn-next absolute right-6 top-1/2 -translate-y-1/2 w-11 h-11 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-all duration-300 backdrop-blur-md cursor-pointer select-none z-20 hover:scale-105 active:scale-95 border border-white/10">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6" />
            </svg>
        </div>
    </div>
</div>
