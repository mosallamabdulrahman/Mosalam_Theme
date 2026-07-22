<?php
/**
 * The template for displaying 404 pages (Not Found)
 */

get_header();
?>

<main id="main-content" class="w-full bg-background flex items-center justify-center py-20 md:py-32 min-h-[60vh]">
  <div class="max-w-xl text-center mx-auto px-4" data-animate-group="fade-up">
    <p class="text-7xl font-bold leading-none text-secondary sm:text-8xl" data-animate-item>404</p>
    <h1 class="mt-6 text-2xl font-bold text-primary sm:text-3xl" data-animate-item><?php esc_html_e('Page Not Found', 'mosalam'); ?></h1>
    <p class="mx-auto mt-4 max-w-md text-base leading-8 text-slate-600 font-body" data-animate-item><?php esc_html_e('The page you are looking for does not exist or has been moved.', 'mosalam'); ?></p>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center justify-center bg-secondary hover:bg-primary text-white text-base font-bold px-8 py-3.5 rounded-action shadow-md hover:shadow-xl transition-all duration-300 mt-7 transform hover:-translate-y-0.5 active:translate-y-0" data-animate-item><?php esc_html_e('Back to Home', 'mosalam'); ?></a>
  </div>
</main>

<?php
get_footer();
