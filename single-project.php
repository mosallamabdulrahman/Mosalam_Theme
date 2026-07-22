<?php
/**
 * Redirect single project page visits back to the main portfolio/projects archive page.
 */
wp_safe_redirect(mosalam_get_projects_archive_url(), 301);
exit;
