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
        <a class="flex items-center gap-4 px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-white/10 font-semibold text-sm sm:text-base transition-colors <?= basename($_SERVER['REQUEST_URI']) == 'index.php' || basename($_SERVER['REQUEST_URI']) == 'manager' ? 'bg-[var(--primary-color)] text-white' : 'text-[var(--text-secondary)] hover:text-white'; ?>"
            href="index.php">
            <span class="text-lg">🏠</span>
            Home
        </a>
        <a class="flex items-center gap-4 px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-white/10 text-[var(--text-secondary)] hover:text-white transition-colors text-sm sm:text-base <?= basename($_SERVER['REQUEST_URI']) == 'users.php' ? 'bg-[var(--primary-color)] text-white' : 'text-[var(--text-secondary)] hover:text-white'; ?>"
            href="users.php">
            <span class="text-lg">👤</span>
            Users
        </a>

        <a class="flex items-center gap-4 px-3 sm:px-4 py-2 sm:py-3 rounded-lg hover:bg-white/10 text-[var(--text-secondary)] hover:text-white transition-colors text-sm sm:text-base <?= basename($_SERVER['REQUEST_URI']) == 'settings.php' ? 'bg-[var(--primary-color)] text-white' : 'text-[var(--text-secondary)] hover:text-white'; ?>"
            href="settings.php">
            <span class="text-lg">⚙️</span>
            Settings
        </a>
    </nav>
</aside>

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