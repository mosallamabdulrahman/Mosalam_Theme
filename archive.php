<?php
/**
 * Blog archive template — categories, tags, date archives, and the
 * default posts listing. Responsive card grid with hero banner,
 * pagination, and entry animations.
 */

get_header();

// Archive title & description
$archive_title = '';
$archive_desc  = '';

if ( is_category() ) {
    $archive_title = single_cat_title( '', false );
    $archive_desc  = category_description();
} elseif ( is_tag() ) {
    $archive_title = single_tag_title( '', false );
    $archive_desc  = tag_description();
} elseif ( is_author() ) {
    $archive_title = get_the_author();
    $archive_desc  = get_the_author_meta( 'description' );
} elseif ( is_date() ) {
    $archive_title = get_the_date( 'F Y' );
} elseif ( is_search() ) {
    /* translators: %s: search query */
    $archive_title = sprintf( __( 'Search: %s', 'mosalam' ), get_search_query() );
} else {
    $archive_title = __( 'Blog', 'mosalam' );
    $archive_desc  = __( 'Insights, case studies, and industry perspectives from the Mosalam team.', 'mosalam' );
}
?>

<main id="main-content" class="w-full bg-surface text-on-surface">

  <!-- ── Hero Banner ────────────────────────── -->
  <section class="relative bg-primary overflow-hidden" data-animate="fade-up">
    <div class="absolute inset-0">
      <img src="<?php echo esc_url( MOSALAM_THEME_URI . '/assets/images/blog_hero_bg.webp' ); ?>" alt="" class="w-full h-full object-cover opacity-35" loading="eager" fetchpriority="high">
    </div>
    <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/90 to-primary/45"></div>
    <div class="relative container-custom py-20 md:py-28 text-center">
      <p class="text-overline text-secondary mb-4"><?php esc_html_e( 'Blog', 'mosalam' ); ?></p>
      <h1 class="text-h1 text-white mb-4"><?php echo esc_html( $archive_title ); ?></h1>
      <?php if ( $archive_desc ) : ?>
        <p class="text-body-lg text-white/70 max-w-2xl mx-auto"><?php echo wp_kses_post( $archive_desc ); ?></p>
      <?php endif; ?>
    </div>
  </section>

  <!-- ── Post Grid ──────────────────────────── -->
  <section class="container-custom pt-8 pb-16 md:pt-12 md:pb-24">
    <?php if ( have_posts() ) : ?>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 animate-fade-in-up">
        <?php while ( have_posts() ) : the_post(); ?>

          <article <?php post_class( 'group flex flex-col bg-white rounded-action border border-outline-variant/20 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1' ); ?>>

            <!-- Thumbnail -->
            <?php if ( has_post_thumbnail() ) : ?>
              <a href="<?php the_permalink(); ?>" class="block aspect-[16/10] overflow-hidden" aria-hidden="true" tabindex="-1">
                <?php the_post_thumbnail( 'medium_large', [
                    'class'   => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105',
                    'loading' => 'lazy',
                ] ); ?>
              </a>
            <?php else : ?>
              <a href="<?php the_permalink(); ?>" class="block aspect-[16/10] bg-gradient-to-br from-surface-container to-surface-dim flex items-center justify-center" aria-hidden="true" tabindex="-1">
                <span class="text-4xl text-outline-variant/40">✦</span>
              </a>
            <?php endif; ?>

            <!-- Content -->
            <div class="flex flex-col flex-1 p-6 md:p-7">

              <!-- Category Badge -->
              <?php
              $cats = get_the_category();
              if ( ! empty( $cats ) ) :
              ?>
                <a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>"
                   class="self-start text-overline text-secondary bg-secondary/5 px-3 py-1 rounded-full hover:bg-secondary/10 transition-colors mb-4">
                  <?php echo esc_html( $cats[0]->name ); ?>
                </a>
              <?php endif; ?>

              <!-- Title -->
              <h2 class="text-h4 text-primary mb-3 line-clamp-2 group-hover:text-secondary transition-colors">
                <a href="<?php the_permalink(); ?>" class="no-underline hover:no-underline">
                  <?php the_title(); ?>
                </a>
              </h2>

              <!-- Excerpt -->
              <p class="text-body-sm text-on-surface-variant mb-6 line-clamp-3 flex-1">
                <?php echo get_the_excerpt(); ?>
              </p>

              <!-- Meta -->
              <div class="flex items-center gap-3 pt-4 border-t border-outline-variant/20">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 32, '', '', [ 'class' => 'rounded-full w-8 h-8' ] ); ?>
                <div class="flex flex-col text-xs text-on-surface-variant">
                  <span class="font-bold text-primary"><?php the_author(); ?></span>
                  <span>
                    <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
                    &middot;
                    <?php printf( esc_html__( '%d min read', 'mosalam' ), mosalam_reading_time() ); ?>
                  </span>
                </div>
              </div>

            </div>
          </article>

        <?php endwhile; ?>
      </div>

      <!-- ── Pagination ─────────────────────── -->
      <?php
      $pagination = paginate_links( [
          'type'      => 'array',
          'prev_text' => '&larr; ' . __( 'Previous', 'mosalam' ),
          'next_text' => __( 'Next', 'mosalam' ) . ' &rarr;',
      ] );

      if ( $pagination ) :
      ?>
        <nav class="flex justify-center items-center gap-2 mt-16" aria-label="<?php esc_attr_e( 'Blog pagination', 'mosalam' ); ?>">
          <?php foreach ( $pagination as $link ) :
              if ( preg_match( '/class=["\']([^"\']*)["\']/i', $link, $matches ) ) {
                  $existing_classes = $matches[1];
                  $new_classes = 'inline-flex items-center justify-center min-w-[40px] h-10 px-4 text-sm font-bold rounded-action transition-all duration-200';
                  
                  if ( strpos( $existing_classes, 'current' ) !== false ) {
                      $new_classes .= ' bg-secondary text-white';
                  } else {
                      $new_classes .= ' bg-white text-primary border border-outline-variant/30 hover:border-secondary hover:text-secondary';
                  }
                  
                  $link = preg_replace( '/class=["\']([^"\']*)["\']/i', 'class="' . $new_classes . '"', $link );
              }
              echo $link;
          endforeach; ?>
        </nav>
      <?php endif; ?>

    <?php else : ?>
      <!-- No Posts Found -->
      <div class="text-center py-20">
        <p class="text-h3 text-primary mb-4"><?php esc_html_e( 'No posts found', 'mosalam' ); ?></p>
        <p class="text-body text-on-surface-variant"><?php esc_html_e( 'Check back soon for new content.', 'mosalam' ); ?></p>
      </div>
    <?php endif; ?>
  </section>

</main>

<?php
get_footer();
