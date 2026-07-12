<?php
/**
 * Header: sticky top nav, mega menu, search, mobile menu.
 * Interactivity (open/close, tab drag, scroll reveals) lives in assets/js/theme.js.
 */

$mosalam_logo = get_theme_mod('mosalam_header_logo', MOSALAM_THEME_URI . '/assets/images/mosalam_logo.svg');
$mosalam_cta_label = get_theme_mod('mosalam_header_cta_label', 'Contact Us');
$mosalam_cta_url = get_theme_mod('mosalam_header_cta_url', '/contact');
$mosalam_mega_menu_columns = mosalam_get_mega_menu_columns();
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>document.documentElement.classList.add('js');</script>
<?php wp_head(); ?>
</head>
<body <?php body_class('bg-surface text-on-surface selection:bg-secondary/30 w-full relative'); ?>>
<?php wp_body_open(); ?>

<nav id="site-header" class="sticky top-0 w-full z-50 bg-[#001b35] border-b border-white/10 shadow-sm h-24 md:h-32">
  <div class="flex justify-between items-center container-custom h-full">
    <div class="flex items-center gap-16">
      <div class="flex flex-col">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="block">
          <img
            src="<?php echo esc_url($mosalam_logo); ?>"
            alt="MOSALAM Logo"
            class="h-6 md:h-9 brightness-0 invert"
            referrerpolicy="no-referrer"
          >
        </a>
        <span class="text-[7px] md:text-[8px] text-white/60 mt-1 font-bold tracking-wider uppercase leading-none max-w-[130px] md:max-w-none break-words whitespace-normal md:whitespace-nowrap">
          Managed Operations Systems And Logistics Asset Management
        </span>
      </div>
      <?php
      wp_nav_menu([
          'theme_location' => 'primary_menu',
          'container' => false,
          'menu_class' => 'hidden lg:flex items-center gap-10 text-overline font-medium h-full list-none',
          'fallback_cb' => false,
      ]);
      ?>
    </div>
    <div class="flex items-center gap-2 sm:gap-4 md:gap-8">
      <div class="relative flex items-center justify-end min-w-[40px]">
        <form
          id="search-form"
          action="<?php echo esc_url(home_url('/')); ?>"
          method="get"
          class="hidden fixed left-4 right-4 top-28 z-[70] items-center rounded-action bg-[#001b35]/95 px-4 py-3 border border-white/20 backdrop-blur-md md:absolute md:left-auto md:right-0 md:top-auto md:w-[min(42vw,360px)] md:bg-white/10 md:py-2 lg:w-[280px]"
        >
          <svg class="w-4 h-4 text-white/50 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
          <input
            type="search"
            name="s"
            id="search-input"
            placeholder="Type to search..."
            class="bg-transparent border-none outline-none text-white text-sm w-full placeholder:text-white/30"
          >
          <button id="search-close" type="button" class="ml-2 hover:bg-white/10 rounded-action p-1 transition-colors">
            <svg class="w-4 h-4 text-white/80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
          </button>
        </form>
        <button id="search-open" type="button" class="p-3 hover:bg-white/10 rounded-action transition-colors flex items-center justify-center group">
          <svg class="w-6 h-6 text-white group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        </button>
      </div>
      <a
        href="<?php echo esc_url($mosalam_cta_url); ?>"
        class="hidden sm:block bg-secondary text-white hover:bg-white hover:text-secondary px-8 py-3 rounded-action text-overline transition-all border border-secondary hover:border-white"
      ><?php echo esc_html($mosalam_cta_label); ?></a>
      <button id="mobile-menu-toggle" type="button" aria-expanded="false" aria-controls="mobile-menu-panel" class="lg:hidden p-3 text-white hover:bg-white/10 rounded-action transition-colors flex items-center justify-center">
        <div class="relative w-8 h-8">
          <span class="mobile-burger-line absolute top-2 left-0 w-8 h-0.5 bg-white"></span>
          <span class="mobile-burger-line absolute top-4 left-0 w-8 h-0.5 bg-white"></span>
          <span class="mobile-burger-line absolute top-6 left-0 w-8 h-0.5 bg-white"></span>
        </div>
      </button>
    </div>
  </div>

  <!-- Mega Menu Dropdown (Desktop) -->
  <div
    id="mega-menu-panel"
    class="hidden absolute top-full left-0 w-full bg-white text-[#001b35] shadow-2xl overflow-hidden border-t border-black/5 z-[40]"
  >
    <div class="container-custom py-12 lg:py-16">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-12 max-w-3xl">
        <?php foreach ($mosalam_mega_menu_columns as $column) : ?>
          <div class="flex flex-col">
            <h4 class="text-[14px] md:text-[15px] font-bold text-[#001b35] leading-tight mb-4 max-w-[200px]"><?php echo esc_html($column['title']); ?></h4>
            <ul class="flex flex-col gap-2.5">
              <?php foreach ($column['links'] as $link) : ?>
                <li>
                  <a href="<?php echo esc_url($link['url']); ?>" class="text-[13px] md:text-[14px] font-english text-[#4d4d4d] hover:text-[#001b35] hover:underline transition-all block">
                    <?php echo esc_html($link['name']); ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Mobile Menu Overlay -->
  <div id="mobile-menu-panel" class="hidden fixed inset-y-0 right-0 w-full bg-[#001b35] z-[60] lg:hidden overflow-y-auto" style="transform: translateX(100%);">
    <div class="flex flex-col px-8 py-10 md:py-16">
      <div class="flex justify-between items-center mb-12">
        <img src="<?php echo esc_url($mosalam_logo); ?>" alt="MOSALAM Logo" class="h-8 w-auto px-10" referrerpolicy="no-referrer">
        <button id="mobile-menu-close" type="button" class="p-2 text-white hover:bg-white/5 rounded-action">
          <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
      </div>

      <div class="flex flex-col gap-8 px-10">
        <div class="flex flex-col gap-4">
          <!-- <button id="mobile-services-toggle" type="button" aria-expanded="false" class="text-h3 text-white text-left flex items-center justify-between">
            Services
            <svg id="mobile-services-chevron" class="w-6 h-6 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
          </button> -->
          <div id="mobile-services-panel" class="hidden flex-col gap-6 pl-4 border-l border-white/10">
            <?php foreach ($mosalam_mega_menu_columns as $index => $column) : ?>
              <div class="flex flex-col gap-3">
                <button type="button" class="mobile-subcategory-toggle text-secondary font-bold text-overline text-left flex items-center justify-between" aria-expanded="false" data-target="mobile-subcategory-<?php echo (int) $index; ?>">
                  <?php echo esc_html($column['title']); ?>
                  <svg class="w-4 h-4 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <ul id="mobile-subcategory-<?php echo (int) $index; ?>" class="hidden flex-col gap-2 pl-4">
                  <?php foreach ($column['links'] as $link) : ?>
                    <li><a href="<?php echo esc_url($link['url']); ?>" class="text-white/60 hover:text-white transition-colors text-sm"><?php echo esc_html($link['name']); ?></a></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <?php
        wp_nav_menu([
            'theme_location' => 'primary_menu',
            'container' => false,
            'menu_class' => 'flex flex-col gap-8 list-none',
            'fallback_cb' => false,
        ]);
        ?>

        <a href="<?php echo esc_url($mosalam_cta_url); ?>" class="mt-8 rounded-action bg-[#00f0b4] text-[#001b35] py-4 text-overline font-bold uppercase tracking-widest text-center">
          Contact Us Now
        </a>
      </div>
    </div>
  </div>
</nav>
