<?php
/**
 * Theme Customizer: Header settings + Footer settings sections.
 * Every setting has a default equal to the original hardcoded value, so an
 * untouched install renders identically to the original design.
 */

if (!defined('ABSPATH')) {
    exit;
}

function mosalam_customize_register(WP_Customize_Manager $wp_customize)
{
    /* ---------------------------------------------------------------- */
    /* Header section                                                    */
    /* ---------------------------------------------------------------- */
    $wp_customize->add_section('mosalam_header', [
        'title' => __('Header Settings', 'mosalam'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('mosalam_header_logo', [
        'default' => MOSALAM_THEME_URI . '/assets/images/mosalam_logo.svg',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mosalam_header_logo', [
        'label' => __('Logo', 'mosalam'),
        'section' => 'mosalam_header',
    ]));

    $wp_customize->add_setting('mosalam_header_cta_label', [
        'default' => 'Contact Us',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('mosalam_header_cta_label', [
        'label' => __('"Contact" button label', 'mosalam'),
        'section' => 'mosalam_header',
        'type' => 'text',
    ]);

    $wp_customize->add_setting('mosalam_header_cta_url', [
        'default' => '/contact',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('mosalam_header_cta_url', [
        'label' => __('"Contact" button link', 'mosalam'),
        'section' => 'mosalam_header',
        'type' => 'text',
    ]);

    /* ---------------------------------------------------------------- */
    /* Footer section                                                     */
    /* ---------------------------------------------------------------- */
    $wp_customize->add_section('mosalam_footer', [
        'title' => __('Footer Settings', 'mosalam'),
        'priority' => 31,
    ]);

    $wp_customize->add_setting('mosalam_footer_logo', [
        'default' => MOSALAM_THEME_URI . '/assets/images/mosalam_logo.svg',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mosalam_footer_logo', [
        'label' => __('Footer logo', 'mosalam'),
        'section' => 'mosalam_footer',
    ]));

    $wp_customize->add_setting('mosalam_footer_description', [
        'default' => 'Leading the digital frontier through innovative IT solutions and culturally rooted transformation. Empowering organisations to navigate the future with confidence.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('mosalam_footer_description', [
        'label' => __('Brand description', 'mosalam'),
        'section' => 'mosalam_footer',
        'type' => 'textarea',
    ]);

    $social_defaults = [
        'facebook' => 'https://web.facebook.com/MosalamCorp?_rdc=1&_rdr',
        'linkedin' => 'https://eg.linkedin.com/company/mosalam',
        'telegram' => 'https://t.me/mosalamhosting',
        'whatsapp' => 'https://wa.me/201007669160',
    ];
    foreach ($social_defaults as $key => $default) {
        $wp_customize->add_setting("mosalam_social_{$key}", [
            'default' => $default,
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control("mosalam_social_{$key}", [
            'label' => sprintf(__('%s URL', 'mosalam'), ucfirst($key)),
            'section' => 'mosalam_footer',
            'type' => 'url',
        ]);
    }

    $wp_customize->add_setting('mosalam_contact_address', [
        'default' => '4th Floor, Silverstream House 45 Fitzroy Street, Fitzrovia London',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('mosalam_contact_address', [
        'label' => __('Address', 'mosalam'),
        'section' => 'mosalam_footer',
        'type' => 'textarea',
    ]);

    $wp_customize->add_setting('mosalam_contact_phone_london', [
        'default' => '+44 731 008 2737',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('mosalam_contact_phone_london', [
        'label' => __('Phone (London Office)', 'mosalam'),
        'section' => 'mosalam_footer',
        'type' => 'text',
    ]);

    $wp_customize->add_setting('mosalam_contact_phone_cairo', [
        'default' => '+20 10 076 69160',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('mosalam_contact_phone_cairo', [
        'label' => __('Phone (Cairo Office)', 'mosalam'),
        'section' => 'mosalam_footer',
        'type' => 'text',
    ]);

    $wp_customize->add_setting('mosalam_contact_email', [
        'default' => 'info@mosalam.com',
        'sanitize_callback' => 'sanitize_email',
    ]);
    $wp_customize->add_control('mosalam_contact_email', [
        'label' => __('Email', 'mosalam'),
        'section' => 'mosalam_footer',
        'type' => 'text',
    ]);

    $wp_customize->add_setting('mosalam_offices', [
        'default' => 'London, Cairo',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('mosalam_offices', [
        'label' => __('Office badges (comma separated)', 'mosalam'),
        'section' => 'mosalam_footer',
        'type' => 'text',
    ]);

    $wp_customize->add_setting('mosalam_copyright', [
        'default' => '© 2024 MOSALAM DIGITAL HORIZON. ALL RIGHTS RESERVED.',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('mosalam_copyright', [
        'label' => __('Copyright line', 'mosalam'),
        'section' => 'mosalam_footer',
        'type' => 'text',
    ]);
}
add_action('customize_register', 'mosalam_customize_register');
