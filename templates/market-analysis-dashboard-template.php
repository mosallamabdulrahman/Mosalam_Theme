<?php
/**
 * Template Name: Market Analysis Dashboard
 */

get_header();
?>

<?php
// Custom CSS and Chart.js script are enqueued dynamically in functions.php
?>

<main class="market-dashboard-wrap w-full min-h-screen">
    
    <!-- Hero Banner -->
    <section class="relative bg-primary overflow-hidden animate-fade-in-up">
        <div class="absolute inset-0">
            <img src="<?php echo esc_url( MOSALAM_THEME_URI . '/assets/images/blog_hero_bg.png' ); ?>" alt="" class="w-full h-full object-cover opacity-35">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/90 to-primary/45"></div>
        <div class="relative container-custom py-16 md:py-20 text-center">
            <p class="text-overline text-secondary mb-4"><?php esc_html_e( 'Market Intelligence', 'mosalam' ); ?></p>
            <h1 class="text-h1 text-white mb-4"><?php esc_html_e( 'Strategic Report', 'mosalam' ); ?></h1>
            <p class="text-body-lg text-white/70 max-w-2xl mx-auto">
                <?php esc_html_e( 'An in-depth analysis of technical hosting, hidden competitor costs, and the managed cloud infrastructure paradigm.', 'mosalam' ); ?>
            </p>
        </div>
    </section>

    <!-- Main Content Container with Tabs -->
    <div class="container-custom pt-8 pb-16 md:pt-12 md:pb-24 w-full">

        <!-- Tabs Navigation -->
        <div class="flex flex-wrap items-center justify-center gap-2 border-b border-outline-variant/30 pb-6 mb-10 w-full animate-fade-in-up">
            <button onclick="navigate('dashboard')" id="btn-dashboard" class="nav-btn active px-5 py-2.5 text-sm font-bold rounded-action border border-outline-variant/30 bg-white text-primary hover:text-secondary hover:border-secondary transition-all">Market Overview</button>
            <button onclick="navigate('competitors')" id="btn-competitors" class="nav-btn px-5 py-2.5 text-sm font-bold rounded-action border border-outline-variant/30 bg-white text-primary hover:text-secondary hover:border-secondary transition-all">Competitor Analysis</button>
            <button onclick="navigate('strategy')" id="btn-strategy" class="nav-btn px-5 py-2.5 text-sm font-bold rounded-action border border-outline-variant/30 bg-white text-primary hover:text-secondary hover:border-secondary transition-all">Mosalam Strategy</button>
            <button onclick="navigate('pricing')" id="btn-pricing" class="nav-btn px-5 py-2.5 text-sm font-bold rounded-action border border-outline-variant/30 bg-white text-primary hover:text-secondary hover:border-secondary transition-all">Pricing & TCO</button>
        </div>

        <!-- SECTION 1: DASHBOARD / MARKET OVERVIEW -->
        <section id="dashboard" class="space-y-8 animate-fade-in-up">
            <div class="text-center max-w-3xl mx-auto">
                <h2 class="text-3xl font-bold text-primary mb-4">Navigating the "Market Void"</h2>
                <p class="text-lg text-on-surface/80">
                    The hosting market is polarized. On one side, <strong>Budget Giants</strong> (Contabo, Hostinger) offer low prices with hidden limits. On the other, <strong>Hyperscalers</strong> (AWS) offer complexity. Mosalam.Com captures the high-value "Homeless" users in the middle who demand stability and managed care.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-4">
                <!-- Market Chart -->
                <div class="card p-6">
                    <h3 class="text-xl font-bold mb-4 text-primary font-headline">The Quality vs. Price Landscape</h3>
                    <div class="chart-container">
                        <canvas id="marketChart"></canvas>
                    </div>
                    <p class="text-sm text-on-surface-variant mt-4 text-center">Mosalam occupies the "Sweet Spot": Higher reliability than budget, lower complexity than hyperscalers.</p>
                </div>

                <!-- Executive Summary Cards -->
                <div class="space-y-4">
                    <div class="card p-6 highlight-box">
                        <h4 class="font-bold text-secondary text-lg">The Opportunity</h4>
                        <p class="text-on-surface/90 mt-2">There is a growing segment of businesses, educational institutions, and developers churning out of Contabo and Hostinger due to performance degradation ("Noisy Neighbor") and lack of support. These users are willing to pay a premium for <strong>honesty and stability</strong>.</p>
                    </div>
                    <div class="card p-6 pain-point">
                        <h4 class="font-bold text-error text-lg">The Competitor Trap</h4>
                        <ul class="list-disc list-inside mt-2 text-on-surface/90 space-y-2">
                            <li><strong>Contabo:</strong> Raw specs on paper, but CPU Steal and instability in reality. Location fees increase cost by ~40%.</li>
                            <li><strong>Hostinger:</strong> Beautiful UI, but "Walled Garden" limits (Inodes, PHP workers). "Managed" only means the platform works, not your app.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 2: COMPETITOR ANALYSIS -->
        <section id="competitors" class="hidden space-y-8 animate-fade-in-up">
            <div class="mb-6 border-b border-outline-variant/30 pb-4">
                <h2 class="text-3xl font-bold text-primary">The Giants: Detailed Reconnaissance</h2>
                <p class="text-on-surface-variant mt-2">Understanding where they fail is how we win. Analysis based on technical deep-dives of Hostinger and Contabo.</p>
            </div>

            <!-- Radar Chart Comparison -->
            <div class="card p-6 mb-8">
                <h3 class="text-xl font-bold text-center mb-4 text-primary font-headline">The "Hosting Reality" Matrix</h3>
                <div class="chart-container">
                    <canvas id="radarChart"></canvas>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 text-center text-sm font-body">
                    <div class="text-secondary font-semibold">Mosalam: Balanced, Support-Heavy</div>
                    <div class="text-primary font-semibold">Contabo: High Raw Specs, Low Support</div>
                    <div class="text-tertiary font-semibold">Hostinger: High Ease of Use, Low Freedom</div>
                </div>
            </div>

            <!-- Detailed Cards Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Contabo Analysis -->
                <div class="card p-6 border-t-4 border-[#001b35]">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-2xl font-bold text-primary font-headline">Contabo</h3>
                        <span class="bg-[#001b35]/5 text-primary px-3 py-1 rounded-full text-xs font-bold">The Raw Spec Giant</span>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-bold text-primary text-sm">The Pitch:</h4>
                            <p class="text-sm text-on-surface-variant">"German Quality," massive RAM/CPU for rock-bottom prices. Proprietary hardware ownership.</p>
                        </div>
                        <div class="bg-error/5 p-4 border-l-4 border-error rounded-r">
                            <h4 class="font-bold text-error text-sm">The Reality (Weaknesses):</h4>
                            <ul class="list-disc list-inside text-sm text-on-surface/90 mt-2 space-y-1">
                                <li><strong>Overselling:</strong> "Steal Time" affects performance. You share resources with noisy neighbors.</li>
                                <li><strong>Hidden Costs:</strong> Setup fees + Location fees (Asia/US) add 35-45% to the bill.</li>
                                <li><strong>Support Void:</strong> Strictly unmanaged. If the server is "on" but your app is broken, they won't help.</li>
                                <li><strong>Object Storage:</strong> No logging (S3 API limit), making it non-compliant for HIPAA/GDPR auditing.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Hostinger Analysis -->
                <div class="card p-6 border-t-4 border-tertiary">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-2xl font-bold text-tertiary font-headline">Hostinger</h3>
                        <span class="bg-tertiary/5 text-tertiary px-3 py-1 rounded-full text-xs font-bold">The UX Giant</span>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-bold text-primary text-sm">The Pitch:</h4>
                            <p class="text-sm text-on-surface-variant">Sleek hPanel, fast onboarding, LiteSpeed servers. Great for beginners.</p>
                        </div>
                        <div class="bg-error/5 p-4 border-l-4 border-error rounded-r">
                            <h4 class="font-bold text-error text-sm">The Reality (Weaknesses):</h4>
                            <ul class="list-disc list-inside text-sm text-on-surface/90 mt-2 space-y-1">
                                <li><strong>The Walled Garden:</strong> hPanel abstracts everything. Good until you need custom configs.</li>
                                <li><strong>Hard Limits:</strong> Inode limits and PHP Worker caps force upgrades even if CPU usage is low.</li>
                                <li><strong>"Managed" Confusion:</strong> They manage the platform, not your WordPress plugin errors.</li>
                                <li><strong>Renewal Shock:</strong> Introductory prices ($3/mo) triple upon renewal.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 3: MOSALAM STRATEGY -->
        <section id="strategy" class="hidden space-y-8 animate-fade-in-up">
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-primary">The Mosalam Advantage: Managed Reality</h2>
                <p class="text-on-surface-variant mt-2">We don't sell "Unlimited." We sell "Uninterrupted." Our strategy focuses on the middle market that has outgrown budget limits.</p>
            </div>

            <!-- Service Hierarchy Visual -->
            <div class="card p-8 bg-surface-container border border-outline-variant/30">
                <h3 class="text-xl font-bold mb-6 text-center text-primary font-headline">Service Architecture & Responsibility Model</h3>
                <div class="flex flex-col lg:flex-row justify-between items-stretch gap-6">
                    
                    <!-- Level 1 -->
                    <div class="flex-1 bg-white border border-outline-variant/30 p-5 rounded-action shadow-sm hover:shadow-md transition">
                        <div class="h-12 w-12 bg-primary/5 text-primary rounded-full flex items-center justify-center mb-4 text-xl">⚙️</div>
                        <h4 class="font-bold text-lg text-primary mb-2">1. Unmanaged VPS</h4>
                        <p class="text-sm text-on-surface-variant mb-4">For Tech Savvy Users.</p>
                        <ul class="text-xs text-on-surface space-y-1">
                            <li>✅ Mosalam: Hardware & Network</li>
                            <li>❌ Mosalam: OS Updates</li>
                            <li>❌ Mosalam: App Security</li>
                        </ul>
                        <div class="mt-4 text-secondary font-bold text-sm">The "Contabo Alternative" but with honest specs.</div>
                    </div>

                    <!-- Arrow -->
                    <div class="hidden lg:flex items-center text-outline-variant/50 text-2xl">➔</div>

                    <!-- Level 2 -->
                    <div class="flex-1 bg-white border-t-4 border-secondary p-5 rounded-action shadow-sm hover:shadow-md transition">
                        <div class="h-12 w-12 bg-secondary/5 text-secondary rounded-full flex items-center justify-center mb-4 text-xl">🛡️</div>
                        <h4 class="font-bold text-lg text-primary mb-2">2. Managed Servers</h4>
                        <p class="text-sm text-on-surface-variant mb-4">Core Business Offering.</p>
                        <ul class="text-xs text-on-surface space-y-1">
                            <li>✅ Mosalam: OS & Core Services</li>
                            <li>✅ Mosalam: Security & Updates</li>
                            <li>❌ Mosalam: Content/Data</li>
                        </ul>
                        <div class="mt-4 text-secondary font-bold text-sm">The Sweet Spot for Agencies.</div>
                    </div>

                    <!-- Arrow -->
                    <div class="hidden lg:flex items-center text-outline-variant/50 text-2xl">➔</div>

                    <!-- Level 3 -->
                    <div class="flex-1 bg-white border-t-4 border-tertiary p-5 rounded-action shadow-sm hover:shadow-md transition">
                        <div class="h-12 w-12 bg-tertiary/5 text-tertiary rounded-full flex items-center justify-center mb-4 text-xl">🚀</div>
                        <h4 class="font-bold text-lg text-primary mb-2">3. Fully Managed Apps</h4>
                        <p class="text-sm text-on-surface-variant mb-4">Premium Concierge.</p>
                        <ul class="text-xs text-on-surface space-y-1">
                            <li>✅ Mosalam: Installation & Tuning</li>
                            <li>✅ Mosalam: App-level Email</li>
                            <li>✅ Mosalam: Performance Tweaks</li>
                        </ul>
                        <div class="mt-4 text-secondary font-bold text-sm">Total Peace of Mind.</div>
                    </div>

                </div>
            </div>

            <!-- Value Proposition Text -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="card p-6">
                    <h4 class="font-bold text-lg mb-4 text-primary font-headline">How We Compete</h4>
                    <p class="text-on-surface/90 leading-relaxed mb-4">
                        We cannot beat Contabo on raw price per GB of RAM. We shouldn't try. We compete by selling <strong>Time and Certainty</strong>.
                    </p>
                    <ul class="list-disc list-inside text-sm text-on-surface-variant space-y-2">
                        <li><strong>Honest Specs:</strong> No "burst" resources that disappear when you need them.</li>
                        <li><strong>Human Support:</strong> Accessible experts, not chatbots.</li>
                        <li><strong>Transparent Limits:</strong> We explain <em>why</em> a limit exists (e.g., mail throughput) rather than just blocking the account.</li>
                    </ul>
                </div>
                <div class="card p-6">
                    <h4 class="font-bold text-lg mb-4 text-primary font-headline">Our Promise vs. Theirs</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-surface-container">
                                <tr>
                                    <th class="p-3 text-primary">Feature</th>
                                    <th class="p-3 text-on-surface-variant">Competitors</th>
                                    <th class="p-3 text-secondary">Mosalam.Com</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/20">
                                <tr>
                                    <td class="p-3 font-semibold text-primary">Uptime</td>
                                    <td class="p-3 text-on-surface-variant">Best Effort (often degraded)</td>
                                    <td class="p-3 text-secondary font-bold">Guaranteed Resources</td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-semibold text-primary">Pricing</td>
                                    <td class="p-3 text-on-surface-variant">Low Entry, High Renewal</td>
                                    <td class="p-3 text-secondary font-bold">Flat, Fair, Predictable</td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-semibold text-primary">Neighbors</td>
                                    <td class="p-3 text-on-surface-variant">Noisy, Oversold</td>
                                    <td class="p-3 text-secondary font-bold">Isolated, Capped Density</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 4: PRICING & TCO -->
        <section id="pricing" class="hidden space-y-8 animate-fade-in-up">
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-primary">Fair Pricing & Technical Specifications</h2>
                <p class="text-on-surface-variant mt-2">A sustainable business model based on transparency. Compare the True Cost of Ownership.</p>
            </div>

            <!-- TCO Calculator Section -->
            <div class="card p-6 bg-primary text-white">
                <h3 class="text-xl font-bold mb-4 text-secondary-fixed font-headline">The "Real Cost" Calculator</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <label class="block text-sm font-semibold">Select Service Type</label>
                        <select id="calc-service" class="w-full p-2.5 rounded bg-white text-primary font-bold text-sm focus:outline-none focus:ring-2 focus:ring-secondary" onchange="updateTCO()">
                            <option value="vps">Virtual Private Server (VPS)</option>
                            <option value="app">Managed Application (Odoo/Moodle)</option>
                        </select>

                        <label class="block text-sm font-semibold">Your Hourly Rate ($/hr) <span class="text-xs text-white/60">(Cost of your time fixing issues)</span></label>
                        <input type="number" id="calc-rate" value="50" class="w-full p-2.5 rounded bg-white text-primary font-bold text-sm focus:outline-none focus:ring-2 focus:ring-secondary" oninput="updateTCO()">

                        <label class="block text-sm font-semibold">Expected Monthly Downtime/Troubleshooting (Hours)</label>
                        <input type="range" id="calc-hours" min="0" max="10" value="2" class="w-full accent-secondary" oninput="updateTCO()">
                        <div class="flex justify-between text-xs text-white/50">
                            <span>0 hrs</span>
                            <span id="hours-display" class="font-bold text-secondary-fixed">2 hrs</span>
                            <span>10 hrs</span>
                        </div>
                    </div>
                    
                    <div class="bg-white/5 border border-white/10 p-5 rounded-action flex flex-col justify-center">
                        <div class="mb-4">
                            <h4 class="text-white/60 text-sm">Competitor Monthly Cost</h4>
                            <div class="text-2xl font-bold text-error" id="comp-cost">$106.00</div>
                            <div class="text-xs text-white/55">Base Price: $<span id="comp-base">6</span> + Hidden Time Cost: $<span id="comp-hidden">100</span></div>
                        </div>
                        <div class="border-t border-white/10 pt-4">
                            <h4 class="text-secondary-fixed text-sm">Mosalam Fair Price</h4>
                            <div class="text-3xl font-bold text-secondary-fixed" id="mosalam-cost">$35.00</div>
                            <div class="text-xs text-white/55">Includes Management & Stability. You save time.</div>
                        </div>
                        <div class="mt-4 p-2.5 bg-secondary text-white rounded text-center text-sm font-bold">
                            <strong>Savings:</strong> <span id="savings-display">$71.00</span> / month
                        </div>
                    </div>
                </div>
            </div>

            <!-- Price List & Specs Table -->
            <div class="card p-6 overflow-hidden">
                <h3 class="text-xl font-bold mb-4 text-primary font-headline">Proposed 2025 Price List & Specs</h3>
                <div class="overflow-x-auto custom-scroll">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container border-b">
                                <th class="p-3 text-primary">Plan Name</th>
                                <th class="p-3 text-primary">Ideal For</th>
                                <th class="p-3 text-primary">Specs (Honest)</th>
                                <th class="p-3 text-primary">Monthly</th>
                                <th class="p-3 text-primary">1 Year (10% Off)</th>
                                <th class="p-3 text-primary">2 Year (20% Off)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/20 text-on-surface/90">
                            <!-- Shared -->
                            <tr class="hover:bg-surface-container-low/40">
                                <td class="p-3 font-bold text-secondary">Starter Shared</td>
                                <td class="p-3">Personal Blogs</td>
                                <td class="p-3">1 Core, 2GB RAM, 10GB NVMe<br><span class="text-xs text-on-surface-variant">CloudLinux Isolated</span></td>
                                <td class="p-3 font-semibold">$5.00</td>
                                <td class="p-3">$54.00</td>
                                <td class="p-3">$96.00</td>
                            </tr>
                            <tr class="hover:bg-surface-container-low/40">
                                <td class="p-3 font-bold text-secondary">Business Shared</td>
                                <td class="p-3">SMB Websites</td>
                                <td class="p-3">2 Cores, 4GB RAM, 50GB NVMe<br><span class="text-xs text-on-surface-variant">Priority Support</span></td>
                                <td class="p-3 font-semibold">$12.00</td>
                                <td class="p-3">$129.00</td>
                                <td class="p-3">$230.00</td>
                            </tr>
                            <!-- VPS -->
                            <tr class="bg-surface-container-low/30 hover:bg-surface-container-low/50">
                                <td class="p-3 font-bold text-primary">VPS Standard</td>
                                <td class="p-3">Growing Apps</td>
                                <td class="p-3">4 vCPU (AMD EPYC), 8GB RAM, 100GB NVMe<br><span class="text-xs text-on-surface-variant">Unmanaged / Root Access</span></td>
                                <td class="p-3 font-semibold">$18.00</td>
                                <td class="p-3">$194.00</td>
                                <td class="p-3">$345.00</td>
                            </tr>
                            <tr class="bg-surface-container-low/30 hover:bg-surface-container-low/50">
                                <td class="p-3 font-bold text-primary">Managed VPS</td>
                                <td class="p-3">Agencies / E-comm</td>
                                <td class="p-3">4 vCPU, 8GB RAM, 100GB NVMe<br><span class="text-xs text-on-surface-variant">Fully Managed OS + Backups</span></td>
                                <td class="p-3 font-semibold">$45.00</td>
                                <td class="p-3">$486.00</td>
                                <td class="p-3">$864.00</td>
                            </tr>
                            <!-- App -->
                            <tr class="hover:bg-surface-container-low/40">
                                <td class="p-3 font-bold text-tertiary">Odoo/Moodle Pro</td>
                                <td class="p-3">Institutions</td>
                                <td class="p-3">Dedicated Container Resources<br><span class="text-xs text-on-surface-variant">App-Level Support & Updates</span></td>
                                <td class="p-3 font-semibold">$60.00</td>
                                <td class="p-3">$648.00</td>
                                <td class="p-3">$1,152.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="text-xs text-on-surface-variant mt-4 text-center">* All plans include DDoS protection and daily off-site backups (except Unmanaged VPS). Prices reflect sustainable margins ensuring no overcrowding.</p>
            </div>
            
            <!-- Value Over Time Chart -->
            <div class="card p-6">
                 <h3 class="text-xl font-bold mb-4 text-primary font-headline">Cumulative Cost: The "Cheap" Illusion</h3>
                 <div class="chart-container">
                     <canvas id="growthChart"></canvas>
                 </div>
                 <p class="text-sm text-center mt-4 text-on-surface-variant">While competitors spike in cost due to renewals and troubleshooting, Mosalam remains linear and predictable.</p>
            </div>
        </section>

        <!-- Dynamic Transparency Pledge Section -->
        <section class="bg-primary text-white rounded-action p-8 md:p-12 mt-16 shadow-lg text-center animate-fade-in-up">
            <h3 class="text-2xl font-bold mb-3 font-headline">Mosalam.Com Transparency Pledge</h3>
            <p class="text-white/70 text-sm max-w-2xl mx-auto mb-6 leading-relaxed">
                We promise honest specifications, no noisy neighbors, and support that actually fixes problems. We are not the cheapest; we are the most valuable for your peace of mind.
            </p>
            <p class="text-[10px] text-white/50">Generated Strategy Report based on internal market analysis and competitor technical specifications (Contabo/Hostinger).</p>
        </section>

    </div>
</main>

<?php
// Custom JS is enqueued dynamically in functions.php
?>

<?php
get_footer();
