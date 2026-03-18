<!-- Sidebar overlay for mobile -->
<div id="sidebarOverlay"
    class="fixed inset-0 bg-black/50 z-30 md:hidden transition-opacity duration-300 opacity-0 pointer-events-none"
    onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside id="sidebar"
    class="fixed z-40 inset-y-0 left-0 w-64 bg-black/30 backdrop-blur-sm border-r border-[var(--border-color)] p-4 sm:p-6 transition-transform duration-300 ease-in-out sidebar-mobile md:relative md:translate-x-0">
    <div class="flex items-center gap-3 mb-8 md:mb-10">
        <div
            class="bg-gradient-to-r from-[var(--primary-color)] to-[var(--accent-color)] rounded-full w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center">
            <svg class="h-8 w-8 text-primary-color" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M24 4C25.7818 14.2173 33.7827 22.2182 44 24C33.7827 25.7818 25.7818 33.7827 24 44C22.2182 33.7827 14.2173 25.7818 4 24C14.2173 22.2182 22.2182 14.2173 24 4Z"
                    fill="currentColor"></path>
            </svg>
        </div>
        <h1 class="text-white text-base sm:text-lg font-black">CryptUP</h1>
    </div>
    <nav class="flex flex-col gap-2 flex-1">
        <a class="flex items-center gap-4 px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-white/10 font-semibold text-sm sm:text-base transition-colors <?= basename($_SERVER['REQUEST_URI']) == 'dashboard.php' ? 'bg-[var(--primary-color)] text-white' : 'text-[var(--text-secondary)] hover:text-white'; ?>"
            href="dashboard.php">
            <span class="text-lg">🏠</span>
            Home
        </a>
        <a class="flex items-center gap-4 px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-white/10 text-[var(--text-secondary)] hover:text-white transition-colors text-sm sm:text-base <?= basename($_SERVER['REQUEST_URI']) == 'transactions.php' ? 'bg-[var(--primary-color)] text-white' : 'text-[var(--text-secondary)] hover:text-white'; ?>"
            href="transactions.php">
            <span class="text-lg">📊</span>
            Transactions
        </a>
        <a class="flex items-center gap-4 px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-white/10 text-[var(--text-secondary)] hover:text-white transition-colors text-sm sm:text-base <?= basename($_SERVER['REQUEST_URI']) == 'send.php' ? 'bg-[var(--primary-color)] text-white' : 'text-[var(--text-secondary)] hover:text-white'; ?>"
            href="send.php">
            <span class="text-lg">💰</span>
            Send
        </a>
        <a class="flex items-center gap-4 px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-white/10 text-[var(--text-secondary)] hover:text-white transition-colors text-sm sm:text-base <?= basename($_SERVER['REQUEST_URI']) == 'receive.php' ? 'bg-[var(--primary-color)] text-white' : 'text-[var(--text-secondary)] hover:text-white'; ?>"
            href="receive.php">
            <span class="text-lg">🔄</span>
            Receive
        </a>
        <a class="flex items-center gap-4 px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-white/10 text-[var(--text-secondary)] hover:text-white transition-colors text-sm sm:text-base <?= basename($_SERVER['REQUEST_URI']) == 'shop.php' ? 'bg-[var(--primary-color)] text-white' : 'text-[var(--text-secondary)] hover:text-white'; ?>"
            href="shop.php">
            <span class="text-lg">🔐</span>
            Ledger Shop
        </a>
        <a class="flex items-center gap-4 px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-white/10 text-[var(--text-secondary)] hover:text-white transition-colors text-sm sm:text-base <?= in_array(basename($_SERVER['REQUEST_URI']), ['my-orders.php', 'order.php']) ? 'bg-[var(--primary-color)] text-white' : 'text-[var(--text-secondary)] hover:text-white'; ?>"
            href="my-orders.php">
            <span class="text-lg">📦</span>
            My Orders
        </a>

        <a class="flex items-center gap-4 px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-white/10 text-[var(--text-secondary)] hover:text-white transition-colors text-sm sm:text-base <?= basename($_SERVER['REQUEST_URI']) == 'settings.php' ? 'bg-[var(--primary-color)] text-white' : 'text-[var(--text-secondary)] hover:text-white'; ?>"
            href="settings.php">
            <span class="text-lg">⚙️</span>
            Settings
        </a>
        <a class="flex items-center gap-4 px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-white/10 text-[var(--text-secondary)] hover:text-white transition-colors text-sm sm:text-base <?= basename($_SERVER['REQUEST_URI']) == 'logout.php' ? 'bg-[var(--primary-color)] text-white' : 'text-[var(--text-secondary)] hover:text-white'; ?>"
            href="logout.php">
            <span class="text-lg">🚫</span>
            Logout
        </a>
    </nav>
</aside>

