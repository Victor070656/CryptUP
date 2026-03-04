<!-- PWA -->
<link rel="manifest"
    href="<?= (strpos($_SERVER['REQUEST_URI'], '/manager/') !== false) ? '../manifest.json' : 'manifest.json' ?>">
<meta name="theme-color" content="#121212">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="CryptUP">
<link rel="apple-touch-icon"
    href="<?= (strpos($_SERVER['REQUEST_URI'], '/manager/') !== false) ? '../assets/image/icon-192x192.png' : 'assets/image/icon-192x192.png' ?>">
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            const swPath = <?= (strpos($_SERVER['REQUEST_URI'], '/manager/') !== false) ? "'../sw.js'" : "'sw.js'" ?>;
            navigator.serviceWorker.register(swPath, { scope: '/CryptUP/' });
        });
    }
</script>