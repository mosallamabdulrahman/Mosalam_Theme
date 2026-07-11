<?php
/**
 * @var array $attributes
 */
$eyebrow = $attributes['eyebrow'] ?? '';
$title = $attributes['title'] ?? '';
$categories = $attributes['categories'] ?? [];

// Function to get icon based on slug/title
if ( ! function_exists( 'mosalam_get_service_icon' ) ) {
    function mosalam_get_service_icon( $title ) {
        $title_lower = strtolower( $title );
        if ( strpos( $title_lower, 'hosting' ) !== false ) {
            return '<svg class="w-10 h-10 text-secondary mb-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242" /><path d="M12 12v9" /><path d="m8 17 4 4 4-4" /></svg>';
        } elseif ( strpos( $title_lower, 'it services' ) !== false || strpos( $title_lower, 'it support' ) !== false || strpos( $title_lower, 'it operations' ) !== false ) {
            return '<svg class="w-10 h-10 text-secondary mb-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" /><path d="m9 12 2 2 4-4" /></svg>';
        } elseif ( strpos( $title_lower, 'erp' ) !== false ) {
            return '<svg class="w-10 h-10 text-secondary mb-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v18H3z" /><path d="M21 9H3" /><path d="M21 15H3" /><path d="M12 3v18" /></svg>';
        } elseif ( strpos( $title_lower, 'front' ) !== false ) {
            return '<svg class="w-10 h-10 text-secondary mb-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2" /><line x1="8" y1="21" x2="16" y2="21" /><line x1="12" y1="17" x2="12" y2="21" /></svg>';
        } elseif ( strpos( $title_lower, 'back' ) !== false ) {
            return '<svg class="w-10 h-10 text-secondary mb-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3" /><path d="M3 5v6c0 1.66 4 3 9 3s9-1.34 9-3V5" /><path d="M3 11v6c0 1.66 4 3 9 3s9-1.34 9-3v-6" /></svg>';
        }
        return '<svg class="w-10 h-10 text-secondary mb-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>';
    }
}
?>
<section id="services" class="min-h-screen w-full relative cinematic-section bg-[#001b35] py-24">
  <div class="container-custom w-full">
    <div class="max-w-3xl mb-16" data-animate="fade-up">
      <span class="text-overline-lg text-secondary mb-4 block"><?php echo wp_kses_post($eyebrow); ?></span>
      <h2 class="text-h1 text-white"><?php echo wp_kses_post($title); ?></h2>
    </div>
    <div class="flex flex-wrap justify-center items-stretch gap-8 w-full" data-animate-group="fade-up">
      <?php foreach ($categories as $category) : ?>
        <div class="bg-white p-8 flex flex-col justify-between border-t-4 border-secondary hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 w-full md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.5rem)] max-w-md lg:max-w-none" data-animate-item>
          <div class="mb-6">
            <?php echo mosalam_get_service_icon($category['title']); ?>
            <h3 class="text-h3 text-[#001b35] mb-4"><?php echo esc_html($category['title']); ?></h3>
            <p class="text-body-sm text-on-surface-variant"><?php echo wp_kses_post($category['description']); ?></p>
          </div>
          <div>
            <h4 class="text-overline text-secondary mb-4">Specific Services</h4>
            <div class="flex flex-col gap-2">
              <?php foreach ($category['links'] as $link) : ?>
                <a href="<?php echo esc_url($link['url']); ?>" class="group flex items-center justify-between p-3 bg-[#fcf9f8] hover:bg-[#001b35] transition-all duration-300">
                  <span class="text-body-sm font-medium text-[#001b35] group-hover:text-white transition-colors"><?php echo esc_html($link['label']); ?></span>
                  <svg class="w-4 h-4 text-secondary transform -translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14" /><path d="m12 5 7 7-7 7" /></svg>
                </a>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
