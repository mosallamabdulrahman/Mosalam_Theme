<?php
/**
 * Render template for the Derwaza Collections block.
 *
 * @var array $attributes
 */

$theme_uri = MOSALAM_THEME_URI;

// Column 1 values with fallbacks
$col1_title     = $attributes['col1Title'] ?? 'Collections';
$col1_desc      = $attributes['col1Desc'] ?? 'Discover the latest tech. latest/tech.';
$col1_btn_label = $attributes['col1BtnLabel'] ?? 'View All';
$col1_btn_url   = $attributes['col1BtnUrl'] ?? '#';
$col1_image     = !empty($attributes['col1Image']) ? $attributes['col1Image'] : $theme_uri . '/assets/images/portfolio/tech-collection-default.png';

// Column 2 values with fallbacks
$col2_title     = $attributes['col2Title'] ?? 'New in Beauty';
$col2_desc      = $attributes['col2Desc'] ?? 'Discover the newest beauty products.';
$col2_btn_label = $attributes['col2BtnLabel'] ?? 'View All';
$col2_btn_url   = $attributes['col2BtnUrl'] ?? '#';
$col2_image     = !empty($attributes['col2Image']) ? $attributes['col2Image'] : $theme_uri . '/assets/images/portfolio/beauty-collection-default.png';

// Column 3 values with fallbacks
$col3_title     = $attributes['col3Title'] ?? 'New in Home & Kitchen';
$col3_desc      = $attributes['col3Desc'] ?? 'Upgrade your home essentials.';
$col3_btn_label = $attributes['col3BtnLabel'] ?? 'View All';
$col3_btn_url   = $attributes['col3BtnUrl'] ?? '#';
$col3_image     = !empty($attributes['col3Image']) ? $attributes['col3Image'] : $theme_uri . '/assets/images/portfolio/kitchen-collection-default.png';
?>

<div class="derwaza-collections-wrapper w-full max-w-[1400px] mx-auto px-4 md:px-6 relative z-10 mb-10" data-animate="fade-up" data-animate-delay="150">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 font-sans">

        <!-- Column 1 Card -->
        <div 
            class="relative overflow-hidden bg-white border border-[#eceef1] rounded-[24px] p-6 h-[180px] flex flex-col justify-center transition-all duration-300 shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:shadow-[0_12px_40px_rgba(0,0,0,0.09)]"
            style="background-image: url('<?php echo esc_url($col1_image); ?>'); background-repeat: no-repeat; background-position: right 16px center; background-size: 130px auto;"
        >
            <div class="w-[55%] flex flex-col justify-center items-start">
                <h3 class="text-lg md:text-xl font-extrabold text-[#111111] leading-tight m-0">
                    <?php echo esc_html($col1_title); ?>
                </h3>
                <p class="text-[13px] md:text-sm text-gray-700 font-medium mt-1.5 mb-4 line-clamp-2 min-h-[40px]">
                    <?php echo esc_html($col1_desc); ?>
                </p>
                <a 
                    href="<?php echo esc_url($col1_btn_url); ?>" 
                    class="inline-flex items-center justify-center bg-white border border-[#d1d5db] text-xs font-bold text-[#1b1c1c] px-5 py-2 rounded-full shadow-sm hover:shadow hover:bg-gray-50 transition-all duration-200"
                >
                    <?php echo esc_html($col1_btn_label); ?>
                </a>
            </div>
        </div>

        <!-- Column 2 Card -->
        <div 
            class="relative overflow-hidden bg-white border border-[#eceef1] rounded-[24px] p-6 h-[180px] flex flex-col justify-center transition-all duration-300 shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:shadow-[0_12px_40px_rgba(0,0,0,0.09)]"
            style="background-image: url('<?php echo esc_url($col2_image); ?>'); background-repeat: no-repeat; background-position: right 16px center; background-size: 130px auto;"
        >
            <div class="w-[55%] flex flex-col justify-center items-start">
                <h3 class="text-lg md:text-xl font-extrabold text-[#111111] leading-tight m-0">
                    <?php echo esc_html($col2_title); ?>
                </h3>
                <p class="text-[13px] md:text-sm text-gray-700 font-medium mt-1.5 mb-4 line-clamp-2 min-h-[40px]">
                    <?php echo esc_html($col2_desc); ?>
                </p>
                <a 
                    href="<?php echo esc_url($col2_btn_url); ?>" 
                    class="inline-flex items-center justify-center bg-white border border-[#d1d5db] text-xs font-bold text-[#1b1c1c] px-5 py-2 rounded-full shadow-sm hover:shadow hover:bg-gray-50 transition-all duration-200"
                >
                    <?php echo esc_html($col2_btn_label); ?>
                </a>
            </div>
        </div>

        <!-- Column 3 Card -->
        <div 
            class="relative overflow-hidden bg-white border border-[#eceef1] rounded-[24px] p-6 h-[180px] flex flex-col justify-center transition-all duration-300 shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:shadow-[0_12px_40px_rgba(0,0,0,0.09)]"
            style="background-image: url('<?php echo esc_url($col3_image); ?>'); background-repeat: no-repeat; background-position: right 16px center; background-size: 130px auto;"
        >
            <div class="w-[55%] flex flex-col justify-center items-start">
                <h3 class="text-lg md:text-xl font-extrabold text-[#111111] leading-tight m-0">
                    <?php echo esc_html($col3_title); ?>
                </h3>
                <p class="text-[13px] md:text-sm text-gray-700 font-medium mt-1.5 mb-4 line-clamp-2 min-h-[40px]">
                    <?php echo esc_html($col3_desc); ?>
                </p>
                <a 
                    href="<?php echo esc_url($col3_btn_url); ?>" 
                    class="inline-flex items-center justify-center bg-white border border-[#d1d5db] text-xs font-bold text-[#1b1c1c] px-5 py-2 rounded-full shadow-sm hover:shadow hover:bg-gray-50 transition-all duration-200"
                >
                    <?php echo esc_html($col3_btn_label); ?>
                </a>
            </div>
        </div>

    </div>
</div>
<?php
