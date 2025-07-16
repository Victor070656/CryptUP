<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>CryptUP - Secure Crypto Backup</title>
    <meta name="description"
        content="The most secure and intuitive crypto backup solution. Protect your digital assets with military-grade encryption and seamless recovery.">
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="animated-bg">
    <?php include "components/nav.php"; ?>

    <!-- Hero Section -->
    <section class="hero-pattern min-h-screen flex items-center justify-center py-32">
        <div class="container mx-auto px-6 text-center">
            <div class="max-w-5xl mx-auto">
                <div class="animate-fade-in-up opacity-0 stagger-1">
                    <h1 class="text-4xl md:text-6xl lg:text-8xl font-black mb-6 leading-tight">
                        <span class="gradient-text">Secure Your</span><br>
                        <span
                            class="bg-gradient-to-r from-green-300 via-green-700 to-cyan-400 bg-clip-text text-transparent">
                            Crypto Future
                        </span>
                    </h1>
                </div>

                <div class="animate-fade-in-up opacity-0 stagger-2">
                    <p class="text-lg md:text-xl lg:text-2xl text-gray-400 mb-12 max-w-3xl mx-auto leading-relaxed">
                        The most advanced crypto backup solution with military-grade encryption,
                        seamless recovery, and enterprise-level security for your digital assets.
                    </p>
                </div>

                <div class="animate-fade-in-up opacity-0 stagger-3">
                    <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-16">
                        <button class="btn-primary text-lg px-8 py-4 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            <span>Secure Your Crypto</span>
                        </button>
                        <button class="btn-secondary text-lg px-8 py-4 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10V9a2 2 0 012-2h2a2 2 0 012 2v1M9 10v4a2 2 0 002 2h2a2 2 0 002-2v-4">
                                </path>
                            </svg>
                            <span>Recovery Demo</span>
                        </button>
                    </div>
                </div>

                <div class="animate-fade-in-up opacity-0 stagger-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                        <div class="text-center">
                            <div class="text-2xl md:text-3xl font-bold text-cyan-400 mb-2">99.9%</div>
                            <div class="text-gray-400">Uptime Guarantee</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl md:text-3xl font-bold text-indigo-400 mb-2">256-bit</div>
                            <div class="text-gray-400">AES Encryption</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl md:text-3xl font-bold text-purple-400 mb-2">24/7</div>
                            <div class="text-gray-400">Support</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-32 relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6 gradient-text">Why Choose CryptUP?</h2>
                <p class="text-lg md:text-xl text-gray-400 max-w-2xl mx-auto">
                    Built by security experts, trusted by crypto enthusiasts worldwide
                </p>
            </div>

            <div class="feature-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="glass-card p-8 text-center floating">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white relative z-10" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold mb-4">Military-Grade Security</h3>
                    <p class="text-gray-400 leading-relaxed">
                        Your crypto assets are protected with the same encryption standards used by governments and
                        financial institutions worldwide.
                    </p>
                </div>

                <div class="glass-card p-8 text-center floating" style="animation-delay: 0.2s;">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white relative z-10" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold mb-4">Instant Recovery</h3>
                    <p class="text-gray-400 leading-relaxed">
                        Recover your wallets in seconds, not hours. Our advanced recovery system ensures you're never
                        locked out of your assets.
                    </p>
                </div>

                <div class="glass-card p-8 text-center floating" style="animation-delay: 0.4s;">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white relative z-10" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold mb-4">Multi-Chain Support</h3>
                    <p class="text-gray-400 leading-relaxed">
                        Backup and restore wallets across all major blockchains including Bitcoin, Ethereum, Solana, and
                        50+ more networks.
                    </p>
                </div>

                <div class="glass-card p-8 text-center floating" style="animation-delay: 0.6s;">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white relative z-10" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold mb-4">Lightning Fast</h3>
                    <p class="text-gray-400 leading-relaxed">
                        Experience the fastest backup and recovery times in the industry. Your time is valuable, and we
                        respect that.
                    </p>
                </div>

                <div class="glass-card p-8 text-center floating" style="animation-delay: 0.8s;">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white relative z-10" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold mb-4">Smart Analytics</h3>
                    <p class="text-gray-400 leading-relaxed">
                        Get intelligent insights about your backup history, security score, and optimization
                        recommendations.
                    </p>
                </div>

                <div class="glass-card p-8 text-center floating" style="animation-delay: 1s;">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white relative z-10" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold mb-4">Team Collaboration</h3>
                    <p class="text-gray-400 leading-relaxed">
                        Share secure backup access with your team members while maintaining complete control over
                        permissions and access levels.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-32 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-900/20 via-purple-900/20 to-cyan-900/20"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="glass-card p-8 md:p-16 text-center max-w-4xl mx-auto">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6 gradient-text">Ready to Secure Your Future?
                </h2>
                <p class="text-lg md:text-xl text-gray-400 mb-12 max-w-2xl mx-auto">
                    Join thousands of crypto enthusiasts who trust CryptUP to protect their digital assets.
                    Start your secure backup journey today.
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <button
                        class="btn-primary text-lg md:text-xl px-8 md:px-12 py-4 md:py-5 flex items-center space-x-3">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span>Get Started Free</span>
                    </button>
                    <button
                        class="btn-secondary text-lg md:text-xl px-8 md:px-12 py-4 md:py-5 flex items-center space-x-3">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <span>Talk to Expert</span>
                    </button>
                </div>
                <div class="mt-8 text-gray-500 text-xs md:text-sm">
                    ✓ No credit card required ✓ 30-day money-back guarantee ✓ Enterprise support available
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-16 border-t border-white/10">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand column -->
                <div class="col-span-1">
                    <div class="flex items-center space-x-3 mb-6">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold">CryptUP</span>
                    </div>
                    <p class="text-gray-400 mb-6">
                        The most trusted crypto backup solution, securing digital assets for thousands of users
                        worldwide.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 gradient-text">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#features" class="hover:text-white transition">Features</a></li>
                        <li><a href="#security" class="hover:text-white transition">Security</a></li>
                        <li><a href="#pricing" class="hover:text-white transition">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition">Sign In</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 gradient-text">Resources</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Docs</a></li>
                        <li><a href="#" class="hover:text-white transition">API</a></li>
                        <li><a href="#" class="hover:text-white transition">Support</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 gradient-text">Contact Us</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Email: <a href="mailto:support@cryptup.com"
                                class="hover:text-white transition">support@cryptup.com</a></li>
                        <li>Phone: <span class="hover:text-white transition">+1 (555) 123-4567</span></li>
                        <li>Address: <span class="hover:text-white transition">123 Crypto St, Blockchain City</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 border-t border-white/10 pt-6 text-center text-gray-500 text-sm">
                &copy; 2025 CryptUP. All rights reserved.
            </div>
        </div>
    </footer>
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            if (menu.classList.contains('active')) {
                menu.classList.remove('active');
                document.body.style.overflow = '';
            } else {
                menu.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }
    </script>

</body>

</html>