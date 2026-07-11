<?php
/**
 * Front page (Home): content is entirely composed of Mosalam_Blocks,
 * seeded automatically on theme activation (see inc/theme-setup.php).
 */

get_header();
?>
<main class="w-full scroll-smooth">
  <?php
  while (have_posts()) :
      the_post();
      the_content();
  endwhile;
  ?>
</main>
<?php
get_footer();
