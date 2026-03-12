<?php
include_once "config/config.php";
include_once "config/functions.php";
if (!isset($_SESSION["cryptup_user"])) {
    echo "<script>location.href = 'login.php'</script>";
}
$coinData = getCoinMarketCapData() ?? [];

$bal = 0;
$getCoins = mysqli_query($conn, "SELECT * FROM `users_coins` WHERE `user_id` = '$user_id'");
if (mysqli_num_rows($getCoins) > 0) {
    $coins = mysqli_fetch_all($getCoins, MYSQLI_ASSOC);
    foreach ($coins as $coin) {

        foreach ($coinData["data"] as $data) {
            if (strtoupper($data['symbol']) === strtoupper($coin["aka"])) {

                $bal += ($data["quote"]["USD"]["price"] * $coin["coin_balance"]);
                break;
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CryptUP || Dashboard</title>
    <link rel="icon" href="data:image/x-icon;base64," type="image/x-icon" />
    <link crossorigin href="https://fonts.gstatic.com/" rel="preconnect" />
    <link as="style" rel="stylesheet" onload="this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css2?display=swap&family=Manrope:wght@400;500;700;800&family=Noto+Sans:wght@400;500;700;900" />
    <!-- <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script> -->
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
    body {
      font-family: 'Manrope', 'Noto Sans', sans-serif;
    }
    .card {
      @apply bg-[var(--surface-color)] rounded-2xl p-4 sm:p-6 shadow-lg;
    }
    .button_primary {
      @apply bg-[var(--primary-color)] text-black rounded-full px-4 py-2 sm:px-6 sm:py-3 font-bold hover:bg-[var(--accent-color)] transition-colors duration-300;
    }
    .button_secondary {
      @apply bg-gray-700 text-[var(--text-primary)] rounded-full px-4 py-2 sm:px-6 sm:py-3 font-bold hover:bg-gray-600 transition-colors duration-300;
    }
    .sidebar-mobile {
      transform: translateX(-100%);
    }
    .sidebar-mobile.open {
      transform: translateX(0);
    }
    @media (min-width: 768px) {
      .sidebar-mobile {
        transform: translateX(0);
      }
    }
  </style>
    <?php include "components/pwa-head.php"; ?>
</head>

<body class="bg-[var(--background-color)] text-[var(--text-primary)] overflow-x-hidden">
    <div class="flex min-h-screen">
        <?php include "components/sidebar.php"; ?>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Mobile Top Bar -->
            <?php include "components/header.php"; ?>

            <!-- Main Dashboard -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">

                <!-- start -->
                <div class="mb-6 sm:mb-8">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2">My Portfolio</h1>
                    <p class="text-[var(--text-secondary)] text-sm sm:text-base">Welcome back to your crypto dashboard
                        <?= $userInfo["name"] ?>.
                    </p>
                </div>

                <!-- Portfolio Cards -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
                    <div class="card lg:col-span-2">
                        <h2 class="text-lg sm:text-xl font-semibold mb-2 text-[var(--text-secondary)]">Total Balance
                        </h2>
                        <p class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-2">
                            $<?= number_format($bal); ?></p>
                        <!-- <p class="text-sm sm:text-base text-green-500 font-medium">+$123.45 (+11.26%) today</p> -->
                    </div>
                    <div class="card">
                        <div class="flex flex-col gap-3 sm:gap-4 h-full justify-center">
                            <button class="button_primary w-full text-sm sm:text-base"
                                onclick="location.href = 'send.php'">Send</button>
                            <button class="button_secondary w-full text-sm sm:text-base"
                                onclick="location.href = 'receive.php'">Receive</button>
                        </div>
                    </div>
                </div>

                <!-- Decentralized Code Card -->
                <div class="card mb-6 sm:mb-8">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-lg sm:text-xl font-semibold mb-1 text-[var(--text-secondary)]">Decentralized
                                Code</h2>
                            <?php if (!empty($userInfo['unique_code'])): ?>
                                <div class="flex items-center gap-3">
                                    <p class="text-xl sm:text-2xl font-bold text-white font-mono tracking-wider"
                                        id="dec-code-display">
                                        <?= htmlspecialchars($userInfo['unique_code']) ?>
                                    </p>
                                    <button type="button" onclick="copyDecCode()" title="Copy code"
                                        class="text-[var(--text-secondary)] hover:text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-xs text-[var(--text-secondary)] mt-1">Use this code to log in with the
                                    decentralized option.</p>
                            <?php else: ?>
                                <p class="text-sm text-[var(--text-secondary)] mb-3">You don't have a decentralized code
                                    yet. Generate one to enable decentralized login.</p>
                                <a href="settings.php#decentralized-code"
                                    class="button_primary inline-block text-sm !px-5 !py-2">Generate Code</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <script>
                    function copyDecCode() {
                        const code = document.getElementById('dec-code-display')?.innerText.trim();
                        if (code) {
                            navigator.clipboard.writeText(code).then(() => {
                                alert('Decentralized code copied to clipboard!');
                            });
                        }
                    }
                </script>

                <!-- Ledger Shop CTA -->
                <div class="card mb-6 sm:mb-8 relative overflow-hidden border border-[var(--border-color)]">
                    <div class="absolute inset-0 pointer-events-none">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-green-500/10 rounded-full blur-3xl"></div>
                        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-cyan-500/10 rounded-full blur-3xl"></div>
                    </div>
                    <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500/20 to-emerald-700/20 border border-green-500/20 flex items-center justify-center text-2xl flex-shrink-0">
                                🔐</div>
                            <div>
                                <h2 class="text-lg font-bold text-white">Hardware Ledger Vault</h2>
                                <p class="text-sm text-[var(--text-secondary)]">Secure your crypto offline with
                                    military-grade hardware wallets. Cold storage, unhackable.</p>
                            </div>
                        </div>
                        <a href="shop.php"
                            class="button_primary text-sm !px-6 !py-2.5 flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                            <span>Shop Ledgers</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Assets Table -->
                <div class="card">
                    <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6">Your Assets</h2>

                    <!-- Mobile Cards View -->
                    <div class="block md:hidden space-y-4">
                        <?php if (isset($coins) && is_array($coins)): ?>
                            <?php foreach ($coins as $coin):
                                $item = [];
                                foreach ($coinData["data"] as $data) {
                                    if (strtoupper($data['symbol']) === strtoupper($coin["aka"])) {
                                        $item = $data;
                                        break;
                                    }
                                }
                                ?>
                                <div class="bg-black/20 rounded-lg p-4 hover:bg-black/30 transition-colors cursor-pointer">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <!-- <div
                                        class="w-10 h-10 rounded-full bg-gradient-to-r from-orange-400 to-yellow-500 flex items-center justify-center">
                                        <span class="text-white font-bold">₿</span>
                                    </div> -->
                                            <div>
                                                <p class="font-semibold text-white"><?= strtoupper($coin["coin"]) ?></p>
                                                <p class="text-sm text-[var(--text-secondary)]"><?= strtoupper($coin["aka"]) ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-white">
                                                $<?= number_format($item["quote"]["USD"]["price"] * $coin["coin_balance"]) ?? 0 ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-[var(--text-secondary)]">Balance:
                                            <?= number_format($coin["coin_balance"], 6) ?>
                                            <?= strtoupper($coin["aka"]) ?></span>
                                        <span
                                            class="text-[var(--text-secondary)]">$<?= number_format($item["quote"]["USD"]["price"]) ?? 0 ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="bg-black/20 rounded-lg p-4 hover:bg-black/30 transition-colors cursor-pointer">
                                <h4 class="text-xl font-semibold text-center">Coins Not Synced yet</h4>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Desktop Table View -->
                    <div class="hidden md:block overflow-x-auto">
                        <?php if (isset($coins) && is_array($coins)): ?>
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="border-b border-[var(--border-color)]">
                                        <th class="p-3 text-[var(--text-secondary)] font-semibold">Asset</th>
                                        <th class="p-3 text-[var(--text-secondary)] font-semibold">Balance</th>
                                        <th class="p-3 text-[var(--text-secondary)] font-semibold">Price</th>
                                        <th class="p-3 text-right text-[var(--text-secondary)] font-semibold">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($coins as $coin):
                                        $item = [];
                                        foreach ($coinData["data"] as $data) {
                                            if (strtoupper($data['symbol']) === strtoupper($coin["aka"])) {
                                                $item = $data;
                                                break;
                                            }
                                        }
                                        ?>
                                        <tr class="border-b border-[var(--border-color)] hover:bg-white/5 transition-colors">
                                            <td class="p-3">
                                                <div class="flex items-center gap-4">
                                                    <div>
                                                        <p class="font-semibold text-white"><?= strtoupper($coin["coin"]) ?></p>
                                                        <p class="text-sm text-[var(--text-secondary)]">
                                                            <?= strtoupper($coin["aka"]) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-3 font-medium text-white">
                                                <?= number_format($coin["coin_balance"], 6) ?>
                                            </td>
                                            <td class="p-3 font-medium text-white">
                                                $<?= number_format($item["quote"]["USD"]["price"]) ?? 0 ?></td>
                                            <td class="p-3 text-right font-semibold text-white">
                                                $<?= number_format($item["quote"]["USD"]["price"] * $coin["coin_balance"]) ?? 0 ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="bg-black/20 rounded-lg p-4 hover:bg-black/30 transition-colors cursor-pointer">
                                <h4 class="text-xl font-semibold text-center">Coins Not Synced yet</h4>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- PWA Install Prompt Banner -->
    <div id="pwa-install-banner"
        style="display:none; position:fixed; bottom:0; left:0; right:0; z-index:9999; padding:16px; background:linear-gradient(135deg, #1a202c 0%, #1E1E1E 100%); border-top:2px solid #53d22c; box-shadow:0 -4px 20px rgba(0,0,0,0.5);">
        <div style="max-width:600px; margin:0 auto; display:flex; align-items:center; gap:16px;">
            <img src="assets/image/icon-192x192.png" alt="CryptUP"
                style="width:48px; height:48px; border-radius:12px; flex-shrink:0;">
            <div style="flex:1; min-width:0;">
                <p style="margin:0; font-weight:700; font-size:16px; color:#E0E0E0;">Install CryptUP</p>
                <p style="margin:4px 0 0; font-size:13px; color:#A0A0A0;">Add to your home screen for quick access and
                    an app-like experience.</p>
            </div>
            <div style="display:flex; gap:8px; flex-shrink:0;">
                <button id="pwa-install-dismiss"
                    style="padding:8px 16px; border-radius:999px; background:#4a5568; color:#E0E0E0; font-weight:600; font-size:14px; border:none; cursor:pointer;">
                    Later
                </button>
                <button id="pwa-install-btn"
                    style="padding:8px 20px; border-radius:999px; background:#53d22c; color:#000; font-weight:700; font-size:14px; border:none; cursor:pointer;">
                    Install
                </button>
            </div>
        </div>
    </div>

    <script>
        let deferredPrompt;
        const installBanner = document.getElementById('pwa-install-banner');
        const installBtn = document.getElementById('pwa-install-btn');
        const dismissBtn = document.getElementById('pwa-install-dismiss');

        // Check if user previously dismissed
        const dismissed = localStorage.getItem('pwa-install-dismissed');
        const dismissedAt = dismissed ? parseInt(dismissed) : 0;
        const daysSinceDismissed = (Date.now() - dismissedAt) / (1000 * 60 * 60 * 24);

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;

            // Show banner if not dismissed recently (re-show after 3 days)
            if (!dismissed || daysSinceDismissed > 3) {
                setTimeout(() => {
                    installBanner.style.display = 'block';
                    installBanner.style.animation = 'slideUp 0.4s ease-out';
                }, 2000);
            }
        });

        installBtn.addEventListener('click', async () => {
            if (!deferredPrompt) return;
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            deferredPrompt = null;
            installBanner.style.display = 'none';
            if (outcome === 'accepted') {
                localStorage.removeItem('pwa-install-dismissed');
            }
        });

        dismissBtn.addEventListener('click', () => {
            installBanner.style.display = 'none';
            localStorage.setItem('pwa-install-dismissed', Date.now().toString());
        });

        // Hide banner if app is already installed
        window.addEventListener('appinstalled', () => {
            installBanner.style.display = 'none';
            deferredPrompt = null;
        });
    </script>

    <style>
        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>

</body>

</html>