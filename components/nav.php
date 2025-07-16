<div class="">
    <style>
        .btn-secondary {
            background: rgba(255, 255, 255, 0.08);
            color: var(--text-primary);
            font-weight: 600;
            padding: 16px 32px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-2px);
            border-color: rgba(99, 102, 241, 0.3);
        }
    </style>
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 backdrop-blur-md border-b border-white/10 py-2">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 cursor-pointer" onclick="location.href='./'">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-green-700 to-green-500 rounded-xl flex items-center justify-center">
                        <svg class="h-8 w-8 text-primary-color" fill="none" viewBox="0 0 48 48"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M24 4C25.7818 14.2173 33.7827 22.2182 44 24C33.7827 25.7818 25.7818 33.7827 24 44C22.2182 33.7827 14.2173 25.7818 4 24C14.2173 22.2182 22.2182 14.2173 24 4Z"
                                fill="currentColor"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-black">CryptUP</span>
                </div>

                <div class="nav-links hidden md:flex items-center space-x-8">


                    <button class="btn-secondary text-sm px-6 py-2" onclick="location.href='login.php'">Sign In</button>
                </div>

                <div class="hamburger md:hidden" onclick="toggleMobileMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu px-6" id="mobileMenu">
        <div class="flex items-center space-x-3">
            <div
                class="w-10 h-10 bg-gradient-to-br from-green-700 to-green-500 rounded-xl flex items-center justify-center">
                <svg class="h-8 w-8 text-primary-color" fill="none" viewBox="0 0 48 48"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M24 4C25.7818 14.2173 33.7827 22.2182 44 24C33.7827 25.7818 25.7818 33.7827 24 44C22.2182 33.7827 14.2173 25.7818 4 24C14.2173 22.2182 22.2182 14.2173 24 4Z"
                        fill="currentColor"></path>
                </svg>
            </div>
            <span class="text-2xl font-black">CryptUP</span>
        </div>
        <button class="btn-secondary text-lg px-8 py-3" onclick="toggleMobileMenu()">Sign In</button>
    </div>
</div>