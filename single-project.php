<?php
/**
 * Single Project view: hero banner (main image, category, live link), an
 * optional swipeable/drag gallery (assets/js/theme.js: initProjectGallery),
 * and the full write-up from the classic editor content.
 */

get_header();

while (have_posts()) :
    the_post();

    $live_url = mosalam_get_project_live_url();
    $category = mosalam_get_project_category_badge();
    $short_description = mosalam_get_project_short_description(null, 32);
    $gallery = mosalam_get_project_gallery_urls();
    ?>

<main id="main-content" class="w-full bg-surface text-on-surface">

  <!-- ── Hero Banner ────────────────────────── -->
  <section class="relative h-[500px] flex items-end overflow-hidden bg-primary" data-animate="fade-up">
    <div class="absolute inset-0 z-0">
      <?php if (has_post_thumbnail()) : ?>
        <?php the_post_thumbnail('full', [
            'class' => 'w-full h-full object-cover opacity-50 mix-blend-overlay',
            'loading' => 'eager',
        ]); ?>
      <?php else : ?>
        <img src="<?php echo esc_url(MOSALAM_THEME_URI . '/assets/images/abstract-high-tech-digital-background.webp'); ?>" alt="" class="w-full h-full object-cover opacity-30 mix-blend-overlay">
      <?php endif; ?>
      <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/80 to-primary/20"></div>
    </div>

    <div class="relative z-10 container-custom py-16">
      <a href="<?php echo esc_url(mosalam_get_projects_archive_url()); ?>" class="inline-flex items-center gap-2 text-overline text-white/60 hover:text-white transition-colors mb-6">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m12 19-7-7 7-7" /><path d="M19 12H5" /></svg>
        <?php esc_html_e('Back to Portfolio', 'mosalam'); ?>
      </a>

      <?php if ($category) : ?>
        <span class="text-tertiary font-bold tracking-[0.2em] text-xs uppercase mb-6 block"><?php echo esc_html($category->name); ?></span>
      <?php endif; ?>

      <h1 class="text-white text-h1 mb-6 max-w-3xl"><?php the_title(); ?></h1>

      <?php if ($short_description) : ?>
        <p class="text-white/80 text-body-lg font-light leading-relaxed max-w-2xl mb-8"><?php echo esc_html($short_description); ?></p>
      <?php endif; ?>

      <?php if ($live_url) : ?>
        <a href="<?php echo esc_url($live_url); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-4 bg-secondary text-white px-8 py-4 rounded-action text-overline hover:bg-white hover:text-secondary transition-all group">
          <?php esc_html_e('Visit Live Site', 'mosalam'); ?>
          <svg class="w-4 h-4 group-hover:translate-x-2 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7" /><path d="M7 7h10v10" /></svg>
        </a>
      <?php endif; ?>
    </div>
  </section>

  <?php if (!empty($gallery)) : ?>
    <!-- ── Gallery: drag/swipe, no arrows, dot pagination ──── -->
    <section class="py-16 md:py-24 bg-surface-container-low" data-animate="fade-up">
      <div class="container-custom">
        <div class="js-project-gallery">
          <div class="js-project-gallery-track flex overflow-x-auto snap-x snap-mandatory hide-scrollbar gap-4 cursor-grab active:cursor-grabbing select-none rounded-action">
            <?php foreach ($gallery as $image) : ?>
              <div class="js-project-gallery-slide shrink-0 w-full snap-center aspect-[16/9] rounded-action overflow-hidden bg-surface-container">
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="w-full h-full object-cover pointer-events-none" loading="lazy" draggable="false">
              </div>
            <?php endforeach; ?>
          </div>

          <?php if (count($gallery) > 1) : ?>
            <div class="js-project-gallery-dots flex justify-center gap-3 mt-8">
              <?php foreach ($gallery as $index => $image) : ?>
                <button
                  type="button"
                  class="js-project-gallery-dot w-2.5 h-2.5 rounded-full bg-primary/20 hover:bg-primary/40 transition-colors"
                  data-index="<?php echo (int) $index; ?>"
                  aria-label="<?php echo esc_attr(sprintf(__('Go to image %d', 'mosalam'), $index + 1)); ?>"
                ></button>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- ── Full Write-up ──────────────────────── -->
  <?php if (get_the_content()) : ?>
    <section class="py-16 md:py-24">
      <div class="container-custom max-w-3xl">
        <div class="prose-mosalam">
          <?php the_content(); ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

</main>

<?php
endwhile;

get_footer();