<div class="fixed bottom-6 right-6 z-[99999]">
    <a href="https://cryptup-live-support.onrender.com/" target="_blank" rel="noopener noreferrer">
        <svg class="w-16 h-16" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M114.8 561.9l-0.8 92.6 151.1-92.6h291.3c39.4 0 71.3-32.6 71.3-72.9V206c0-40.3-31.9-72.9-71.3-72.9H114.8c-39.4 0-71.3 32.6-71.3 72.9v283c0 40.3 31.9 72.9 71.3 72.9z"
                fill="#9ED5E4" />
            <path
                d="M114 669.1c-2.5 0-4.9-0.6-7.1-1.9-4.6-2.6-7.4-7.5-7.4-12.7l0.7-79.3C59.8 568.1 29 532.2 29 489V206c0-48.2 38.5-87.4 85.8-87.4h441.5c47.3 0 85.8 39.2 85.8 87.4v283c0 48.2-38.5 87.4-85.8 87.4H269.2l-147.6 90.5c-2.4 1.4-5 2.2-7.6 2.2z m0.8-521.5C83.5 147.6 58 173.8 58 206v283c0 32.2 25.5 58.4 56.9 58.4 3.9 0 7.6 1.5 10.3 4.3 2.7 2.7 4.2 6.5 4.2 10.3l-0.6 66.5 128.8-79c2.3-1.4 4.9-2.1 7.6-2.1h291.3c31.4 0 56.9-26.2 56.9-58.4V206c0-32.2-25.5-58.4-56.9-58.4H114.8z"
                fill="#154B8B" />
            <path
                d="M890.1 773.1l1.1 117.4-195.6-117.4H318.4c-51 0-92.4-41.4-92.4-92.4V322.1c0-51 41.4-92.4 92.4-92.4h571.7c51 0 92.4 41.4 92.4 92.4v358.7c0 50.9-41.3 92.3-92.4 92.3z"
                fill="#FAFCFC" />
            <path
                d="M891.2 905c-2.6 0-5.2-0.7-7.5-2.1L691.6 787.6H318.4c-58.9 0-106.9-47.9-106.9-106.9V322.1c0-58.9 47.9-106.9 106.9-106.9h571.7c58.9 0 106.9 47.9 106.9 106.9v358.7c0 54-40.2 98.7-92.2 105.9l1 103.8c0 5.2-2.7 10.1-7.3 12.7-2.3 1.1-4.8 1.8-7.3 1.8zM318.4 244.2c-42.9 0-77.9 34.9-77.9 77.9v358.7c0 42.9 34.9 77.9 77.9 77.9h377.2c2.6 0 5.2 0.7 7.5 2.1l173.5 104.1-0.8-91.5c0-3.9 1.5-7.6 4.2-10.3 2.7-2.7 6.4-4.3 10.3-4.3 42.9 0 77.9-34.9 77.9-77.9V322.1c0-42.9-34.9-77.9-77.9-77.9H318.4z"
                fill="#154B8B" />
            <path d="M376 499.8a47.3 44.8 0 1 0 94.6 0 47.3 44.8 0 1 0-94.6 0Z" fill="#144884" />
            <path d="M557 499.8a47.3 44.8 0 1 0 94.6 0 47.3 44.8 0 1 0-94.6 0Z" fill="#144884" />
            <path d="M737.9 499.8a47.3 44.8 0 1 0 94.6 0 47.3 44.8 0 1 0-94.6 0Z" fill="#144884" />
        </svg>
    </a>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const hamburger = document.getElementById('hamburger');

        sidebar.classList.toggle('open');

        if (sidebar.classList.contains('open')) {
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100');
            hamburger.textContent = '×';
        } else {
            overlay.classList.add('opacity-0', 'pointer-events-none');
            overlay.classList.remove('opacity-100');
            hamburger.textContent = '☰';
        }
    }

    // function setActiveNav(element) {
    //     // Remove active class from all nav items
    //     const navItems = document.querySelectorAll('nav a');
    //     navItems.forEach(item => {
    //         item.classList.remove('bg-[var(--primary-color)]', 'text-black');
    //         item.classList.add('text-[var(--text-secondary)]', 'hover:text-white');
    //     });

    //     // Add active class to clicked item
    //     element.classList.add('bg-[var(--primary-color)]', 'text-black');
    //     element.classList.remove('text-[var(--text-secondary)]', 'hover:text-white');

    //     // Close sidebar on mobile after navigation
    //     if (window.innerWidth < 768) {
    //         toggleSidebar();
    //     }
    // }

    function handleSend() {
        alert('Send functionality would be implemented here');
    }

    function handleReceive() {
        alert('Receive functionality would be implemented here');
    }

    function viewAssetDetails(asset) {
        alert(`View ${asset} details functionality would be implemented here`);
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function (event) {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleButton = event.target.closest('[onclick*="toggleSidebar"]');

        if (!sidebar.contains(event.target) && !toggleButton && window.innerWidth < 768) {
            sidebar.classList.remove('open');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            overlay.classList.remove('opacity-100');
            document.getElementById('hamburger').textContent = '☰';
        }
    });

    // Handle window resize
    window.addEventListener('resize', function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const hamburger = document.getElementById('hamburger');

        if (window.innerWidth >= 768) {
            sidebar.classList.remove('open');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            overlay.classList.remove('opacity-100');
            hamburger.textContent = '☰';
        }
    });

    // Prevent default link behavior for navigation
    // document.addEventListener('DOMContentLoaded', function () {
    //     const navLinks = document.querySelectorAll('nav a, div a');
    //     navLinks.forEach(link => {
    //         link.addEventListener('click', function (e) {
    //             e.preventDefault();
    //         });
    //     });
    // });
</script>