<?php
/**
 * Single post template — full-width hero, article with prose typography,
 * sticky sidebar with Table of Contents + Quick Contact Form.
 */

get_header();

while ( have_posts() ) :
    the_post();

    $reading_time = mosalam_reading_time();
    $toc_headings = mosalam_get_toc_headings();
    $categories   = get_the_category();
    $has_toc      = ! empty( $toc_headings );
?>

<main id="main-content" class="w-full bg-surface text-on-surface">

  <!-- ── Hero Banner ────────────────────────── -->
  <section class="relative bg-primary overflow-hidden" data-animate="fade-up">
    <div class="absolute inset-0">
      <img src="<?php echo esc_url( MOSALAM_THEME_URI . '/assets/images/blog_hero_bg.png' ); ?>" alt="" class="w-full h-full object-cover opacity-35">
    </div>
    <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/90 to-primary/45"></div>

    <div class="relative container-custom py-20 md:py-28">
      <!-- Back to Blog & Category -->
      <div class="flex items-center gap-2 text-overline text-white/50 mb-4">
        <a href="<?php echo esc_url( home_url('/blog') ); ?>" class="text-secondary hover:text-white transition-colors">&lt; Back to Blog</a>
        <span class="text-white/30">&bull;</span>
        <span class="text-white/70 uppercase tracking-widest"><?php echo esc_html( $categories[0]->name ); ?></span>
      </div>

      <h1 class="text-3xl md:text-5xl font-headline font-bold text-white mb-6 !leading-tight max-w-4xl"><?php the_title(); ?></h1>

      <!-- Meta row -->
      <div class="flex flex-wrap items-center gap-6 text-sm text-white/75 mt-8">
        <div class="flex items-center gap-2">
          <svg class="w-4 h-4 text-secondary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
          <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
        </div>
        <div class="flex items-center gap-2">
          <svg class="w-4 h-4 text-secondary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
          <span><?php the_author(); ?></span>
        </div>
        <div class="flex items-center gap-2">
          <svg class="w-4 h-4 text-secondary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
          <span><?php printf( esc_html__( '%d min read', 'mosalam' ), $reading_time ); ?></span>
        </div>
      </div>
    </div>
  </section>

  <!-- ── Content + Sidebar ──────────────────── -->
  <div class="container-custom pt-8 pb-16 md:pt-12 md:pb-24">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14">

      <!-- ── Article ─────────────────────────── -->
      <article class="lg:col-span-8 min-w-0 animate-fade-in-up">

        <!-- Featured Image (inside content) -->
        <?php if ( has_post_thumbnail() ) : ?>
          <figure class="mb-10 -mt-4 aspect-[16/9] w-full overflow-hidden rounded-action shadow-lg">
            <?php the_post_thumbnail( 'large', [
                'class'   => 'w-full h-full object-cover',
                'loading' => 'eager',
            ] ); ?>
          </figure>
        <?php endif; ?>

        <!-- Post Content -->
        <div class="prose-mosalam">
          <?php the_content(); ?>
        </div>

        <!-- Tags -->
        <?php
        $tags = get_the_tags();
        if ( $tags ) :
        ?>
          <div class="flex flex-wrap gap-2 mt-12 pt-8 border-t border-outline-variant/30">
            <?php foreach ( $tags as $tag ) : ?>
              <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"
                 class="text-xs font-bold uppercase tracking-wider text-on-surface-variant bg-surface-container px-3 py-1.5 rounded-full hover:bg-secondary/10 hover:text-secondary transition-colors">
                #<?php echo esc_html( $tag->name ); ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <!-- Author Box -->
        <div class="flex items-end gap-5 mt-12 p-6 md:p-8 bg-white rounded-action border border-outline-variant/20 shadow-sm" data-animate="fade-up">
          <?php echo get_avatar( get_the_author_meta( 'ID' ), 64, '', '', [ 'class' => 'rounded-full w-16 h-16 shrink-0' ] ); ?>
          <div>
            <p class="text-overline text-on-surface-variant mb-1"><?php esc_html_e( 'Written by', 'mosalam' ); ?></p>
            <p class="text-h4 text-primary mb-2"><?php the_author(); ?></p>
            <?php if ( get_the_author_meta( 'description' ) ) : ?>
              <p class="text-body-sm text-on-surface-variant"><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
            <?php endif; ?>
          </div>
        </div>

        <!-- Post Navigation -->
        <nav class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-12" aria-label="<?php esc_attr_e( 'Post navigation', 'mosalam' ); ?>">
          <?php
          $prev_post = get_previous_post();
          $next_post = get_next_post();
          ?>
          <?php if ( $prev_post ) : ?>
            <a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>"
               class="group flex flex-col p-5 bg-white rounded-action border border-outline-variant/20 hover:border-secondary/30 hover:shadow-md transition-all">
              <span class="text-xs text-on-surface-variant mb-2">&larr; <?php esc_html_e( 'Previous', 'mosalam' ); ?></span>
              <span class="text-sm font-bold text-primary group-hover:text-secondary transition-colors line-clamp-2"><?php echo esc_html( $prev_post->post_title ); ?></span>
            </a>
          <?php else : ?>
            <div></div>
          <?php endif; ?>

          <?php if ( $next_post ) : ?>
            <a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>"
               class="group flex flex-col p-5 bg-white rounded-action border border-outline-variant/20 hover:border-secondary/30 hover:shadow-md transition-all text-right">
              <span class="text-xs text-on-surface-variant mb-2"><?php esc_html_e( 'Next', 'mosalam' ); ?> &rarr;</span>
              <span class="text-sm font-bold text-primary group-hover:text-secondary transition-colors line-clamp-2"><?php echo esc_html( $next_post->post_title ); ?></span>
            </a>
          <?php endif; ?>
        </nav>

      </article>

      <!-- ── Sidebar ─────────────────────────── -->
      <aside class="lg:col-span-4 animate-fade-in-up" style="animation-delay: 150ms;">
        <div class="lg:sticky lg:top-36 space-y-6">

          <!-- Widget 1: Table of Contents -->
          <?php if ( $has_toc ) : ?>
            <div class="blog-widget" id="toc-widget">
              <h3 class="blog-widget-title"><?php esc_html_e( 'Table of Contents', 'mosalam' ); ?></h3>
              <nav aria-label="<?php esc_attr_e( 'Table of contents', 'mosalam' ); ?>">
                <ul class="space-y-1 text-sm" id="toc-list">
                  <?php foreach ( $toc_headings as $heading ) :
                      $indent = ( $heading['level'] === 'h3' ) ? 'pl-4' : '';
                  ?>
                    <li>
                      <a href="#<?php echo esc_attr( $heading['id'] ); ?>"
                         class="toc-link block py-1.5 px-3 rounded-action text-on-surface-variant hover:text-secondary hover:bg-secondary/5 transition-all duration-200 <?php echo esc_attr( $indent ); ?>"
                         data-toc-target="<?php echo esc_attr( $heading['id'] ); ?>">
                        <?php echo esc_html( $heading['text'] ); ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </nav>
            </div>
          <?php endif; ?>

          <!-- Widget 2: Quick Contact Form -->
          <div class="blog-widget" id="contact-widget">
            <h3 class="blog-widget-title"><?php esc_html_e( 'Quick Contact', 'mosalam' ); ?></h3>

            <?php
            // Flash messages
            if ( isset( $_GET['contact'] ) ) :
                $status = sanitize_text_field( $_GET['contact'] );
            ?>
              <?php if ( $status === 'success' ) : ?>
                <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-action">
                  <?php esc_html_e( 'Message sent successfully! We will get back to you soon.', 'mosalam' ); ?>
                </div>
              <?php elseif ( $status === 'error' ) : ?>
                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-800 text-sm rounded-action">
                  <?php esc_html_e( 'Something went wrong. Please check your inputs and try again.', 'mosalam' ); ?>
                </div>
              <?php endif; ?>
            <?php endif; ?>

            <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" class="space-y-4">
              <?php wp_nonce_field( 'mosalam_blog_contact', '_mosalam_contact_nonce' ); ?>
              <input type="hidden" name="action" value="mosalam_blog_contact">
              <input type="hidden" name="_wp_http_referer" value="<?php echo esc_attr( get_permalink() ); ?>">

              <div>
                <label for="mosalam_name" class="block text-xs font-bold text-on-surface-variant mb-1.5">
                  <?php esc_html_e( 'Name', 'mosalam' ); ?>
                </label>
                <input
                  type="text"
                  id="mosalam_name"
                  name="mosalam_name"
                  required
                  class="w-full px-4 py-2.5 text-sm bg-surface-container-low border border-outline-variant/30 rounded-action text-on-surface placeholder:text-on-surface-variant/50 focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary/30 transition-all"
                  placeholder="<?php esc_attr_e( 'Your name', 'mosalam' ); ?>"
                >
              </div>

              <div>
                <label for="mosalam_email" class="block text-xs font-bold text-on-surface-variant mb-1.5">
                  <?php esc_html_e( 'Email', 'mosalam' ); ?>
                </label>
                <input
                  type="email"
                  id="mosalam_email"
                  name="mosalam_email"
                  required
                  class="w-full px-4 py-2.5 text-sm bg-surface-container-low border border-outline-variant/30 rounded-action text-on-surface placeholder:text-on-surface-variant/50 focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary/30 transition-all"
                  placeholder="<?php esc_attr_e( 'you@example.com', 'mosalam' ); ?>"
                >
              </div>

              <div>
                <label for="mosalam_message" class="block text-xs font-bold text-on-surface-variant mb-1.5">
                  <?php esc_html_e( 'Message', 'mosalam' ); ?>
                </label>
                <textarea
                  id="mosalam_message"
                  name="mosalam_message"
                  rows="4"
                  required
                  class="w-full px-4 py-2.5 text-sm bg-surface-container-low border border-outline-variant/30 rounded-action text-on-surface placeholder:text-on-surface-variant/50 focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary/30 transition-all resize-none"
                  placeholder="<?php esc_attr_e( 'How can we help?', 'mosalam' ); ?>"
                ></textarea>
              </div>

              <button
                type="submit"
                class="w-full bg-secondary text-white font-bold text-sm py-3 px-6 rounded-action hover:bg-secondary/90 active:scale-[0.98] transition-all duration-200 shadow-sm hover:shadow-md"
              >
                <?php esc_html_e( 'Send Message', 'mosalam' ); ?>
              </button>
            </form>
          </div>

        </div>
      </aside>

    </div>

    <!-- ── Related Posts ──────────────────────── -->
    <?php
    $related_query = new WP_Query( [
        'category__in'   => wp_get_post_categories( get_the_ID() ),
        'post__not_in'   => [ get_the_ID() ],
        'posts_per_page' => 3,
        'orderby'        => 'rand',
    ] );

    if ( $related_query->have_posts() ) :
    ?>
      <section class="mt-20 pt-12 border-t border-outline-variant/30" data-animate="fade-up">
        <h2 class="text-h3 text-primary mb-8"><?php esc_html_e( 'Related Articles', 'mosalam' ); ?></h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-animate-group="fade-up">
          <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
            <article class="group flex flex-col bg-white rounded-action border border-outline-variant/20 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1" data-animate-item>
              <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>" class="block aspect-[16/10] overflow-hidden" aria-hidden="true" tabindex="-1">
                  <?php the_post_thumbnail( 'medium', [
                      'class'   => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105',
                      'loading' => 'lazy',
                  ] ); ?>
                </a>
              <?php endif; ?>
              <div class="p-5">
                <h3 class="text-sm font-bold text-primary group-hover:text-secondary transition-colors line-clamp-2 mb-2">
                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
                <span class="text-xs text-on-surface-variant">
                  <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
                  &middot;
                  <?php printf( esc_html__( '%d min read', 'mosalam' ), mosalam_reading_time() ); ?>
                </span>
              </div>
            </article>
          <?php endwhile; ?>
        </div>
      </section>
    <?php
    wp_reset_postdata();
    endif;
    ?>
  </div>

