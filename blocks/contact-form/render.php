<?php
/**
 * @var array $attributes
 */
$title_line1 = $attributes['titleLine1'] ?? '';
$title_line2 = $attributes['titleLine2'] ?? '';
$description = $attributes['description'] ?? '';
$contact_items = $attributes['contactItems'] ?? [];
$form_title = $attributes['formTitle'] ?? '';
$name_label = $attributes['nameLabel'] ?? '';
$name_placeholder = $attributes['namePlaceholder'] ?? '';
$email_label = $attributes['emailLabel'] ?? '';
$email_placeholder = $attributes['emailPlaceholder'] ?? '';
$org_label = $attributes['orgLabel'] ?? '';
$org_placeholder = $attributes['orgPlaceholder'] ?? '';
$inquiry_label = $attributes['inquiryLabel'] ?? '';
$inquiry_options = $attributes['inquiryOptions'] ?? [];
$message_label = $attributes['messageLabel'] ?? '';
$message_placeholder = $attributes['messagePlaceholder'] ?? '';
$submit_label = $attributes['submitLabel'] ?? '';

function mosalam_contact_icon_paths($name)
{
    $icons = [
        'mail' => '<rect width="20" height="16" x="2" y="4" rx="2" /><path d="m22 7-10 6L2 7" />',
        'phone' => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7A2 2 0 0 1 22 16.9Z" />',
        'globe' => '<circle cx="12" cy="12" r="10" /><path d="M2 12h20" /><path d="M12 2a15.3 15.3 0 0 1 0 20" /><path d="M12 2a15.3 15.3 0 0 0 0 20" />',
    ];

    return $icons[$name] ?? $icons['mail'];
}
?>
<section class="py-10 md:py-16 bg-surface">
  <div class="container-custom grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-24">
    <div class="lg:col-span-5 space-y-16">
      <div data-animate="fade-right">
        <h2 class="text-h2 text-primary mb-6"><?php echo wp_kses_post($title_line1); ?><br><?php echo wp_kses_post($title_line2); ?></h2>
        <p class="text-on-surface-variant text-body-lg leading-relaxed"><?php echo wp_kses_post($description); ?></p>
      </div>

      <div class="space-y-10" data-animate-group="fade-up">
        <?php foreach ($contact_items as $item) : ?>
          <div class="group flex gap-6 items-start hover:-translate-y-1 transition-transform duration-300" data-animate-item>
            <div class="w-12 h-12 bg-surface-container-low flex items-center justify-center shrink-0 group-hover:bg-secondary group-hover:text-white transition-colors duration-300 rounded-none border border-black/5">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo mosalam_contact_icon_paths($item['icon']); ?></svg>
            </div>
            <div>
              <h4 class="text-h4 text-primary mb-2"><?php echo esc_html($item['title']); ?></h4>
              <?php foreach ($item['lines'] as $line) : ?>
                <?php if (!empty($line['href'])) : ?>
                  <a href="<?php echo esc_url($line['href']); ?>" class="text-body text-secondary hover:text-primary transition-colors block"><?php echo esc_html($line['text']); ?></a>
                <?php else : ?>
                  <p class="text-body text-on-surface-variant"><?php echo esc_html($line['text']); ?></p>
                <?php endif; ?>
              <?php endforeach; ?>
              <?php if (!empty($item['note'])) : ?>
                <p class="text-sm text-on-surface-variant/70 mt-1"><?php echo esc_html($item['note']); ?></p>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="lg:col-span-7 border border-black/5" data-animate="fade-left">
      <div class="bg-white p-10 md:p-16 shadow-xl relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-secondary"></div>
        <h3 class="text-h3 text-primary mb-8"><?php echo wp_kses_post($form_title); ?></h3>

        <form class="js-contact-form space-y-8">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex flex-col gap-2">
              <label class="text-sm font-bold text-primary uppercase tracking-wider"><?php echo esc_html($name_label); ?></label>
              <input
                type="text"
                name="full_name"
                class="w-full bg-surface-container-low border-b-2 border-transparent px-4 py-4 placeholder:text-on-surface-variant/40 focus:bg-surface-container-highest focus:border-secondary outline-none transition-all duration-300 text-primary"
                placeholder="<?php echo esc_attr($name_placeholder); ?>"
              >
            </div>
            <div class="flex flex-col gap-2">
              <label class="text-sm font-bold text-primary uppercase tracking-wider"><?php echo esc_html($email_label); ?></label>
              <input
                type="email"
                name="work_email"
                class="w-full bg-surface-container-low border-b-2 border-transparent px-4 py-4 placeholder:text-on-surface-variant/40 focus:bg-surface-container-highest focus:border-secondary outline-none transition-all duration-300 text-primary"
                placeholder="<?php echo esc_attr($email_placeholder); ?>"
              >
            </div>
          </div>

          <div class="flex flex-col gap-2">
            <label class="text-sm font-bold text-primary uppercase tracking-wider"><?php echo esc_html($org_label); ?></label>
            <input
              type="text"
              name="organization"
              class="w-full bg-surface-container-low border-b-2 border-transparent px-4 py-4 placeholder:text-on-surface-variant/40 focus:bg-surface-container-highest focus:border-secondary outline-none transition-all duration-300 text-primary"
              placeholder="<?php echo esc_attr($org_placeholder); ?>"
            >
          </div>

          <div class="flex flex-col gap-2">
            <label class="text-sm font-bold text-primary uppercase tracking-wider"><?php echo esc_html($inquiry_label); ?></label>
            <select name="inquiry" class="w-full bg-surface-container-low border-b-2 border-transparent px-4 py-4 text-primary focus:bg-surface-container-highest focus:border-secondary outline-none transition-all duration-300 appearance-none cursor-pointer">
              <?php foreach ($inquiry_options as $option) : ?>
                <option><?php echo esc_html($option); ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="flex flex-col gap-2">
            <label class="text-sm font-bold text-primary uppercase tracking-wider"><?php echo esc_html($message_label); ?></label>
            <textarea
              name="message"
              rows="4"
              class="w-full bg-surface-container-low border-b-2 border-transparent px-4 py-4 placeholder:text-on-surface-variant/40 focus:bg-surface-container-highest focus:border-secondary outline-none transition-all duration-300 text-primary resize-none"
              placeholder="<?php echo esc_attr($message_placeholder); ?>"
            ></textarea>
          </div>

          <button type="submit" class="w-full bg-primary text-white hover:bg-secondary py-5 font-bold uppercase tracking-[0.2em] text-sm transition-colors duration-500 flex items-center justify-center gap-4 group mt-4">
            <?php echo esc_html($submit_label); ?>
            <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14" /><path d="m12 5 7 7-7 7" /></svg>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>
