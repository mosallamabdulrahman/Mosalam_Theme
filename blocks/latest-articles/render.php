<?php
/**
 * @var array $attributes
 */
$eyebrow = $attributes['eyebrow'] ?? '';
$title = $attributes['title'] ?? '';
$posts_to_show = (int) ($attributes['postsToShow'] ?? 3);
$view_all_label = $attributes['viewAllLabel'] ?? '';

$latest_articles_query = new WP_Query([
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => max(1, $posts_to_show),
    'ignore_sticky_posts' => true,
]);

$blog_archive_url = mosalam_get_blog_archive_url();
?>
<?php if ($latest_articles_query->have_posts()) : ?>
<section id="latest-articles" class="py-24 bg-surface border-t border-black/5">
  <div class="container-custom">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-4" data-animate="fade-up">
      <h2 class="text-h2 text-primary"><?php echo wp_kses_post($title); ?></h2>
      <div class="flex flex-col md:items-end gap-3">
        <span class="text-secondary font-bold uppercase tracking-[0.2em] text-xs"><?php echo wp_kses_post($eyebrow); ?></span>
        <?php if ($view_all_label && $blog_archive_url) : ?>
          <a href="<?php echo esc_url($blog_archive_url); ?>" class="flex items-center gap-2 text-overline text-secondary hover:text-primary transition-colors group">
            <?php echo esc_html($view_all_label); ?>
            <svg class="w-4 h-4 group-hover:translate-x-2 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14" /><path d="m12 5 7 7-7 7" /></svg>
          </a>
        <?php endif; ?>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6" data-animate-group="fade-up">
      <?php while ($latest_articles_query->have_posts()) : $latest_articles_query->the_post(); ?>

        <article <?php post_class('group flex flex-col bg-white rounded-action border border-outline-variant/20 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1'); ?> data-animate-item>

          <?php if (has_post_thumbnail()) : ?>
            <a href="<?php the_permalink(); ?>" class="block aspect-[16/10] overflow-hidden" aria-hidden="true" tabindex="-1">
              <?php the_post_thumbnail('medium_large', [
                  'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105',
                  'loading' => 'lazy',
              ]); ?>
            </a>
          <?php else : ?>
            <a href="<?php the_permalink(); ?>" class="block aspect-[16/10] bg-gradient-to-br from-surface-container to-surface-dim flex items-center justify-center" aria-hidden="true" tabindex="-1">
              <span class="text-4xl text-outline-variant/40">✦</span>
            </a>
          <?php endif; ?>

          <div class="flex flex-col flex-1 p-6 md:p-7">

            <?php $cats = get_the_category(); ?>
            <?php if (!empty($cats)) : ?>
              <a href="<?php echo esc_url(get_category_link($cats[0]->term_id)); ?>" class="self-start text-overline text-secondary bg-secondary/5 px-3 py-1 rounded-full hover:bg-secondary/10 transition-colors mb-4">
                <?php echo esc_html($cats[0]->name); ?>
              </a>
            <?php endif; ?>

            <h3 class="text-h4 text-primary mb-3 line-clamp-2 group-hover:text-secondary transition-colors">
              <a href="<?php the_permalink(); ?>" class="no-underline hover:no-underline"><?php the_title(); ?></a>
            </h3>

            <p class="text-body-sm text-on-surface-variant mb-6 line-clamp-3 flex-1"><?php echo get_the_excerpt(); ?></p>

            <div class="flex items-center gap-3 pt-4 border-t border-outline-variant/20">
              <?php echo get_avatar(get_the_author_meta('ID'), 32, '', '', ['class' => 'rounded-full w-8 h-8']); ?>
              <div class="flex flex-col text-xs text-on-surface-variant">
                <span class="font-bold text-primary"><?php the_author(); ?></span>
                <span>
                  <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                  &middot;
                  <?php printf(esc_html__('%d min read', 'mosalam'), mosalam_reading_time()); ?>
                </span>
              </div>
            </div>

          </div>
        </article>

      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
<?php endif; ?>