</main>

<!-- ── TOC Smooth-Scroll & Active State JS ──── -->
<?php if ( $has_toc ) : ?>
<script>
(function () {
  'use strict';

  const tocLinks = document.querySelectorAll('.toc-link');
  if (!tocLinks.length) return;

  /* Smooth scroll on click */
  tocLinks.forEach(function (link) {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      var targetId = this.getAttribute('data-toc-target');
      var target = document.getElementById(targetId);
      if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        history.replaceState(null, '', '#' + targetId);
      }
    });
  });

  /* Highlight active section on scroll */
  var headingEls = [];
  tocLinks.forEach(function (link) {
    var el = document.getElementById(link.getAttribute('data-toc-target'));
    if (el) headingEls.push(el);
  });

  if (!headingEls.length) return;

  var activeClass = 'bg-secondary/10 text-secondary font-bold';
  var activeCls = activeClass.split(' ');

  function setActive(id) {
    tocLinks.forEach(function (link) {
      if (link.getAttribute('data-toc-target') === id) {
        activeCls.forEach(function (c) { link.classList.add(c); });
      } else {
        activeCls.forEach(function (c) { link.classList.remove(c); });
      }
    });
  }

  var ticking = false;
  function onScroll() {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(function () {
      var current = headingEls[0].id;
      for (var i = 0; i < headingEls.length; i++) {
        var rect = headingEls[i].getBoundingClientRect();
        // If the heading is scrolled close to the header/top of viewport (e.g. 200px)
        if (rect.top <= 200) {
          current = headingEls[i].id;
        }
      }
      setActive(current);
      ticking = false;
    });
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
})();
</script>
<?php endif; ?>

<?php
endwhile;

get_footer();
