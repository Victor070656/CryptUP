<?php
include_once "config/config.php";
if (!isset($_SESSION["cryptup_user"])) {
    echo "<script>location.href = 'login.php'</script>";
}

$bal = 0;
$getCoins = mysqli_query($conn, "SELECT * FROM `users_coins` WHERE `user_id` = '$user_id'");
if (mysqli_num_rows($getCoins) > 0) {
    $coins = mysqli_fetch_all($getCoins, MYSQLI_ASSOC);
    foreach ($coins as $coin) {
        $bal += $coin["balance"];
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



                <!-- Assets Table -->
                <div class="card">
                    <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6">Your Assets</h2>

                    <!-- Mobile Cards View -->
                    <div class="block md:hidden space-y-4">
                        <?php if (isset($coins) && is_array($coins)): ?>
                            <div class="bg-black/20 rounded-lg p-4 hover:bg-black/30 transition-colors cursor-pointer"
                                onclick="viewAssetDetails('BTC')">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <!-- <div
                                        class="w-10 h-10 rounded-full bg-gradient-to-r from-orange-400 to-yellow-500 flex items-center justify-center">
                                        <span class="text-white font-bold">₿</span>
                                    </div> -->
                                        <div>
                                            <p class="font-semibold text-white">Bitcoin</p>
                                            <p class="text-sm text-[var(--text-secondary)]">BTC</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-white">$3,086.25</p>
                                    </div>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-[var(--text-secondary)]">Balance: 0.12345 BTC</span>
                                    <span class="text-[var(--text-secondary)]">$25,000.00</span>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="bg-black/20 rounded-lg p-4 hover:bg-black/30 transition-colors cursor-pointer"
                                onclick="viewAssetDetails('BTC')">
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
                                    <?php foreach ($coins as $coin): ?>
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
                                            <td class="p-3 font-medium text-white">$<?= number_format($coin["price"]) ?></td>
                                            <td class="p-3 text-right font-semibold text-white">
                                                $<?= number_format($coin["balance"]) ?></td>
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


</body>

</html>