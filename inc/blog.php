<?php
/**
 * Blog helpers: excerpt, reading time, heading IDs, contact form.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ──────────────────────────────────────────────
 * 1. Excerpt — 25 words, clean ellipsis.
 * ────────────────────────────────────────────── */
function mosalam_blog_excerpt_length() {
    return 25;
}
add_filter( 'excerpt_length', 'mosalam_blog_excerpt_length', 999 );

function mosalam_blog_excerpt_more() {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'mosalam_blog_excerpt_more' );

/* ──────────────────────────────────────────────
 * 2. Reading time estimate (words / 250).
 * ────────────────────────────────────────────── */
function mosalam_reading_time( $post_id = null ) {
    $post_id = $post_id ?: get_the_ID();
    $content = get_post_field( 'post_content', $post_id );
    $words   = str_word_count( wp_strip_all_tags( $content ) );
    $minutes = max( 1, (int) ceil( $words / 250 ) );
    return $minutes;
}

/* ──────────────────────────────────────────────
 * 3. Auto-inject IDs into H2/H3 for TOC anchoring.
 *    Only runs on singular post views.
 * ────────────────────────────────────────────── */
function mosalam_add_heading_ids( $content ) {
    if ( ! is_singular( 'post' ) ) {
        return $content;
    }

    $content = preg_replace_callback(
        '/<(h[23])([^>]*)>(.*?)<\/\1>/is',
        function ( $matches ) {
            $tag   = $matches[1];
            $attrs = $matches[2];
            $text  = $matches[3];

            // Don't override existing IDs
            if ( preg_match( '/id\s*=/i', $attrs ) ) {
                return $matches[0];
            }

            $id = sanitize_title( wp_strip_all_tags( $text ) );

            return sprintf( '<%s%s id="%s">%s</%s>', $tag, $attrs, esc_attr( $id ), $text, $tag );
        },
        $content
    );

    return $content;
}
add_filter( 'the_content', 'mosalam_add_heading_ids', 5 );

/* ──────────────────────────────────────────────
 * 4. Extract H2/H3 headings for Table of Contents.
 * ────────────────────────────────────────────── */
function mosalam_get_toc_headings( $post_id = null ) {
    $post_id = $post_id ?: get_the_ID();
    $content = get_post_field( 'post_content', $post_id );
    $content = apply_filters( 'the_content', $content );

    $headings = [];
    if ( preg_match_all( '/<(h[23])[^>]*id=["\']([^"\']+)["\'][^>]*>(.*?)<\/\1>/is', $content, $matches, PREG_SET_ORDER ) ) {
        foreach ( $matches as $match ) {
            $headings[] = [
                'level' => $match[1],
                'id'    => $match[2],
                'text'  => wp_strip_all_tags( $match[3] ),
            ];
        }
    }

    return $headings;
}

/* ──────────────────────────────────────────────
 * 5. Quick Contact Form handler (admin-post).
 * ────────────────────────────────────────────── */
function mosalam_blog_contact_handler() {
    // Verify nonce
    if ( ! isset( $_POST['_mosalam_contact_nonce'] ) ||
         ! wp_verify_nonce( $_POST['_mosalam_contact_nonce'], 'mosalam_blog_contact' ) ) {
        wp_die( __( 'Security check failed.', 'mosalam' ), 403 );
    }

    $name    = sanitize_text_field( $_POST['mosalam_name'] ?? '' );
    $email   = sanitize_email( $_POST['mosalam_email'] ?? '' );
    $message = sanitize_textarea_field( $_POST['mosalam_message'] ?? '' );
    $referer = esc_url_raw( $_POST['_wp_http_referer'] ?? home_url( '/' ) );

    // Validate
    if ( empty( $name ) || empty( $email ) || empty( $message ) || ! is_email( $email ) ) {
        wp_safe_redirect( add_query_arg( 'contact', 'error', $referer ) );
        exit;
    }

    // Send email
    $to      = 'info@mosalam.com';
    $subject = sprintf( '[Mosalam Blog] New message from %s', $name );
    $body    = sprintf(
        "Name: %s\nEmail: %s\n\nMessage:\n%s\n\n---\nSent from: %s",
        $name,
        $email,
        $message,
        $referer
    );
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        sprintf( 'Reply-To: %s <%s>', $name, $email ),
    ];

    $sent = wp_mail( $to, $subject, $body, $headers );

    wp_safe_redirect( add_query_arg( 'contact', $sent ? 'success' : 'error', $referer ) );
    exit;
}
add_action( 'admin_post_mosalam_blog_contact', 'mosalam_blog_contact_handler' );
add_action( 'admin_post_nopriv_mosalam_blog_contact', 'mosalam_blog_contact_handler' );
