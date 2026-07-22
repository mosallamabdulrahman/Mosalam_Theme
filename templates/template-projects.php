<?php
/**
 * Template Name: Projects Portfolio
 * Description: A page template to display the company's Projects (portfolio) with interactive client-side categories filtering, searching, and load-more.
 */

get_header();

$portfolio_title = get_the_title();
$portfolio_desc = '';
if (have_posts()) {
    while (have_posts()) {
        the_post();
        $portfolio_desc = get_the_content();
    }
    wp_reset_postdata();
}

if (empty($portfolio_title)) {
    $portfolio_title = __('Our Work', 'mosalam');
}
?>

<main id="main-content" class="w-full bg-surface text-on-surface">

  <!-- ── Hero Banner ────────────────────────── -->
  <section class="relative min-h-[320px] md:min-h-[400px] flex items-center overflow-hidden bg-primary">
    <div class="absolute inset-0 z-0">
      <img id="portfolio-hero-bg-img" src="<?php echo esc_url(MOSALAM_THEME_URI . '/assets/images/abstract-high-tech-digital-background.webp'); ?>" alt="" class="w-full h-full object-cover opacity-30 mix-blend-overlay transition-opacity duration-500 ease-in-out" loading="eager" fetchpriority="high">
      <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/90 to-primary/40"></div>
    </div>
    <div class="relative z-10 container-custom py-12 md:py-16 w-full">
      <div class="max-w-3xl text-left" data-animate-group="fade-up">
        <span class="text-tertiary font-bold tracking-[0.2em] text-xs uppercase mb-4 block" data-animate-item><?php esc_html_e('Portfolio', 'mosalam'); ?></span>
        <h1 class="text-white text-h1 mb-6" data-animate-item><?php echo esc_html($portfolio_title); ?></h1>
        <?php if ($portfolio_desc) : ?>
          <div class="text-white/80 text-body-lg font-light leading-relaxed" data-animate-item><?php echo wp_kses_post($portfolio_desc); ?></div>
        <?php else : ?>
          <p class="text-white/80 text-body-lg font-light leading-relaxed" data-animate-item>
            <?php esc_html_e("This is our company's portfolio — a look at the platforms, products, and digital transformations we've delivered for our clients.", 'mosalam'); ?>
          </p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- ── Filter & Search Section ───────────── -->
  <section class="container-custom pt-12" data-animate="fade-up" data-animate-delay="150">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 border-b border-outline-variant/30 pb-6 mb-8 w-full">
      
      <!-- Category Tabs (Styled like Market Research Tabs) -->
      <div class="flex flex-wrap items-center gap-2" id="portfolio-tabs">
        <button 
          data-category="all" 
          data-title="<?php esc_attr_e('All Projects', 'mosalam'); ?>"
          data-hero-bg="<?php echo esc_url(MOSALAM_THEME_URI . '/assets/images/abstract-high-tech-digital-background.webp'); ?>"
          class="portfolio-tab-btn px-5 py-2.5 text-sm font-bold rounded-action border border-outline-variant/30 transition-all"
        >
          <?php esc_html_e('All', 'mosalam'); ?>
        </button>
        <?php
        $terms = get_terms([
            'taxonomy' => 'project_category',
            'hide_empty' => true,
        ]);
        if (!empty($terms) && !is_wp_error($terms)) :
            foreach ($terms as $term) :
                $custom_title = get_term_meta($term->term_id, '_mosalam_category_title', true);
                $display_title = !empty($custom_title) ? $custom_title : $term->name;
                $bg_id = get_term_meta($term->term_id, '_mosalam_category_hero_bg_id', true);
                $hero_bg_url = $bg_id ? wp_get_attachment_image_url($bg_id, 'full') : MOSALAM_THEME_URI . '/assets/images/abstract-high-tech-digital-background.webp';
                ?>
              <button 
                data-category="<?php echo esc_attr($term->slug); ?>" 
                data-title="<?php echo esc_attr($display_title); ?>"
                data-hero-bg="<?php echo esc_url($hero_bg_url); ?>"
                class="portfolio-tab-btn px-5 py-2.5 text-sm font-bold rounded-action border border-outline-variant/30 transition-all"
              >
                <?php echo esc_html($term->name); ?>
              </button>
            <?php endforeach;
        endif;
        ?>
      </div>

      <!-- Search Input -->
      <div class="relative w-full lg:w-80">
        <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-on-surface-variant/50">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
          </svg>
        </span>
        <input 
          type="text" 
          id="project-search-input" 
          placeholder="<?php esc_attr_e('Search projects...', 'mosalam'); ?>" 
          class="w-full pl-11 pr-4 py-2.5 text-sm rounded-action border border-outline-variant/30 bg-white focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all"
        >
      </div>

    </div>
  </section>

  <!-- ── Dynamic Category Title Section ─────── -->
  <section class="container-custom pt-2 pb-6">
    <h2 id="category-display-title" class="text-2xl sm:text-3xl md:text-4xl text-center font-headline font-bold text-primary tracking-tight transition-all duration-300 transform opacity-100 translate-y-0">
      <?php esc_html_e('All Projects', 'mosalam'); ?>
    </h2>
  </section>

  <!-- ── Projects Grid ──────────────────────── -->
  <section class="container-custom pb-24">
    <?php
    $projects_query = new WP_Query([
        'post_type' => 'project',
        'post_status' => 'publish',
        'posts_per_page' => -1, // Get all to filter and paginated on client side
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ]);

    if ($projects_query->have_posts()) :
    ?>

      <div id="projects-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4" data-animate-group="fade-up">
        <?php while ($projects_query->have_posts()) : $projects_query->the_post();
            $live_url = mosalam_get_project_live_url();
            $terms = wp_get_post_terms(get_the_ID(), 'project_category');
            $cat_slugs = [];
            $cat_names = [];
            foreach ($terms as $t) {
                $cat_slugs[] = $t->slug;
                $cat_names[] = $t->name;
            }
            ?>

          <a 
            href="<?php echo esc_url($live_url); ?>" 
            target="_blank" 
            rel="noopener noreferrer"
            class="project-card group relative aspect-[3/2] bg-white rounded-action border border-outline-variant/20 shadow-sm hover:shadow-xl transition-all duration-300 flex items-center justify-center p-4 sm:p-5 overflow-hidden"
            data-categories='<?php echo json_encode($cat_slugs); ?>'
            data-title="<?php echo esc_attr(strtolower(get_the_title())); ?>"
            data-animate-item
          >
            <!-- Logo Image inside card container -->
            <div class="w-full h-full flex items-center justify-center relative z-0">
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium_large', [
                    'class' => 'max-w-full max-h-full object-contain w-auto h-auto transition-transform duration-500 group-hover:scale-105',
                    'loading' => 'lazy',
                    'alt' => sprintf(__('%s logo', 'mosalam'), get_the_title()),
                ]); ?>
              <?php else : ?>
                <span class="text-2xl text-outline-variant/40 font-headline font-bold uppercase"><?php the_title(); ?></span>
              <?php endif; ?>
            </div>

            <!-- Hover overlay: fades in on hover -->
            <div class="absolute inset-0 bg-[#001b35]/85 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center p-4 text-center z-10">
              <h3 class="text-white font-headline font-bold text-xs sm:text-sm tracking-wider mb-3 leading-snug">
                <?php the_title(); ?>
              </h3>
              <span class="inline-flex items-center justify-center bg-secondary hover:bg-white hover:text-secondary text-white text-[11px] sm:text-xs font-bold px-4 py-1.5 sm:px-5 sm:py-2 rounded-full shadow transition-all duration-300 transform hover:scale-105">
                <?php esc_html_e('View', 'mosalam'); ?>
              </span>
            </div>
          </a>

        <?php endwhile; ?>
      </div>

      <!-- ── Load More Button ───────────────── -->
      <div id="load-more-container" class="flex justify-center mt-16 hidden">
        <button id="load-more-btn" class="bg-secondary text-white hover:bg-primary px-8 py-3 rounded-action text-overline transition-all border border-secondary hover:border-primary">
          <?php esc_html_e('Load More Projects', 'mosalam'); ?>
        </button>
      </div>

    <?php else : ?>
      <!-- No Projects Found -->
      <div class="text-center py-20">
        <p class="text-h3 text-primary mb-4"><?php esc_html_e('No projects yet', 'mosalam'); ?></p>
        <p class="text-body text-on-surface-variant"><?php esc_html_e('Check back soon — new work is on the way.', 'mosalam'); ?></p>
      </div>
    <?php endif; wp_reset_postdata(); ?>
  </section>

