<?php
include_once "config/config.php";
if (!isset($_SESSION["cryptup_user"])) {
    echo "<script>location.href = 'login.php'</script>";
}

$getCoins = mysqli_query($conn, "SELECT * FROM `users_coins` WHERE `user_id` = '$user_id'");
if (mysqli_num_rows($getCoins) > 0) {
    $coins = mysqli_fetch_all($getCoins, MYSQLI_ASSOC);
} else {
    echo "<script>location.href = 'dashboard.php'; alert('Coins not yet synced')</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CryptUP || Receive Crypto</title>
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
            font-family: 'Manrope', sans-serif;
            background-color: var(--background-color);
            color: var(--text-primary);
        }
        .main_container {
            @apply container mx-auto px-4 py-8;
        }
        .card {
            @apply bg-[var(--surface-color)] rounded-xl p-6 shadow-lg;
        }
        .button_primary {
            @apply bg-[var(--primary-color)] text-black rounded-full px-4 py-2 font-bold hover:bg-[var(--accent-color)] transition-colors;
        }
        .button_secondary {
            @apply bg-gray-700 text-[var(--text-primary)] rounded-full px-4 py-2 hover:bg-gray-600 transition-colors;
        }
        .input {
            @apply bg-gray-800 text-[var(--text-primary)] border border-[var(--border-color)] rounded-lg px-4 py-2 focus:outline-none focus:border-[var(--primary-color)];
        }
        .typography_h1 {
            @apply text-3xl font-bold text-[var(--text-primary)];
        }
        .typography_h2 {
            @apply text-2xl font-semibold text-[var(--text-primary)];
        }
        .typography_body {
            @apply text-base text-[var(--text-secondary)];
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

                <div class="w-full max-w-lg mx-auto">
                    <div class="text-center mb-8">
                        <h1 class="typography_h1 mb-2">Receive Crypto</h1>
                        <p class="typography_body">Select an asset to generate a deposit address.</p>
                    </div>
                    <div class="mb-8">
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[var(--text-secondary)]">
                                <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z">
                                    </path>
                                </svg>
                            </div>
                            <input class="input w-full ps-14" placeholder="Search for an asset" type="text" />
                        </div>
                    </div>
                    <div class="card space-y-2">
                        <div class="max-h-[60vh] overflow-y-auto pr-2" id="coin-list">
                            <a class="flex items-center gap-4 p-3 rounded-lg hover:bg-white/5 transition-colors"
                                href="#">
                                <div
                                    class="shrink-0 size-10 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold text-xl">
                                    B</div>
                                <div class="flex-1">
                                    <p class="font-semibold text-[var(--text-primary)]">Bitcoin</p>
                                    <p class="text-sm text-[var(--text-secondary)]">BTC</p>
                                </div>
                                <svg class="text-[var(--text-secondary)]" fill="currentColor" height="20"
                                    viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M181.66,133.66l-48,48a8,8,0,0,1-11.32-11.32L212.69,80H160a8,8,0,0,1,0-16h64a8,8,0,0,1,8,8v64a8,8,0,0,1-16,0V83.31L134.34,168a8,8,0,0,1-11.32-11.32l48-48A8,8,0,0,1,181.66,133.66Z">
                                    </path>
                                </svg>
                            </a>
                            <a class="flex items-center gap-4 p-3 rounded-lg hover:bg-white/5 transition-colors"
                                href="#">
                                <div
                                    class="shrink-0 size-10 rounded-full bg-gray-400 flex items-center justify-center text-white font-bold text-xl">
                                    E</div>
                                <div class="flex-1">
                                    <p class="font-semibold text-[var(--text-primary)]">Ethereum</p>
                                    <p class="text-sm text-[var(--text-secondary)]">ETH</p>
                                </div>
                                <svg class="text-[var(--text-secondary)]" fill="currentColor" height="20"
                                    viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M181.66,133.66l-48,48a8,8,0,0,1-11.32-11.32L212.69,80H160a8,8,0,0,1,0-16h64a8,8,0,0,1,8,8v64a8,8,0,0,1-16,0V83.31L134.34,168a8,8,0,0,1-11.32-11.32l48-48A8,8,0,0,1,181.66,133.66Z">
                                    </path>
                                </svg>
                            </a>
                            <a class="flex items-center gap-4 p-3 rounded-lg hover:bg-white/5 transition-colors"
                                href="#">
                                <div
                                    class="shrink-0 size-10 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold text-xl">
                                    T</div>
                                <div class="flex-1">
                                    <p class="font-semibold text-[var(--text-primary)]">Tether</p>
                                    <p class="text-sm text-[var(--text-secondary)]">USDT</p>
                                </div>
                                <svg class="text-[var(--text-secondary)]" fill="currentColor" height="20"
                                    viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M181.66,133.66l-48,48a8,8,0,0,1-11.32-11.32L212.69,80H160a8,8,0,0,1,0-16h64a8,8,0,0,1,8,8v64a8,8,0,0,1-16,0V83.31L134.34,168a8,8,0,0,1-11.32-11.32l48-48A8,8,0,0,1,181.66,133.66Z">
                                    </path>
                                </svg>
                            </a>
                            <a class="flex items-center gap-4 p-3 rounded-lg hover:bg-white/5 transition-colors"
                                href="#">
                                <div
                                    class="shrink-0 size-10 rounded-full bg-yellow-400 flex items-center justify-center text-black font-bold text-xl">
                                    B</div>
                                <div class="flex-1">
                                    <p class="font-semibold text-[var(--text-primary)]">BNB</p>
                                    <p class="text-sm text-[var(--text-secondary)]">BNB</p>
                                </div>
                                <svg class="text-[var(--text-secondary)]" fill="currentColor" height="20"
                                    viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M181.66,133.66l-48,48a8,8,0,0,1-11.32-11.32L212.69,80H160a8,8,0,0,1,0-16h64a8,8,0,0,1,8,8v64a8,8,0,0,1-16,0V83.31L134.34,168a8,8,0,0,1-11.32-11.32l48-48A8,8,0,0,1,181.66,133.66Z">
                                    </path>
                                </svg>
                            </a>
                            <a class="flex items-center gap-4 p-3 rounded-lg hover:bg-white/5 transition-colors"
                                href="#">
                                <div
                                    class="shrink-0 size-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-xl">
                                    U</div>
                                <div class="flex-1">
                                    <p class="font-semibold text-[var(--text-primary)]">USD Coin</p>
                                    <p class="text-sm text-[var(--text-secondary)]">USDC</p>
                                </div>
                                <svg class="text-[var(--text-secondary)]" fill="currentColor" height="20"
                                    viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M181.66,133.66l-48,48a8,8,0,0,1-11.32-11.32L212.69,80H160a8,8,0,0,1,0-16h64a8,8,0,0,1,8,8v64a8,8,0,0,1-16,0V83.31L134.34,168a8,8,0,0,1-11.32-11.32l48-48A8,8,0,0,1,181.66,133.66Z">
                                    </path>
                                </svg>
                            </a>
                            <a class="flex items-center gap-4 p-3 rounded-lg hover:bg-white/5 transition-colors"
                                href="#">
                                <div
                                    class="shrink-0 size-10 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold text-xl">
                                    S</div>
                                <div class="flex-1">
                                    <p class="font-semibold text-[var(--text-primary)]">Solana</p>
                                    <p class="text-sm text-[var(--text-secondary)]">SOL</p>
                                </div>
                                <svg class="text-[var(--text-secondary)]" fill="currentColor" height="20"
                                    viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M181.66,133.66l-48,48a8,8,0,0,1-11.32-11.32L212.69,80H160a8,8,0,0,1,0-16h64a8,8,0,0,1,8,8v64a8,8,0,0,1-16,0V83.31L134.34,168a8,8,0,0,1-11.32-11.32l48-48A8,8,0,0,1,181.66,133.66Z">
                                    </path>
                                </svg>
                            </a>
                            <a class="flex items-center gap-4 p-3 rounded-lg hover:bg-white/5 transition-colors"
                                href="#">
                                <div
                                    class="shrink-0 size-10 rounded-full bg-blue-300 flex items-center justify-center text-black font-bold text-xl">
                                    C</div>
                                <div class="flex-1">
                                    <p class="font-semibold text-[var(--text-primary)]">Cardano</p>
                                    <p class="text-sm text-[var(--text-secondary)]">ADA</p>
                                </div>
                                <svg class="text-[var(--text-secondary)]" fill="currentColor" height="20"
                                    viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M181.66,133.66l-48,48a8,8,0,0,1-11.32-11.32L212.69,80H160a8,8,0,0,1,0-16h64a8,8,0,0,1,8,8v64a8,8,0,0,1-16,0V83.31L134.34,168a8,8,0,0,1-11.32-11.32l48-48A8,8,0,0,1,181.66,133.66Z">
                                    </path>
                                </svg>
                            </a>
                            <a class="flex items-center gap-4 p-3 rounded-lg hover:bg-white/5 transition-colors"
                                href="#">
                                <div
                                    class="shrink-0 size-10 rounded-full bg-yellow-600 flex items-center justify-center text-white font-bold text-xl">
                                    D</div>
                                <div class="flex-1">
                                    <p class="font-semibold text-[var(--text-primary)]">Dogecoin</p>
                                    <p class="text-sm text-[var(--text-secondary)]">DOGE</p>
                                </div>
                                <svg class="text-[var(--text-secondary)]" fill="currentColor" height="20"
                                    viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M181.66,133.66l-48,48a8,8,0,0,1-11.32-11.32L212.69,80H160a8,8,0,0,1,0-16h64a8,8,0,0,1,8,8v64a8,8,0,0,1-16,0V83.31L134.34,168a8,8,0,0,1-11.32-11.32l48-48A8,8,0,0,1,181.66,133.66Z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


</body>

</html>