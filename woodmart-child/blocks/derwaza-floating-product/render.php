<?php
/**
 * Render template for the Derwaza Floating Product block.
 *
 * @var array $attributes
 */

$slides = $attributes['slides'] ?? [];
$autoplay_speed = $attributes['autoplaySpeed'] ?? 5000;

if (empty($slides)) {
    return;
}
?>
<div class="derwaza-floating-product-wrapper w-full max-w-[1200px] mx-auto px-4 relative z-20 -mt-12 md:-mt-20 lg:-mt-24 mb-10" data-animate="fade-in">
    <div class="swiper derwaza-floating-swiper rounded-[20px] bg-white shadow-xl overflow-hidden border border-black/5" data-autoplay="<?php echo esc_attr($autoplay_speed); ?>">
        <div class="swiper-wrapper">
            <?php foreach ($slides as $slide) : 
                $bg_color = $slide['bgColor'] ?? '#ffffff';
                $text_color = $slide['textColor'] ?? '#1b1c1c';
                $eyebrow = $slide['eyebrow'] ?? '';
                $title = $slide['title'] ?? '';
                $description = $slide['description'] ?? '';
                $price = $slide['price'] ?? '';
                $old_price = $slide['oldPrice'] ?? '';
                $discount = $slide['discount'] ?? '';
                $buy_link = $slide['buyLink'] ?? '#';
                $details_link = $slide['detailsLink'] ?? '#';
                $image_url = $slide['imageUrl'] ?? '';
                
                // Resolve local placeholders vs absolute uploads
                if (!empty($image_url) && strpos($image_url, '://') === false && strpos($image_url, '/') !== 0 && strpos($image_url, 'data:') !== 0) {
                    $theme_uri = defined('MOSALAM_THEME_URI') ? MOSALAM_THEME_URI : get_stylesheet_directory_uri();
                    $image_url = $theme_uri . '/assets/images/' . $image_url;
                }
                ?>
                <div class="swiper-slide" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
                    <div class="flex flex-col md:flex-row items-center justify-between p-8 md:p-12 lg:p-16 gap-8">
                        
                        <!-- Left Side: Product Info -->
                        <div class="w-full md:w-1/2 flex flex-col items-start text-left rtl:text-right z-10">
                            <?php if (!empty($eyebrow)) : ?>
                                <span class="text-xs font-bold text-amber-600 bg-amber-50 border border-amber-200/50 px-3 py-1.5 rounded-[6px] mb-4 uppercase tracking-wide">
                                    <?php echo esc_html($eyebrow); ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (!empty($title)) : ?>
                                <h3 class="text-2xl md:text-4xl font-bold leading-tight mb-4 text-gray-900">
                                    <?php echo esc_html($title); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if (!empty($description)) : ?>
                                <p class="text-sm md:text-base text-gray-600 mb-6 leading-relaxed whitespace-pre-line">
                                    <?php echo wp_kses_post($description); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Prices & Discount Badges -->
                            <div class="flex items-center gap-3 mb-6">
                                <?php if (!empty($price)) : ?>
                                    <span class="text-xl md:text-2xl font-bold text-gray-900">
                                        <?php echo esc_html($price); ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($old_price)) : ?>
                                    <span class="text-sm md:text-base line-through text-gray-400">
                                        <?php echo esc_html($old_price); ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($discount)) : ?>
                                    <span class="text-xs font-bold text-amber-700 bg-amber-100/70 border border-amber-200 px-2 py-0.5 rounded-[4px]">
                                        <?php echo esc_html($discount); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex flex-wrap gap-4 mt-2">
                                <?php if (!empty($buy_link)) : ?>
                                    <a href="<?php echo esc_url($buy_link); ?>" class="bg-[#8B5E3C] hover:bg-[#a06d48] text-white px-8 py-3 rounded-full text-xs md:text-sm font-bold tracking-wide transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                        Buy Now
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($details_link)) : ?>
                                    <a href="<?php echo esc_url($details_link); ?>" class="border border-gray-300 text-gray-700 hover:bg-gray-50 px-8 py-3 rounded-full text-xs md:text-sm font-bold tracking-wide transition-all duration-300 hover:-translate-y-0.5">
                                        View Details
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Right Side: Image -->
                        <div class="w-full md:w-1/2 flex items-center justify-center z-10 relative mt-4 md:mt-0">
                            <?php if (!empty($image_url)) : ?>
                                <img 
                                    src="<?php echo esc_url($image_url); ?>" 
                                    alt="<?php echo esc_attr($title); ?>" 
                                    class="max-h-[220px] md:max-h-[280px] lg:max-h-[340px] object-contain transition-transform duration-700 hover:scale-105 drop-shadow-[0_15px_35px_rgba(0,0,0,0.1)]"
                                    loading="lazy"
                                />
                            <?php endif; ?>
                        </div>
                        
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Custom Pagination -->
        <div class="swiper-pagination derwaza-floating-swiper-pagination !bottom-5"></div>

        <!-- Custom Navigation Buttons -->
        <div class="derwaza-floating-swiper-prev absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-full flex items-center justify-center transition-all duration-300 cursor-pointer select-none z-20 hover:scale-105 active:scale-95 border border-gray-200 shadow-sm">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
        </div>
        <div class="derwaza-floating-swiper-next absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-full flex items-center justify-center transition-all duration-300 cursor-pointer select-none z-20 hover:scale-105 active:scale-95 border border-gray-200 shadow-sm">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6" />
            </svg>
        </div>
    </div>
</div>
