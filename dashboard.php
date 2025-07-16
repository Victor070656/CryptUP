<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CryptoWallet</title>
    <link rel="icon" href="data:image/x-icon;base64," type="image/x-icon" />
    <link crossorigin href="https://fonts.gstatic.com/" rel="preconnect" />
    <link as="style" rel="stylesheet" onload="this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css2?display=swap&family=Manrope:wght@400;500;700;800&family=Noto+Sans:wght@400;500;700;900" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
                    <p class="text-[var(--text-secondary)] text-sm sm:text-base">Welcome back to your crypto dashboard.
                    </p>
                </div>

                <!-- Portfolio Cards -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
                    <div class="card lg:col-span-2">
                        <h2 class="text-lg sm:text-xl font-semibold mb-2 text-[var(--text-secondary)]">Total Balance
                        </h2>
                        <p class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-2">$1,234.56</p>
                        <p class="text-sm sm:text-base text-green-500 font-medium">+$123.45 (+11.26%) today</p>
                    </div>
                    <div class="card">
                        <div class="flex flex-col gap-3 sm:gap-4 h-full justify-center">
                            <button class="button_primary w-full text-sm sm:text-base"
                                onclick="handleSend()">Send</button>
                            <button class="button_secondary w-full text-sm sm:text-base"
                                onclick="handleReceive()">Receive</button>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
                    <div class="card text-center">
                        <p class="text-[var(--text-secondary)] text-xs sm:text-sm mb-1">24h Change</p>
                        <p class="text-green-500 font-bold text-sm sm:text-base">+2.5%</p>
                    </div>
                    <div class="card text-center">
                        <p class="text-[var(--text-secondary)] text-xs sm:text-sm mb-1">Assets</p>
                        <p class="text-white font-bold text-sm sm:text-base">5</p>
                    </div>
                    <div class="card text-center">
                        <p class="text-[var(--text-secondary)] text-xs sm:text-sm mb-1">Profit/Loss</p>
                        <p class="text-green-500 font-bold text-sm sm:text-base">+$456.78</p>
                    </div>
                    <div class="card text-center">
                        <p class="text-[var(--text-secondary)] text-xs sm:text-sm mb-1">Rank</p>
                        <p class="text-white font-bold text-sm sm:text-base">#1,234</p>
                    </div>
                </div>

                <!-- Assets Table -->
                <div class="card">
                    <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6">Your Assets</h2>

                    <!-- Mobile Cards View -->
                    <div class="block md:hidden space-y-4">
                        <div class="bg-black/20 rounded-lg p-4 hover:bg-black/30 transition-colors cursor-pointer"
                            onclick="viewAssetDetails('BTC')">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gradient-to-r from-orange-400 to-yellow-500 flex items-center justify-center">
                                        <span class="text-white font-bold">₿</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-white">Bitcoin</p>
                                        <p class="text-sm text-[var(--text-secondary)]">BTC</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-white">$3,086.25</p>
                                    <p class="text-sm text-green-500">+2.5%</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-[var(--text-secondary)]">Balance: 0.12345 BTC</span>
                                <span class="text-[var(--text-secondary)]">$25,000.00</span>
                            </div>
                        </div>

                        <div class="bg-black/20 rounded-lg p-4 hover:bg-black/30 transition-colors cursor-pointer"
                            onclick="viewAssetDetails('ETH')">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                        <span class="text-white font-bold">E</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-white">Ethereum</p>
                                        <p class="text-sm text-[var(--text-secondary)]">ETH</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-white">$987.65</p>
                                    <p class="text-sm text-red-500">-1.2%</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-[var(--text-secondary)]">Balance: 0.54321 ETH</span>
                                <span class="text-[var(--text-secondary)]">$1,800.00</span>
                            </div>
                        </div>

                        <div class="bg-black/20 rounded-lg p-4 hover:bg-black/30 transition-colors cursor-pointer"
                            onclick="viewAssetDetails('ADA')">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center">
                                        <span class="text-white font-bold">A</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-white">Cardano</p>
                                        <p class="text-sm text-[var(--text-secondary)]">ADA</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-white">$123.45</p>
                                    <p class="text-sm text-green-500">+5.7%</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-[var(--text-secondary)]">Balance: 250.00 ADA</span>
                                <span class="text-[var(--text-secondary)]">$0.49</span>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop Table View -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="border-b border-[var(--border-color)]">
                                    <th class="p-3 text-[var(--text-secondary)] font-semibold">Asset</th>
                                    <th class="p-3 text-[var(--text-secondary)] font-semibold">Balance</th>
                                    <th class="p-3 text-[var(--text-secondary)] font-semibold">Price</th>
                                    <th class="p-3 text-[var(--text-secondary)] font-semibold">24h Change</th>
                                    <th class="p-3 text-right text-[var(--text-secondary)] font-semibold">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-[var(--border-color)] hover:bg-white/5 transition-colors cursor-pointer"
                                    onclick="viewAssetDetails('BTC')">
                                    <td class="p-3">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-10 h-10 rounded-full bg-gradient-to-r from-orange-400 to-yellow-500 flex items-center justify-center">
                                                <span class="text-white font-bold">₿</span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-white">Bitcoin</p>
                                                <p class="text-sm text-[var(--text-secondary)]">BTC</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3 font-medium text-white">0.12345</td>
                                    <td class="p-3 font-medium text-white">$25,000.00</td>
                                    <td class="p-3 text-green-500 font-medium">+2.5%</td>
                                    <td class="p-3 text-right font-semibold text-white">$3,086.25</td>
                                </tr>
                                <tr class="border-b border-[var(--border-color)] hover:bg-white/5 transition-colors cursor-pointer"
                                    onclick="viewAssetDetails('ETH')">
                                    <td class="p-3">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                                <span class="text-white font-bold">E</span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-white">Ethereum</p>
                                                <p class="text-sm text-[var(--text-secondary)]">ETH</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3 font-medium text-white">0.54321</td>
                                    <td class="p-3 font-medium text-white">$1,800.00</td>
                                    <td class="p-3 text-red-500 font-medium">-1.2%</td>
                                    <td class="p-3 text-right font-semibold text-white">$987.65</td>
                                </tr>
                                <tr class="border-b border-[var(--border-color)] hover:bg-white/5 transition-colors cursor-pointer"
                                    onclick="viewAssetDetails('ADA')">
                                    <td class="p-3">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-10 h-10 rounded-full bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center">
                                                <span class="text-white font-bold">A</span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-white">Cardano</p>
                                                <p class="text-sm text-[var(--text-secondary)]">ADA</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3 font-medium text-white">250.00</td>
                                    <td class="p-3 font-medium text-white">$0.49</td>
                                    <td class="p-3 text-green-500 font-medium">+5.7%</td>
                                    <td class="p-3 text-right font-semibold text-white">$123.45</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>


</body>

</html>