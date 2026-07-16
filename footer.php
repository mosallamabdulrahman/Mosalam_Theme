<?php
/**
 * Footer: brand + social, Explore/Compliance link columns, contact info,
 * copyright. Text/links come from the Customizer (inc/customizer.php) and
 * from the "footer_explore"/"footer_compliance" nav menu locations
 * (inc/nav-menus.php), each with a fallback matching the original design.
 */

$mosalam_footer_logo = get_theme_mod('mosalam_footer_logo', MOSALAM_THEME_URI . '/assets/images/mosalam_logo.svg');
$mosalam_footer_description = get_theme_mod('mosalam_footer_description', 'Leading the digital frontier through innovative IT solutions and culturally rooted transformation. Empowering organisations to navigate the future with confidence.');
$mosalam_offices = array_filter(array_map('trim', explode(',', get_theme_mod('mosalam_offices', 'London, Cairo'))));

$mosalam_social_links = [
    [
        'label' => 'Facebook',
        'href' => get_theme_mod('mosalam_social_facebook', 'https://web.facebook.com/MosalamCorp?_rdc=1&_rdr'),
        'color' => '#1877F2',
        'soft_color' => 'rgba(24,119,242,0.1)',
        'icon' => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3.6l.4-4h-4V7a1 1 0 0 1 1-1h3Z" />',
    ],
    [
        'label' => 'LinkedIn',
        'href' => get_theme_mod('mosalam_social_linkedin', 'https://eg.linkedin.com/company/mosalam'),
        'color' => '#0A66C2',
        'soft_color' => 'rgba(10,102,194,0.1)',
        'icon' => '<path d="M6.9 8.9H3.2V21h3.7ZM5.1 7.2a2.1 2.1 0 1 0 0-4.2 2.1 2.1 0 0 0 0 4.2ZM21 21h-3.7v-5.9c0-1.4 0-3.2-2-3.2s-2.3 1.5-2.3 3.1v6H9.4V8.9h3.5v1.7h.1a3.9 3.9 0 0 1 3.5-2c3.8 0 4.5 2.5 4.5 5.7Z" />',
    ],
    [
        'label' => 'Telegram',
        'href' => get_theme_mod('mosalam_social_telegram', 'https://t.me/mosalamhosting'),
        'color' => '#26A5E4',
        'soft_color' => 'rgba(38,165,228,0.1)',
        'icon' => '<path d="m22 2-7 20-4-9-9-4Z" /><path d="M22 2 11 13" />',
    ],
    [
        'label' => 'WhatsApp',
        'href' => get_theme_mod('mosalam_social_whatsapp', 'https://wa.me/201007669160'),
        'color' => '#25D366',
        'soft_color' => 'rgba(37,211,102,0.12)',
        'icon' => '<path d="M380.9 97.1c-41.9-42-97.7-65.1-157-65.1-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3 18.6-68.1-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1s56.2 81.2 56.1 130.5c0 101.8-84.9 184.6-186.6 184.6zM325.1 300.5c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8s-14.3 18-17.6 21.8c-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7s-12.5-30.1-17.1-41.2c-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2s-9.7 1.4-14.8 6.9c-5.1 5.6-19.4 19-19.4 46.3s19.9 53.7 22.6 57.4c2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4s4.6-24.1 3.2-26.4c-1.3-2.5-5-3.9-10.5-6.6z" />',
        'viewbox' => '0 0 448 512',
        'fill' => true,
    ],
];

