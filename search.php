<?php
/**
 * Search results template.
 */

get_header();

global $wp_query;
$search_query   = get_search_query();
$results_count  = $wp_query->found_posts;
?>

<main id="main-content" class="w-full bg-surface text-on-surface">

  <!-- ── Hero Banner ────────────────────────── -->
  <section class="relative bg-primary overflow-hidden animate-fade-in-up">
    <div class="absolute inset-0">
      <img src="<?php echo esc_url( MOSALAM_THEME_URI . '/assets/images/blog_hero_bg.webp' ); ?>" alt="" class="w-full h-full object-cover opacity-35">
    </div>
    <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/90 to-primary/45"></div>
    <div class="relative container-custom py-14 md:py-18 text-center">
      <p class="text-overline text-secondary mb-4"><?php esc_html_e( 'Search Results', 'mosalam' ); ?></p>
      <h1 class="text-h1 text-white mb-4">
        <?php printf( esc_html__( 'Search: "%s"', 'mosalam' ), $search_query ); ?>
      </h1>
      <p class="text-body-lg text-white/70 max-w-2xl mx-auto">
        <?php 
        if ( $results_count === 0 ) {
            esc_html_e( 'No results found matching your query. Try searching again below.', 'mosalam' );
        } else {
            printf( _n( 'We found %d result matching your query.', 'We found %d results matching your query.', $results_count, 'mosalam' ), $results_count );
        }
        ?>
      </p>
    </div>
  </section>

  <!-- ── Results Section ──────────────────────── -->
  <section class="container-custom pt-8 pb-16 md:pt-12 md:pb-24">
    <?php if ( have_posts() ) : ?>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 md:gap-4 animate-fade-in-up">
        <?php while ( have_posts() ) : the_post(); 
            $post_type = get_post_type();
        ?>

          <?php if ( 'post' === $post_type ) : ?>
            <!-- Article Result Card (Exactly like Blog Card) -->
            <article <?php post_class( 'group flex flex-col bg-white rounded-action border border-outline-variant/20 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1' ); ?>>
              
              <!-- Thumbnail -->
              <div class="relative aspect-[16/10] overflow-hidden bg-gradient-to-br from-surface-container to-surface-dim">
                <!-- Result Type Badge -->
                <span class="absolute top-4 left-4 z-10 text-[10px] font-bold uppercase tracking-wider bg-[#001b35] text-white px-2.5 py-1 rounded-full shadow-sm">
                  <?php esc_html_e( 'Article', 'mosalam' ); ?>
                </span>
                
                <?php if ( has_post_thumbnail() ) : ?>
                  <a href="<?php the_permalink(); ?>" class="block w-full h-full" aria-hidden="true" tabindex="-1">
                    <?php the_post_thumbnail( 'medium_large', [
                        'class'   => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105',
                        'loading' => 'lazy',
                    ] ); ?>
                  </a>
                <?php else : ?>
                  <a href="<?php the_permalink(); ?>" class="block w-full h-full flex items-center justify-center" aria-hidden="true" tabindex="-1">
                    <span class="text-4xl text-outline-variant/40">✦</span>
                  </a>
                <?php endif; ?>
              </div>

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
                <h2 class="text-h4 text-primary mb-3 line-clamp-2 group-hover:text-secondary transition-colors font-headline font-bold">
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

          <?php else : ?>
            <!-- Page or Custom Post Type Result Card -->
            <article <?php post_class( 'group flex flex-col bg-white rounded-action border border-outline-variant/20 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1' ); ?>>
              
              <!-- Thumbnail/Placeholder -->
              <div class="relative aspect-[16/10] overflow-hidden bg-[#f0eded]/60 flex items-center justify-center">
                <!-- Result Type Badge -->
                <span class="absolute top-4 left-4 z-10 text-[10px] font-bold uppercase tracking-wider bg-secondary text-white px-2.5 py-1 rounded-full shadow-sm">
                  <?php esc_html_e( 'Page', 'mosalam' ); ?>
                </span>
                
                <?php if ( has_post_thumbnail() ) : ?>
                  <a href="<?php the_permalink(); ?>" class="block w-full h-full" aria-hidden="true" tabindex="-1">
                    <?php the_post_thumbnail( 'medium_large', [
                        'class'   => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105',
                        'loading' => 'lazy',
                    ] ); ?>
                  </a>
                <?php else : ?>
                  <!-- Page Icon Placeholder -->
                  <div class="w-16 h-16 rounded-full bg-secondary/5 flex items-center justify-center text-secondary">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                  </div>
                <?php endif; ?>
              </div>

              <!-- Content -->
              <div class="flex flex-col flex-1 p-6 md:p-7">
                <!-- Breadcrumb -->
                <span class="text-overline text-on-surface-variant/50 mb-4 block">
                  <?php echo esc_html( home_url( '/' ) ); ?>
                </span>

                <!-- Title -->
                <h2 class="text-h4 text-primary mb-3 line-clamp-2 group-hover:text-secondary transition-colors font-headline font-bold">
                  <a href="<?php the_permalink(); ?>" class="no-underline hover:no-underline">
                    <?php the_title(); ?>
                  </a>
                </h2>

                <!-- Excerpt -->
                <p class="text-body-sm text-on-surface-variant mb-6 line-clamp-3 flex-1">
                  <?php 
                  $excerpt = get_the_excerpt();
                  if ( empty( $excerpt ) ) {
                      $excerpt = wp_strip_all_tags( get_the_content() );
                  }
                  echo wp_trim_words( $excerpt, 25, '&hellip;' ); 
                  ?>
                </p>

                <!-- Link/CTA -->
                <div class="pt-4 border-t border-outline-variant/20 flex justify-between items-center">
                  <a href="<?php the_permalink(); ?>" class="text-sm font-bold text-secondary hover:text-primary transition-colors flex items-center gap-1">
                    <?php esc_html_e( 'View Page', 'mosalam' ); ?>
                    <span>&rarr;</span>
                  </a>
                </div>
              </div>
            </article>
          <?php endif; ?>

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
        <nav class="flex justify-center items-center gap-2 mt-16" aria-label="<?php esc_attr_e( 'Search pagination', 'mosalam' ); ?>">
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
      <!-- No Results Found form -->
      <div class="max-w-xl mx-auto text-center py-16 bg-white border border-outline-variant/20 rounded-action p-8 shadow-sm">
        <div class="w-16 h-16 rounded-full bg-secondary/5 flex items-center justify-center text-secondary mx-auto mb-6">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <h2 class="text-2xl font-headline font-bold text-primary mb-3"><?php esc_html_e( 'Nothing Found', 'mosalam' ); ?></h2>
        <p class="text-body-sm text-on-surface-variant mb-8"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mosalam' ); ?></p>
        
        <form role="search" method="get" class="flex gap-2" action="<?php echo esc_url( home_url( '/' ) ); ?>">
          <input
            type="search"
            required
            class="flex-1 px-4 py-2.5 text-sm bg-surface-container-low border border-outline-variant/30 rounded-action text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary/30 transition-all"
            placeholder="<?php esc_attr_e( 'Search again...', 'mosalam' ); ?>"
            value="<?php echo esc_attr( $search_query ); ?>"
            name="s"
          >
          <button
            type="submit"
            class="bg-secondary text-white font-bold text-sm px-6 py-2.5 rounded-action hover:bg-secondary/90 transition-colors shadow-sm"
          >
            <?php esc_html_e( 'Search', 'mosalam' ); ?>
          </button>
        </form>
      </div>
    <?php endif; ?>
  </section>

</main>

<?php
get_footer();
