<?php
/**
 * Render template for the Derwaza Deals by Category block.
 *
 * @var array $attributes
 */

$theme_uri = MOSALAM_THEME_URI;
$def_img1 = $theme_uri . '/assets/images/portfolio/tech-strip-default.png';
$def_img2 = $theme_uri . '/assets/images/portfolio/beauty-strip-default.png';
$def_img3 = $theme_uri . '/assets/images/portfolio/kitchen-strip-default.png';

// Column 1
$col1_title     = $attributes['col1Title'] ?? 'Deals by Category';
$col1_sub       = $attributes['col1Subtitle'] ?? 'Top offers on electronics';
$col1_btn_label = $attributes['col1BtnLabel'] ?? 'View All';
$col1_btn_url   = $attributes['col1BtnUrl'] ?? '#';
$col1_image     = !empty($attributes['col1Image']) ? $attributes['col1Image'] : $def_img1;

// Column 2
$col2_title     = $attributes['col2Title'] ?? 'Beauty Deals';
$col2_sub       = $attributes['col2Subtitle'] ?? 'Best beauty offers';
$col2_btn_label = $attributes['col2BtnLabel'] ?? 'View All';
$col2_btn_url   = $attributes['col2BtnUrl'] ?? '#';
$col2_image     = !empty($attributes['col2Image']) ? $attributes['col2Image'] : $def_img2;

// Column 3
$col3_title     = $attributes['col3Title'] ?? 'Home & Kitchen Deals';
$col3_sub       = $attributes['col3Subtitle'] ?? 'Great home deals';
$col3_btn_label = $attributes['col3BtnLabel'] ?? 'View All';
$col3_btn_url   = $attributes['col3BtnUrl'] ?? '#';
$col3_image     = !empty($attributes['col3Image']) ? $attributes['col3Image'] : $def_img3;
?>

<div class="derwaza-deals-wrapper w-full max-w-[1400px] mx-auto px-4 md:px-6 relative z-10 mb-10" data-animate="fade-up" data-animate-delay="150">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 font-sans">

        <!-- Column 1 Card -->
        <div class="bg-white border border-[#eceef1] rounded-[24px] p-6 flex flex-col justify-between shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-all duration-300 hover:shadow-[0_12px_40px_rgba(0,0,0,0.09)] min-h-[180px]">
            <div class="flex justify-between items-start w-full gap-4">
                <div>
                    <h3 class="text-lg md:text-xl font-extrabold text-[#111111] leading-tight m-0">
                        <?php echo esc_html($col1_title); ?>
                    </h3>
                    <p class="text-[13px] md:text-sm text-gray-500 font-medium mt-1 mb-0">
                        <?php echo esc_html($col1_sub); ?>
                    </p>
                </div>
                <a 
                    href="<?php echo esc_url($col1_btn_url); ?>" 
                    class="flex-shrink-0 inline-flex items-center justify-center bg-white border border-[#d1d5db] text-xs font-bold text-[#1b1c1c] px-4 py-1.5 rounded-full shadow-sm hover:shadow hover:bg-gray-50 transition-all duration-200"
                >
                    <?php echo esc_html($col1_btn_label); ?>
                </a>
            </div>
            <div class="w-full h-full mt-4 relative overflow-hidden flex items-center justify-center bg-white rounded-xl">
                <img 
                    src="<?php echo esc_url($col1_image); ?>" 
                    class="absolute w-full max-w-none object-cover pointer-events-none transition-transform duration-300 hover:scale-[1.02]" 
                    style="top: 50%; transform: translateY(-50%);"
                    alt="category products" 
                    referrerpolicy="no-referrer"
                />
            </div>
        </div>

        <!-- Column 2 Card -->
        <div class="bg-white border border-[#eceef1] rounded-[24px] p-6 flex flex-col justify-between shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-all duration-300 hover:shadow-[0_12px_40px_rgba(0,0,0,0.09)] min-h-[180px]">
            <div class="flex justify-between items-start w-full gap-4">
                <div>
                    <h3 class="text-lg md:text-xl font-extrabold text-[#111111] leading-tight m-0">
                        <?php echo esc_html($col2_title); ?>
                    </h3>
                    <p class="text-[13px] md:text-sm text-gray-500 font-medium mt-1 mb-0">
                        <?php echo esc_html($col2_sub); ?>
                    </p>
                </div>
                <a 
                    href="<?php echo esc_url($col2_btn_url); ?>" 
                    class="flex-shrink-0 inline-flex items-center justify-center bg-white border border-[#d1d5db] text-xs font-bold text-[#1b1c1c] px-4 py-1.5 rounded-full shadow-sm hover:shadow hover:bg-gray-50 transition-all duration-200"
                >
                    <?php echo esc_html($col2_btn_label); ?>
                </a>
            </div>
            <div class="w-full h-full mt-4 relative overflow-hidden flex items-center justify-center bg-white rounded-xl">
                <img 
                    src="<?php echo esc_url($col2_image); ?>" 
                    class="absolute w-full max-w-none object-cover pointer-events-none transition-transform duration-300 hover:scale-[1.02]" 
                    style="top: 50%; transform: translateY(-50%);"
                    alt="category products" 
                    referrerpolicy="no-referrer"
                />
            </div>
        </div>

        <!-- Column 3 Card -->
        <div class="bg-white border border-[#eceef1] rounded-[24px] p-6 flex flex-col justify-between shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-all duration-300 hover:shadow-[0_12px_40px_rgba(0,0,0,0.09)] min-h-[180px]">
            <div class="flex justify-between items-start w-full gap-4">
                <div>
                    <h3 class="text-lg md:text-xl font-extrabold text-[#111111] leading-tight m-0">
                        <?php echo esc_html($col3_title); ?>
                    </h3>
                    <p class="text-[13px] md:text-sm text-gray-500 font-medium mt-1 mb-0">
                        <?php echo esc_html($col3_sub); ?>
                    </p>
                </div>
                <a 
                    href="<?php echo esc_url($col3_btn_url); ?>" 
                    class="flex-shrink-0 inline-flex items-center justify-center bg-white border border-[#d1d5db] text-xs font-bold text-[#1b1c1c] px-4 py-1.5 rounded-full shadow-sm hover:shadow hover:bg-gray-50 transition-all duration-200"
                >
                    <?php echo esc_html($col3_btn_label); ?>
                </a>
            </div>
            <div class="w-full h-full mt-4 relative overflow-hidden flex items-center justify-center bg-white rounded-xl">
                <img 
                    src="<?php echo esc_url($col3_image); ?>" 
                    class="absolute w-full max-w-none object-cover pointer-events-none transition-transform duration-300 hover:scale-[1.02]" 
                    style="top: 50%; transform: translateY(-50%);"
                    alt="category products" 
                    referrerpolicy="no-referrer"
                />
            </div>
        </div>

    </div>
</div>
<?php
