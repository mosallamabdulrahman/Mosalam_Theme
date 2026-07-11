<?php
/**
 * Generic page template (About Us, Contact Us, and any other page):
 * content is entirely composed of Mosalam_Blocks.
 */

get_header();
?>
<main class="w-full bg-surface text-on-surface scroll-smooth">
  <?php
  while (have_posts()) :
      the_post();
      the_content();
  endwhile;
  ?>
</main>
<?php
get_footer();
