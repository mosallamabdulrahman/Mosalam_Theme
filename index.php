<?php
/**
 * Fallback template.
 */

get_header();
?>
<main class="w-full bg-surface text-on-surface scroll-smooth container-custom py-24">
  <?php
  if (have_posts()) :
      while (have_posts()) :
          the_post();
          the_title('<h1 class="text-h1 text-primary mb-8">', '</h1>');
          the_content();
      endwhile;
  else :
      ?>
      <p class="text-body text-on-surface-variant"><?php esc_html_e('Nothing found.', 'mosalam'); ?></p>
      <?php
  endif;
  ?>
</main>
<?php
get_footer();
