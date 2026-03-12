<?php
include_once "config/config.php";
include_once "config/functions.php";
if (!isset($_SESSION["cryptup_user"])) {
    echo "<script>location.href = 'login.php'</script>";
    exit;
}

$products = mysqli_query($conn, "SELECT * FROM `ledger_products` WHERE `in_stock` = 1 ORDER BY `id` DESC");
$wallets = mysqli_query($conn, "SELECT * FROM `payment_wallets` ORDER BY `id` ASC");
$walletList = [];
while ($w = mysqli_fetch_assoc($wallets)) {
    $walletList[] = $w;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CryptUP || Hardware Ledger Shop</title>
    <link rel="icon" href="data:image/x-icon;base64," type="image/x-icon" />
    <link crossorigin href="https://fonts.gstatic.com/" rel="preconnect" />
    <link as="style" rel="stylesheet" onload="this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css2?display=swap&family=Manrope:wght@400;500;700;800&family=Noto+Sans:wght@400;500;700;900" />
    <script src="assets/js/tailwindcss.js"></script>
    <style type="text/tailwindcss">
        :root {
      --primary-color: #53d22c;
      --background-color: #121212;
      --text-primary: #E0E0E0;
      --text-secondary: #A0A0A0;
      --accent-color: #66bb6a;
      --surface-color: #1E1E1E;
      --border-color: #333333;
    }
    body { font-family: 'Manrope', 'Noto Sans', sans-serif; }
    .card { @apply bg-[var(--surface-color)] rounded-2xl p-4 sm:p-6 shadow-lg; }
    .input { @apply w-full bg-[#2a2a2a] text-[var(--text-primary)] border border-[var(--border-color)] rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] transition-shadow; }
    .button_primary { @apply bg-[var(--primary-color)] text-black rounded-full px-4 py-2 sm:px-6 sm:py-3 font-bold hover:bg-[var(--accent-color)] transition-colors duration-300; }
    .button_secondary { @apply bg-gray-700 text-[var(--text-primary)] rounded-full px-4 py-2 sm:px-6 sm:py-3 font-bold hover:bg-gray-600 transition-colors duration-300; }
    .sidebar-mobile { transform: translateX(-100%); }
    .sidebar-mobile.open { transform: translateX(0); }
    @media (min-width: 768px) { .sidebar-mobile { transform: translateX(0); } }
  </style>
    <style>
        .ledger-card {
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .ledger-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(83, 210, 44, 0.1), transparent, rgba(6, 182, 212, 0.1), transparent);
            animation: rotate 6s linear infinite;
            opacity: 0;
            transition: opacity 0.4s;
        }

        .ledger-card:hover::before {
            opacity: 1;
        }

        .ledger-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 48px -12px rgba(83, 210, 44, 0.15), 0 0 0 1px rgba(83, 210, 44, 0.2);
        }

        @keyframes rotate {
            100% {
                transform: rotate(360deg);
            }
        }

        .glow-line {
            height: 2px;
            background: linear-gradient(90deg, transparent, #53d22c, #06b6d4, transparent);
            animation: glowPulse 3s ease-in-out infinite;
        }

        @keyframes glowPulse {

            0%,
            100% {
                opacity: 0.4;
            }

            50% {
                opacity: 1;
            }
        }

        .cyber-grid {
            background-image:
                linear-gradient(rgba(83, 210, 44, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(83, 210, 44, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .float-anim {
            animation: floatY 4s ease-in-out infinite;
        }

        @keyframes floatY {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .pulse-ring {
            animation: pulseRing 2s ease-out infinite;
        }

        @keyframes pulseRing {
            0% {
                box-shadow: 0 0 0 0 rgba(83, 210, 44, 0.3);
            }

            100% {
                box-shadow: 0 0 0 20px rgba(83, 210, 44, 0);
            }
        }
    </style>
    <?php include "components/pwa-head.php"; ?>
</head>

<body class="bg-[var(--background-color)] text-[var(--text-primary)] overflow-x-hidden">
    <div class="flex min-h-screen">
        <?php include "components/sidebar.php"; ?>

        <div class="flex-1 flex flex-col min-w-0">
            <?php include "components/header.php"; ?>

            <main class="flex-1 p-4 sm:p-6 lg:p-8 cyber-grid">
                <!-- Hero Banner -->
                <div
                    class="relative rounded-3xl overflow-hidden mb-8 p-8 sm:p-12 bg-gradient-to-br from-[#0a1a0a] via-[#1a2e1a] to-[#0a1a2a] border border-[var(--border-color)]/50">
                    <div class="absolute inset-0 opacity-20">
                        <div class="absolute top-4 right-8 w-64 h-64 bg-green-500/10 rounded-full blur-3xl"></div>
                        <div class="absolute bottom-4 left-8 w-48 h-48 bg-cyan-500/10 rounded-full blur-3xl"></div>
                    </div>
                    <div class="relative z-10">
                        <div
                            class="inline-block px-4 py-1.5 rounded-full bg-green-500/10 border border-green-500/20 text-green-400 text-xs font-bold tracking-wider uppercase mb-4">
                            Hardware Security
                        </div>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black mb-3 leading-tight">
                            <span
                                class="bg-gradient-to-r from-white via-gray-200 to-gray-400 bg-clip-text text-transparent">Crypto
                                Ledger</span>
                            <br>
                            <span
                                class="bg-gradient-to-r from-green-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">Hardware
                                Vault</span>
                        </h1>
                        <p class="text-[var(--text-secondary)] max-w-lg text-sm sm:text-base">
                            Secure your digital assets with military-grade hardware wallets. Cold storage. Unhackable.
                            Your keys, your crypto.
                        </p>
                        <div class="glow-line mt-6 w-32 rounded-full"></div>
                    </div>
                </div>

                <!-- Products Grid -->
                <?php if (mysqli_num_rows($products) > 0): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                        <?php while ($p = mysqli_fetch_assoc($products)): ?>
                            <div class="ledger-card card relative border border-[var(--border-color)]/50 flex flex-col">
                                <div class="relative z-10 flex flex-col h-full">
                                    <!-- Product Image -->
                                    <div
                                        class="relative rounded-xl overflow-hidden mb-4 bg-gradient-to-br from-[#1a2a1a] to-[#0a150a] aspect-[4/3] flex items-center justify-center">
                                        <?php if ($p['image_url']): ?>
                                            <img src="<?= htmlspecialchars($p['image_url']) ?>"
                                                class="w-full h-full object-contain p-4 float-anim"
                                                alt="<?= htmlspecialchars($p['name']) ?>">
                                        <?php else: ?>
                                            <div class="text-center float-anim">
                                                <div class="text-6xl mb-2">🔐</div>
                                                <div class="text-xs text-[var(--text-secondary)] font-mono tracking-widest">HARDWARE
                                                    VAULT</div>
                                            </div>
                                        <?php endif; ?>
                                        <!-- Scan lines effect -->
                                        <div class="absolute inset-0 pointer-events-none"
                                            style="background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0,0,0,0.03) 2px, rgba(0,0,0,0.03) 4px);">
                                        </div>
                                    </div>

                                    <!-- Info -->
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold mb-1"><?= htmlspecialchars($p['name']) ?></h3>
                                        <div class="flex items-center gap-2 mb-3">
                                            <span
                                                class="bg-cyan-500/10 text-cyan-400 px-3 py-0.5 rounded-full text-xs font-bold border border-cyan-500/20">
                                                <?= htmlspecialchars($p['capacity']) ?>
                                            </span>
                                            <span
                                                class="bg-green-500/10 text-green-400 px-2 py-0.5 rounded-full text-xs font-bold flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full pulse-ring"></span> In Stock
                                            </span>
                                        </div>
                                        <?php if ($p['description']): ?>
                                            <p class="text-sm text-[var(--text-secondary)] mb-4 line-clamp-2">
                                                <?= htmlspecialchars($p['description']) ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Price & Buy -->
                                    <div
                                        class="flex items-center justify-between mt-auto pt-4 border-t border-[var(--border-color)]/30">
                                        <div>
                                            <div class="text-xs text-[var(--text-secondary)] uppercase tracking-wider">Price
                                            </div>
                                            <div class="text-2xl font-black text-green-400">
                                                $<?= number_format($p['price_usd'], 2) ?></div>
                                        </div>
                                        <a href="order.php?product=<?= $p['id'] ?>"
                                            class="button_primary text-sm px-6 py-2.5 flex items-center gap-2 group">
                                            <span>Buy Now</span>
                                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="card text-center py-16">
                        <div class="text-6xl mb-4 float-anim">🔒</div>
                        <h3 class="text-xl font-bold mb-2">No Ledgers Available</h3>
                        <p class="text-[var(--text-secondary)]">New hardware wallets coming soon. Stay tuned!</p>
                    </div>
                <?php endif; ?>

                <!-- Accepted Payment Methods -->
                <?php if (count($walletList) > 0): ?>
                    <div class="card border border-[var(--border-color)]/50">
                        <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 bg-cyan-400 rounded-full"></span>
                            Accepted Payment Methods
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            <?php foreach ($walletList as $w): ?>
                                <div
                                    class="bg-black/30 rounded-xl p-4 border border-[var(--border-color)]/30 hover:border-cyan-500/20 transition-colors">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-cyan-400 font-bold text-sm"><?= htmlspecialchars($w['coin']) ?></span>
                                        <?php if ($w['network']): ?>
                                            <span
                                                class="text-xs text-[var(--text-secondary)]">(<?= htmlspecialchars($w['network']) ?>)</span>
                                        <?php endif; ?>
                                    </div>
                                    <code
                                        class="text-xs text-[var(--text-secondary)] break-all"><?= htmlspecialchars($w['address']) ?></code>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </main>
        </div>
    </div>
</body>

</html>