$mosalam_contact_items = [
    [
        'icon' => '<path d="M20 10c0 4.9-8 12-8 12S4 14.9 4 10a8 8 0 1 1 16 0Z" /><circle cx="12" cy="10" r="3" />',
        'text' => get_theme_mod('mosalam_contact_address', '4th Floor, Silverstream House 45 Fitzroy Street, Fitzrovia London'),
    ],
    [
        'icon' => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7A2 2 0 0 1 22 16.9Z" />',
        'text' => get_theme_mod('mosalam_contact_phone_london', '+44 731 008 2737'),
        'label' => 'London Office',
    ],
    [
        'icon' => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7A2 2 0 0 1 22 16.9Z" />',
        'text' => get_theme_mod('mosalam_contact_phone_cairo', '+20 10 076 69160'),
        'label' => 'Cairo Office',
    ],
    [
        'icon' => '<rect width="20" height="16" x="2" y="4" rx="2" /><path d="m22 7-10 6L2 7" />',
        'text' => get_theme_mod('mosalam_contact_email', 'info@mosalam.com'),
    ],
];
?>
<footer id="footer" class="bg-[#fcf9f8] border-t border-[#001b35]/10 w-full">
  <div class="container-custom grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-y-16 lg:gap-x-12 mb-20 text-[#001b35] pt-12" data-animate="fade-up">
    <div class="lg:col-span-4 space-y-8">
      <img src="<?php echo esc_url($mosalam_footer_logo); ?>" alt="MOSALAM Logo" class="h-10 w-auto" referrerpolicy="no-referrer">
      <p class="text-[#001b35]/70 text-body font-body leading-relaxed max-w-xs"><?php echo esc_html($mosalam_footer_description); ?></p>
      <div class="flex gap-6 items-center">
        <?php foreach ($mosalam_social_links as $social) : ?>
          <a
            href="<?php echo esc_url($social['href']); ?>"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="<?php echo esc_attr($social['label']); ?>"
            class="group"
            style="--social-color: <?php echo esc_attr($social['color']); ?>; --social-soft-color: <?php echo esc_attr($social['soft_color']); ?>;"
          >
            <div class="w-10 h-10 rounded-full border border-[#001b35]/10 flex items-center justify-center transition-all duration-300 group-hover:-translate-y-1 group-hover:border-[var(--social-color)] group-hover:bg-[var(--social-soft-color)]">
              <svg class="w-5 h-5 text-[#001b35]/60 transition-colors duration-300 group-hover:text-[var(--social-color)]" viewBox="<?php echo esc_attr($social['viewbox'] ?? '0 0 24 24'); ?>" fill="currentColor" aria-hidden="true"><?php echo $social['icon']; ?></svg>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="lg:col-span-4 grid grid-cols-1 sm:grid-cols-2 gap-12 lg:gap-8">
      <div class="space-y-8">
        <h4 class="text-[#001b35] font-bold tracking-[0.1em] text-[15px] uppercase">Explore</h4>
        <?php
        wp_nav_menu([
            'theme_location' => 'footer_explore',
            'container' => false,
            'menu_class' => 'space-y-4 list-none',
            'fallback_cb' => false,
        ]);
        ?>
      </div>
      <div class="space-y-8">
        <h4 class="text-[#001b35] font-bold tracking-[0.1em] text-[15px] uppercase">Compliance</h4>
        <?php
        wp_nav_menu([
            'theme_location' => 'footer_compliance',
            'container' => false,
            'menu_class' => 'space-y-4 list-none',
            'fallback_cb' => false,
        ]);
        ?>
      </div>
    </div>

    <div class="lg:col-span-4 space-y-8">
      <h4 class="text-[#001b35] font-bold tracking-[0.1em] text-[15px] uppercase">Contact us</h4>
      <div class="space-y-6">
        <?php foreach ($mosalam_contact_items as $item) : ?>
          <div class="flex gap-4 group <?php echo !empty($item['label']) ? 'items-center' : 'items-start'; ?>">
            <div class="w-10 h-10 rounded-lg bg-[#001b35]/5 flex items-center justify-center shrink-0 group-hover:bg-secondary/10 transition-colors">
              <svg class="w-5 h-5 text-secondary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $item['icon']; ?></svg>
            </div>
            <?php if (!empty($item['label'])) : ?>
              <div class="flex flex-col">
                <p class="text-[#001b35]/70 text-[15px] font-body group-hover:text-[#001b35] transition-colors"><?php echo esc_html($item['text']); ?></p>
                <p class="text-[#001b35]/40 text-[12px] uppercase font-bold tracking-wider"><?php echo esc_html($item['label']); ?></p>
              </div>
            <?php else : ?>
              <p class="text-[#001b35]/70 text-[15px] leading-relaxed font-body group-hover:text-[#001b35] transition-colors break-words"><?php echo esc_html($item['text']); ?></p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <div class="container-custom py-8 border-t border-[#001b35]/10 flex flex-col md:flex-row justify-between items-center gap-6">
    <p class="text-[#001b35]/80 text-[12px] font-bold tracking-widest uppercase text-center md:text-left"><?php echo esc_html(get_theme_mod('mosalam_copyright', '© 2024 MOSALAM DIGITAL HORIZON. ALL RIGHTS RESERVED.')); ?></p>
    <div class="flex items-center gap-8">
      <div class="flex gap-4 text-[11px] font-bold tracking-[0.1em] text-[#001b35]/80 uppercase">
        <?php foreach ($mosalam_offices as $office) : ?>
          <span class="flex items-center gap-2 px-3 py-1 rounded-full bg-[#001b35]/5 border border-[#001b35]/10"><?php echo esc_html($office); ?></span>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
