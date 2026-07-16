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
      <img src="<?php echo esc_url(MOSALAM_THEME_URI . '/assets/images/abstract-high-tech-digital-background.webp'); ?>" alt="" class="w-full h-full object-cover opacity-30 mix-blend-overlay">
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
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 border-b border-outline-variant/30 pb-6 mb-10 w-full">
      
      <!-- Category Tabs (Styled like Market Research Tabs) -->
      <div class="flex flex-wrap items-center gap-2" id="portfolio-tabs">
        <button data-category="all" class="portfolio-tab-btn px-5 py-2.5 text-sm font-bold rounded-action border border-outline-variant/30 transition-all">
          <?php esc_html_e('All', 'mosalam'); ?>
        </button>
        <?php
        $terms = get_terms([
            'taxonomy' => 'project_category',
            'hide_empty' => true,
        ]);
        if (!empty($terms) && !is_wp_error($terms)) :
            foreach ($terms as $term) : ?>
              <button data-category="<?php echo esc_attr($term->slug); ?>" class="portfolio-tab-btn px-5 py-2.5 text-sm font-bold rounded-action border border-outline-variant/30 transition-all">
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

  <!-- ── Projects Grid ──────────────────────── -->
  <section class="container-custom pb-24">
    <?php
    $projects_query = new WP_Query([
        'post_type' => 'project',
        'post_status' => 'publish',
        'posts_per_page' => -1, // Get all to filter and paginated on client side
    ]);

    if ($projects_query->have_posts()) :
    ?>

      <div id="projects-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10" data-animate-group="fade-up">
        <?php while ($projects_query->have_posts()) : $projects_query->the_post();
            $live_url = mosalam_get_project_live_url();
            $terms = wp_get_post_terms(get_the_ID(), 'project_category');
            $cat_slugs = [];
            $cat_names = [];
            foreach ($terms as $t) {
                $cat_slugs[] = $t->slug;
                $cat_names[] = $t->name;
            }
            $short_description = mosalam_get_project_short_description();
            ?>

          <article 
            class="project-card group relative flex flex-col bg-white rounded-action border border-outline-variant/20 overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2"
            data-categories='<?php echo json_encode($cat_slugs); ?>'
            data-title="<?php echo esc_attr(strtolower(get_the_title())); ?>"
            data-animate-item
          >
            
            <!-- Image Wrap: Covered image filling the card top nicely -->
            <div class="w-full aspect-[16/10] overflow-hidden relative border-b border-outline-variant/10">
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', [
                    'class' => 'w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105',
                    'loading' => 'eager', // Eager load for immediate visual fade-in
                ]); ?>
              <?php else : ?>
                <div class="w-full h-full bg-gradient-to-br from-surface-container to-surface-dim flex items-center justify-center">
                  <span class="text-5xl text-outline-variant/40">✦</span>
                </div>
              <?php endif; ?>
            </div>

            <!-- Card Body -->
            <div class="flex flex-col flex-1 p-5 md:p-6">
              <div class="flex items-start justify-between gap-4 mb-3">
                <h3 class="text-h4 text-primary leading-tight">
                  <?php the_title(); ?>
                </h3>
                <?php if (!empty($cat_names)) : ?>
                  <span class="inline-block px-3 py-1 text-[10px] font-bold tracking-wider text-primary bg-white border border-outline-variant/30 rounded-full shadow-sm uppercase shrink-0">
                    <?php echo esc_html(implode(', ', $cat_names)); ?>
                  </span>
                <?php endif; ?>
              </div>

              <?php if ($short_description) : ?>
                <p class="text-body-sm text-on-surface-variant mb-4 flex-1"><?php echo esc_html($short_description); ?></p>
              <?php endif; ?>

              <?php if ($live_url) : ?>
                <div class="pt-3 border-t border-outline-variant/20 mt-auto">
                  <a href="<?php echo esc_url($live_url); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-overline text-secondary hover:text-primary transition-colors">
                    <?php esc_html_e('Visit Website', 'mosalam'); ?>
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                      <path d="M15 3h6v6" />
                      <path d="M10 14 21 3" />
                    </svg>
                  </a>
                </div>
              <?php endif; ?>
            </div>
          </article>

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
  let visibleCount = 9;

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
      visibleCount = 9; // Reset paging on category change
      updateTabButtonStyles();
      filterAndRender(false);
    });
  });

  // Search input handler
  if (searchInput) {
    searchInput.addEventListener('input', (e) => {
      searchQuery = e.target.value.trim();
      visibleCount = 9; // Reset paging on search change
      filterAndRender(false);
    });
  }

  // Load more click handler
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', () => {
      visibleCount += 9;
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
