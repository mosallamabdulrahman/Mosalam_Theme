<?php
/**
 * Offline-safe local seeder with logging.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function mosalam_log_seed_error( $msg ) {
    $log_dir = WP_CONTENT_DIR . '/themes/mosalam_new/scratch';
    if ( ! file_exists( $log_dir ) ) {
        @mkdir( $log_dir, 0755, true );
    }
    $log_file = $log_dir . '/seeder_log.txt';
    @file_put_contents( $log_file, '[' . date( 'Y-m-d H:i:s' ) . '] ' . $msg . "\n", FILE_APPEND );
}

function mosalam_safe_create_category( $cat_name ) {
    $term = term_exists( $cat_name, 'category' );
    if ( $term ) {
        if ( is_array( $term ) ) {
            return $term['term_id'];
        }
        return $term;
    }
    $new_term = wp_insert_term( $cat_name, 'category' );
    if ( ! is_wp_error( $new_term ) ) {
        return $new_term['term_id'];
    }
    return 1; // Fallback to Uncategorized (ID 1)
}

function mosalam_seed_blog_posts() {
    // Only run once
    if ( get_option( 'mosalam_blog_posts_seeded_v4' ) ) {
        return;
    }

    try {
        // Require WordPress administration media API files
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        // 1. Sideload the local blog_hero_bg.png once
        $theme_bg_path = MOSALAM_THEME_DIR . '/assets/images/blog_hero_bg.png';
        $featured_image_id = null;

        if ( ! file_exists( $theme_bg_path ) ) {
            mosalam_log_seed_error( "Source image file not found: " . $theme_bg_path );
        } else {
            $upload_dir = wp_upload_dir();
            if ( ! empty( $upload_dir['error'] ) ) {
                mosalam_log_seed_error( "wp_upload_dir error: " . $upload_dir['error'] );
            } else {
                $tmp_file = $upload_dir['path'] . '/temp_blog_hero_bg.png';
                
                if ( ! @copy( $theme_bg_path, $tmp_file ) ) {
                    mosalam_log_seed_error( "Failed to copy " . $theme_bg_path . " to " . $tmp_file );
                } else {
                    $file_array = [
                        'name'     => 'hosting_featured_image.png',
                        'tmp_name' => $tmp_file,
                    ];

                    // Insert into attachment database
                    $attachment_id = media_handle_sideload( $file_array, 0, 'Featured Blog Post Image' );
                    if ( is_wp_error( $attachment_id ) ) {
                        mosalam_log_seed_error( "media_handle_sideload error: " . $attachment_id->get_error_message() );
                        @unlink( $tmp_file );
                    } else {
                        $featured_image_id = $attachment_id;
                        mosalam_log_seed_error( "Sideloaded image successfully, Attachment ID: " . $featured_image_id );
                    }
                }
            }
        }

        $posts_data = [
            [
                'title'    => 'How to Choose the Perfect Web Hosting for Your WordPress Site',
                'category' => 'Cloud Infrastructure',
                'content'  => '<!-- wp:paragraph -->
<p>Choosing the right web hosting is one of the most critical decisions you will make for your online presence. Your hosting provider dictates your website\'s speed, security, and uptime—three foundational pillars that directly impact your user experience and SEO rankings.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="why-web-hosting-matters-for-seo">Why Web Hosting Matters for SEO</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Search engines like Google prioritize fast-loading websites. If your server is slow, visitors will bounce before the pages even load, sending negative signals to search algorithms. A high-quality hosting service ensures your server responds instantly, keeping both your users and Google happy.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="3-essential-features-to-look-for">3 Essential Features to Look For</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>When selecting a host, prioritize these features to ensure stability and growth:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul>
<li><strong>99.9% Uptime Guarantee:</strong> Your site needs to be accessible 24/7 without unexpected crashes.</li>
<li><strong>Built-in Security:</strong> Look for hosts providing free SSL certificates, daily backups, and malware scanning.</li>
<li><strong>Top-Tier Speed Technology:</strong> Choose servers utilizing SSD storage and caching layers for blistering loading times.</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading {"level":2} -->
<h2 id="conclusion">Conclusion</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Don\'t compromise on your site\'s foundation. Investing in reliable web hosting saves you from future technical headaches and accelerates your digital growth. Ready to take your site to the next level? Choose wisely!</p>
<!-- /wp:paragraph -->',
            ],
            [
                'title'    => 'Unlocking Growth: Why Managed Cloud Hosting is the Future',
                'category' => 'Cloud Infrastructure',
                'content'  => '<!-- wp:paragraph -->
<p>As businesses grow, standard hosting options can become bottlenecks. The need for scalability, flexibility, and robust performance has paved the way for managed cloud hosting—a paradigm shift in web architecture.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="understanding-cloud-hosting">Understanding Cloud Hosting</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Unlike traditional shared servers, cloud hosting distributes your data across multiple virtual servers. This decentralized setup means that if one server goes down, another seamlessly takes its place, eliminating downtime completely.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="the-benefits-of-managed-management">The Benefits of Managed Management</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Having cloud servers is great, but running them requires system administration expertise. Managed cloud hosting handles all server management duties:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul>
<li><strong>Automated OS Updates:</strong> Keeping server software secure without human intervention.</li>
<li><strong>Dynamic Scaling:</strong> Increasing resources (RAM/CPU) instantly during traffic spikes.</li>
<li><strong>Proactive Server Monitoring:</strong> Detecting and resolving anomalies before they affect visitors.</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading {"level":3} -->
<h3 id="focus-on-business-not-maintenance">Focus on Business, Not Maintenance</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>By delegating server management to dedicated experts, your team can concentrate on development and customer acquisition rather than debugging server crashes.</p>
<!-- /wp:paragraph -->',
            ],
            [
                'title'    => 'The Ultimate Security Guide to Enterprise Data Protection',
                'category' => 'Cyber Security',
                'content'  => '<!-- wp:paragraph -->
<p>Cybersecurity is no longer just an IT concern; it is a vital business risk management element. With digital assets becoming target priorities, enterprises must establish impenetrable walls of protection.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="establishing-zero-trust-architecture">Establishing Zero Trust Architecture</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The core principle of zero-trust is simple: "never trust, always verify." No user or device should be trusted by default, whether inside or outside the organization network boundary.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="three-pillars-of-modern-cyber-defense">Three Pillars of Modern Cyber Defense</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>To defend your enterprise against sophisticated attacks, implement the following safeguards:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul>
<li><strong>Multi-Factor Authentication (MFA):</strong> Mandating multiple forms of ID verification.</li>
<li><strong>End-to-End Encryption:</strong> Securing data in transit and at rest.</li>
<li><strong>Regular Security Auditing:</strong> Simulating breach scenarios to expose vulnerabilities.</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading {"level":3} -->
<h3 id="compliance-and-governance">Compliance and Governance</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Aligning data procedures with GDPR, HIPAA, and industry-standard security baselines is mandatory for avoiding heavy regulatory penalties.</p>
<!-- /wp:paragraph -->',
            ],
            [
                'title'    => 'Maximizing Odoo Performance: Managed Container Infrastructure',
                'category' => 'Digital Strategy',
                'content'  => '<!-- wp:paragraph -->
<p>Odoo is a powerful ERP system, but its performance depends heavily on the underlying infrastructure. Running it in isolated containers guarantees fast execution and easy scaling.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="why-containers-for-odoo">Why Containers for Odoo?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Containerizing Odoo isolates the database, application server, and background workers, preventing resource bottlenecks and simplifying deployments.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="key-tuning-strategies">Key Tuning Strategies</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>PostgreSQL Optimization:</strong> Tuning shared buffers and query caching parameters.</li>
<li><strong>Gunicorn Worker Allocation:</strong> Configuring workers matching CPU core density.</li>
<li><strong>Redis Session Cache:</strong> Offloading session storage for instant page responses.</li>
</ul>
<!-- /wp:list -->',
            ],
            [
                'title'    => 'Demystifying the "Noisy Neighbor" Problem in Cloud Virtualization',
                'category' => 'Cloud Infrastructure',
                'content'  => '<!-- wp:paragraph -->
<p>In virtualized server environments, a "noisy neighbor" occurs when a virtual machine co-located on the same physical host monopolizes shared CPU, RAM, or I/O resources, causing latency spikes for other accounts.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="identifying-resource-steal">Identifying Resource Steal</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>If your VPS experiences unpredictable performance slowdowns, check the CPU steal percentage using Linux utilities. A high steal rate indicates noisy neighbor congestion.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="how-mosalam-isolates-servers">How Mosalam Isolates Servers</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>At Mosalam, we employ strict resource limits and virtualization constraints to guarantee that every virtual server operates in complete isolation, securing 100% of your paid capacity.</p>
<!-- /wp:paragraph -->',
            ],
            [
                'title'    => 'Digital Workplace: The Future of Device as a Service (DaaS)',
                'category' => 'Digital Strategy',
                'content'  => '<!-- wp:paragraph -->
<p>Managing physical IT devices for thousands of employees is a complex logistical challenge. Device as a Service (DaaS) consolidates hardware procurement, software deployment, and active support into a clean subscription model.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="cost-efficiency-and-asset-lifecycle">Cost Efficiency and Asset Lifecycle</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>DaaS transforms high upfront IT capital expenditures (CapEx) into predictable operating expenses (OpEx), while guaranteeing employee hardware remains up-to-date.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="seamless-onboarding-workflows">Seamless Onboarding Workflows</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>With pre-configured devices shipped directly to remote workers, onboarding becomes instant, secure, and completely unburdened by standard manual setups.</p>
<!-- /wp:paragraph -->',
            ],
            [
                'title'    => 'Securing Remote Teams: Best Practices for Corporate VPNs',
                'category' => 'Cyber Security',
                'content'  => '<!-- wp:paragraph -->
<p>With remote work becoming standard corporate behavior, securing network endpoints outside the firewall is critical. A robust VPN architecture is the first line of enterprise defense.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="choosing-modern-protocols">Choosing Modern Protocols</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Transition from outdated PPTP/L2TP protocols to WireGuard or OpenVPN to secure faster speeds and stronger encryption algorithms.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="integrating-identity-providers">Integrating Identity Providers</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Integrate your corporate VPN with Active Directory or single sign-on (SSO) systems to enforce conditional access and MFA controls.</p>
<!-- /wp:paragraph -->',
            ],
            [
                'title'    => 'The HIPAA & GDPR Compliance Checklist for Health Tech Startups',
                'category' => 'Cyber Security',
                'content'  => '<!-- wp:paragraph -->
<p>Compliance is a critical hurdle for digital health platforms. Enforcing HIPAA in the US and GDPR in Europe is mandatory for protecting sensitive customer data and operating legally.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="mandatory-data-controls">Mandatory Data Controls</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Startups must enforce granular data access logging, audit trails, and automatic session terminations on all software layers.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="secure-hosting-partnerships">Secure Hosting Partnerships</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Host your medical applications only on compliant, isolated database environments that sign Business Associate Agreements (BAA) and support encrypted object storage.</p>
<!-- /wp:paragraph -->',
            ],
            [
                'title'    => 'Why Custom CRM Integrations Beat Off-the-Shelf SaaS Solutions',
                'category' => 'Digital Strategy',
                'content'  => '<!-- wp:paragraph -->
<p>SaaS platforms offer quick setups, but custom CRM integrations align 100% with your organizational workflows, eliminating redundant licenses and manual data synchronization.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="tailored-sales-workflows">Tailored Sales Workflows</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>A custom CRM scales exactly with your business model, enabling automated billing triggers, support ticketers, and inventory checks matching your logic.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 id="complete-data-ownership">Complete Data Ownership</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Avoid vendor lock-in risks and secure full hosting control over your customer database, avoiding pricing changes from external SaaS platforms.</p>
<!-- /wp:paragraph -->',
            ],
        ];

        foreach ( $posts_data as $post_info ) {
            $cat_id = mosalam_safe_create_category( $post_info['category'] );

            $post_id = wp_insert_post( [
                'post_title'    => $post_info['title'],
                'post_content'  => $post_info['content'],
                'post_status'   => 'publish',
                'post_type'     => 'post',
                'post_category' => [ $cat_id ],
            ] );

            if ( is_wp_error( $post_id ) ) {
                mosalam_log_seed_error( "Failed to insert post: " . $post_info['title'] . ". Error: " . $post_id->get_error_message() );
            } else {
                mosalam_log_seed_error( "Inserted post successfully: " . $post_info['title'] . " ID: " . $post_id );
                if ( $featured_image_id ) {
                    set_post_thumbnail( $post_id, $featured_image_id );
                }
            }
        }

        // Set Option to prevent duplicate runs
        update_option( 'mosalam_blog_posts_seeded_v4', true );
        mosalam_log_seed_error( "Seeding completed successfully!" );

    } catch ( Exception $e ) {
        mosalam_log_seed_error( "Seeder Exception: " . $e->getMessage() );
    }
}
add_action( 'init', 'mosalam_seed_blog_posts', 20 );