</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const cards = Array.from(document.querySelectorAll('.project-card'));
  const tabBtns = Array.from(document.querySelectorAll('.portfolio-tab-btn'));
  const searchInput = document.getElementById('project-search-input');
  const loadMoreBtn = document.getElementById('load-more-btn');
  const loadMoreContainer = document.getElementById('load-more-container');

  let activeCategory = 'all';
  let searchQuery = '';
  let visibleCount = 24;

  // Set active tab buttons classes (Market Research Dashboard style)
  const updateTabButtonStyles = () => {
    tabBtns.forEach(btn => {
      const isSelected = btn.dataset.category === activeCategory;
      if (isSelected) {
        btn.classList.add('bg-secondary', 'text-white', 'border-secondary');
        btn.classList.remove('bg-white', 'text-primary', 'border-outline-variant/30', 'hover:text-secondary', 'hover:border-secondary');
      } else {
        btn.classList.remove('bg-secondary', 'text-white', 'border-secondary');
        btn.classList.add('bg-white', 'text-primary', 'border-outline-variant/30', 'hover:text-secondary', 'hover:border-secondary');
      }
    });
  };

  // Main filter and rendering logic with smooth cross-fade animation when switching
  const filterAndRender = (isInit = false) => {
    const grid = document.getElementById('projects-grid');
    if (!grid) return;

    const performFilter = () => {
      let matchIndex = 0;
      let matchingCount = 0;

      cards.forEach(card => {
        const categories = JSON.parse(card.dataset.categories || '[]');
        const title = card.dataset.title || '';

        const matchesCategory = (activeCategory === 'all' || categories.includes(activeCategory));
        const matchesSearch = title.includes(searchQuery.toLowerCase());
        const isMatch = matchesCategory && matchesSearch;
        if (isMatch) {
          matchingCount++;
          if (matchIndex < visibleCount) {
            card.classList.remove('hidden');
            matchIndex++;
          } else {
            card.classList.add('hidden');
          }
        } else {
          card.classList.add('hidden');
        }
      });

      // Control load more visibility
      if (matchingCount > visibleCount) {
        loadMoreContainer.classList.remove('hidden');
      } else {
        loadMoreContainer.classList.add('hidden');
      }
    };

    if (isInit) {
      // Immediate render on page load to allow native scroll reveals
      performFilter();
      return;
    }

    // Smooth transition on category selection / search
    grid.style.transition = 'opacity 0.2s cubic-bezier(0.4, 0, 0.2, 1), transform 0.2s cubic-bezier(0.4, 0, 0.2, 1)';
    grid.style.opacity = '0';
    grid.style.transform = 'translateY(8px)';

    setTimeout(() => {
      performFilter();
      requestAnimationFrame(() => {
        grid.style.opacity = '1';
        grid.style.transform = 'translateY(0)';
      });
    }, 200);
  };

  // Tabs click handler
  tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      activeCategory = btn.dataset.category;
      visibleCount = 24; // Reset paging on category change
      updateTabButtonStyles();
      filterAndRender(false);

      // Smoothly animate Category Title
      const categoryTitleEl = document.getElementById('category-display-title');
      const newTitle = btn.dataset.title;
      if (categoryTitleEl && newTitle) {
        categoryTitleEl.style.opacity = '0';
        categoryTitleEl.style.transform = 'translateY(6px)';
        setTimeout(() => {
          categoryTitleEl.textContent = newTitle;
          categoryTitleEl.style.opacity = '1';
          categoryTitleEl.style.transform = 'translateY(0)';
        }, 150);
      }

      // Smoothly animate Hero Background Image
      const heroBgImgEl = document.getElementById('portfolio-hero-bg-img');
      const newHeroBg = btn.dataset.heroBg;
      if (heroBgImgEl && newHeroBg) {
        if (heroBgImgEl.src !== newHeroBg) {
          heroBgImgEl.style.opacity = '0';
          setTimeout(() => {
            heroBgImgEl.src = newHeroBg;
            heroBgImgEl.style.opacity = '0.3';
          }, 200);
        }
      }
    });
  });

  // Search input handler
  if (searchInput) {
    searchInput.addEventListener('input', (e) => {
      searchQuery = e.target.value.trim();
      visibleCount = 24; // Reset paging on search change
      filterAndRender(false);
    });
  }

  // Load more click handler
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', () => {
      visibleCount += 24;
      filterAndRender(false);
    });
  }

  // Initialize
  updateTabButtonStyles();
  filterAndRender(true);
});
</script>

<?php
get_footer();
