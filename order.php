<?php
include_once "config/config.php";
include_once "config/functions.php";
if (!isset($_SESSION["cryptup_user"])) {
    echo "<script>location.href = 'login.php'</script>";
    exit;
}

$product_id = isset($_GET["product"]) ? intval($_GET["product"]) : 0;
$stmt = mysqli_prepare($conn, "SELECT * FROM `ledger_products` WHERE `id` = ? AND `in_stock` = 1");
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$product) {
    echo "<script>alert('Product not found or out of stock'); location.href = 'shop.php';</script>";
    exit;
}

$wallets = mysqli_query($conn, "SELECT * FROM `payment_wallets` ORDER BY `id` ASC");
$walletList = [];
while ($w = mysqli_fetch_assoc($wallets)) {
    $walletList[] = $w;
}

if (count($walletList) === 0) {
    echo "<script>alert('No payment methods available. Please try again later.'); location.href = 'shop.php';</script>";
    exit;
}

// Handle order submission
if (isset($_POST["place_order"])) {
    $quantity = max(1, intval($_POST["quantity"]));
    $total_usd = $product['price_usd'] * $quantity;
    $payment_wallet_id = intval($_POST["payment_wallet_id"]);
    $tx_hash = trim($_POST["tx_hash"]);
    $shipping_address = trim($_POST["shipping_address"]);

    // Validate wallet exists
    $wStmt = mysqli_prepare($conn, "SELECT * FROM `payment_wallets` WHERE `id` = ?");
    mysqli_stmt_bind_param($wStmt, "i", $payment_wallet_id);
    mysqli_stmt_execute($wStmt);
    $wResult = mysqli_stmt_get_result($wStmt);
    $selectedWallet = mysqli_fetch_assoc($wResult);
    mysqli_stmt_close($wStmt);

    if (!$selectedWallet) {
        echo "<script>alert('Invalid payment wallet selected');</script>";
    } elseif (empty($tx_hash) || strlen($tx_hash) < 10) {
        echo "<script>alert('Please enter a valid transaction hash');</script>";
    } elseif (empty($shipping_address)) {
        echo "<script>alert('Please enter your shipping address');</script>";
    } else {
        $payment_coin = $selectedWallet['coin'];

        $oStmt = mysqli_prepare($conn, "INSERT INTO `ledger_orders` (`user_id`, `product_id`, `quantity`, `total_usd`, `payment_coin`, `payment_wallet_id`, `tx_hash`, `shipping_address`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($oStmt, "iiidsiss", $user_id, $product_id, $quantity, $total_usd, $payment_coin, $payment_wallet_id, $tx_hash, $shipping_address);
        if (mysqli_stmt_execute($oStmt)) {
            echo "<script>alert('Order placed successfully! We will verify your payment and confirm shortly. ✔️'); location.href = 'my-orders.php';</script>";
        } else {
            echo "<script>alert('Failed to place order. Please try again. 🚫');</script>";
        }
        mysqli_stmt_close($oStmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CryptUP || Place Order</title>
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
        .cyber-grid {
            background-image:
                linear-gradient(rgba(83, 210, 44, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(83, 210, 44, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .glow-border {
            box-shadow: 0 0 0 1px rgba(83, 210, 44, 0.15), 0 0 20px -5px rgba(83, 210, 44, 0.1);
        }

        .copy-btn {
            transition: all 0.2s;
        }

        .copy-btn:active {
            transform: scale(0.95);
        }

        .step-line {
            width: 2px;
            background: linear-gradient(180deg, var(--primary-color), transparent);
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

        .wallet-option {
            cursor: pointer;
            transition: all 0.3s;
        }

        .wallet-option:hover {
            border-color: rgba(83, 210, 44, 0.4);
        }

        .wallet-option.selected {
            border-color: var(--primary-color);
            box-shadow: 0 0 15px -3px rgba(83, 210, 44, 0.3);
            background: rgba(83, 210, 44, 0.05);
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
                <!-- Back Button -->
                <a href="shop.php"
                    class="inline-flex items-center gap-2 text-[var(--text-secondary)] hover:text-white text-sm mb-6 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Back to Shop
                </a>

                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                    <!-- Product Summary (Left) -->
                    <div class="lg:col-span-2">
                        <div class="card glow-border border border-[var(--border-color)]/50 sticky top-8">
                            <div
                                class="relative rounded-xl overflow-hidden bg-gradient-to-br from-[#1a2a1a] to-[#0a150a] aspect-square flex items-center justify-center mb-4">
                                <?php if ($product['image_url']): ?>
                                    <img src="<?= htmlspecialchars($product['image_url']) ?>"
                                        class="w-full h-full object-contain p-6 float-anim" alt="">
                                <?php else: ?>
                                    <div class="text-center float-anim">
                                        <div class="text-7xl mb-2">🔐</div>
                                        <div class="text-xs text-[var(--text-secondary)] font-mono tracking-widest">HARDWARE
                                            VAULT</div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h2 class="text-2xl font-black mb-2"><?= htmlspecialchars($product['name']) ?></h2>
                            <div class="flex items-center gap-2 mb-3">
                                <span
                                    class="bg-cyan-500/10 text-cyan-400 px-3 py-0.5 rounded-full text-xs font-bold border border-cyan-500/20">
                                    <?= htmlspecialchars($product['capacity']) ?>
                                </span>
                            </div>
                            <?php if ($product['description']): ?>
                                <p class="text-sm text-[var(--text-secondary)] mb-4">
                                    <?= htmlspecialchars($product['description']) ?></p>
                            <?php endif; ?>
                            <div class="border-t border-[var(--border-color)]/30 pt-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-xs text-[var(--text-secondary)] uppercase tracking-wider">Unit
                                            Price</div>
                                        <div class="text-3xl font-black text-green-400">
                                            $<?= number_format($product['price_usd'], 2) ?></div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs text-[var(--text-secondary)] uppercase tracking-wider">Total
                                        </div>
                                        <div class="text-3xl font-black text-white" id="displayTotal">
                                            $<?= number_format($product['price_usd'], 2) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Form (Right) -->
                    <div class="lg:col-span-3">
                        <form method="post" id="orderForm">
                            <!-- Step 1: Quantity -->
                            <div class="card border border-[var(--border-color)]/50 mb-4">
                                <div class="flex items-center gap-3 mb-4">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-gradient-to-br from-green-500 to-emerald-700 flex items-center justify-center text-sm font-black">
                                        1</div>
                                    <h3 class="text-lg font-bold">Choose Quantity</h3>
                                </div>
                                <div class="flex items-center gap-4">
                                    <button type="button" onclick="changeQty(-1)"
                                        class="w-10 h-10 rounded-xl bg-gray-700 hover:bg-gray-600 flex items-center justify-center text-xl font-bold transition-colors">&minus;</button>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="99"
                                        readonly
                                        class="w-20 text-center bg-transparent border border-[var(--border-color)] rounded-xl py-2 text-xl font-bold text-white">
                                    <button type="button" onclick="changeQty(1)"
                                        class="w-10 h-10 rounded-xl bg-gray-700 hover:bg-gray-600 flex items-center justify-center text-xl font-bold transition-colors">+</button>
                                </div>
                            </div>

                            <!-- Step 2: Select Payment Method -->
                            <div class="card border border-[var(--border-color)]/50 mb-4">
                                <div class="flex items-center gap-3 mb-4">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-500 to-blue-700 flex items-center justify-center text-sm font-black">
                                        2</div>
                                    <h3 class="text-lg font-bold">Select Payment Method</h3>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="walletOptions">
                                    <?php foreach ($walletList as $i => $w): ?>
                                        <div class="wallet-option rounded-xl p-4 border border-[var(--border-color)] <?= $i === 0 ? 'selected' : '' ?>"
                                            onclick="selectWallet(<?= $w['id'] ?>, this)" data-wallet-id="<?= $w['id'] ?>"
                                            data-address="<?= htmlspecialchars($w['address']) ?>">
                                            <div class="flex items-center gap-2 mb-2">
                                                <div
                                                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-500/20 to-blue-700/20 flex items-center justify-center text-xs font-bold text-cyan-400">
                                                    <?= strtoupper(substr($w['coin'], 0, 3)) ?>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-sm"><?= htmlspecialchars($w['coin']) ?></div>
                                                    <?php if ($w['network']): ?>
                                                        <div class="text-xs text-[var(--text-secondary)]">
                                                            <?= htmlspecialchars($w['network']) ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <input type="hidden" name="payment_wallet_id" id="payment_wallet_id"
                                    value="<?= $walletList[0]['id'] ?>">
                            </div>

                            <!-- Step 3: Send Payment -->
                            <div class="card border border-[var(--border-color)]/50 mb-4">
                                <div class="flex items-center gap-3 mb-4">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-gradient-to-br from-yellow-500 to-orange-700 flex items-center justify-center text-sm font-black">
                                        3</div>
                                    <h3 class="text-lg font-bold">Send Payment</h3>
                                </div>
                                <p class="text-sm text-[var(--text-secondary)] mb-3">
                                    Transfer the equivalent of <strong class="text-green-400"
                                        id="paymentAmount">$<?= number_format($product['price_usd'], 2) ?></strong>
                                    in <strong class="text-cyan-400"
                                        id="paymentCoin"><?= htmlspecialchars($walletList[0]['coin']) ?></strong> to the
                                    address below:
                                </p>
                                <div
                                    class="bg-black/40 rounded-xl p-4 border border-[var(--border-color)]/30 flex items-center gap-3 mb-4">
                                    <code class="flex-1 text-sm break-all text-green-400 font-mono"
                                        id="walletAddress"><?= htmlspecialchars($walletList[0]['address']) ?></code>
                                    <button type="button" onclick="copyAddress()"
                                        class="copy-btn flex-shrink-0 bg-gray-700 hover:bg-gray-600 px-3 py-2 rounded-lg text-xs font-bold transition-colors">
                                        <span id="copyLabel">Copy</span>
                                    </button>
                                </div>
                                <div
                                    class="bg-yellow-500/10 border border-yellow-500/20 rounded-xl p-3 text-sm text-yellow-300 flex items-start gap-2">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z">
                                        </path>
                                    </svg>
                                    <span>Send the exact amount to avoid delays in verification. Include network fees in
                                        your transfer.</span>
                                </div>
                            </div>

                            <!-- Step 4: Submit TX Hash -->
                            <div class="card border border-[var(--border-color)]/50 mb-4">
                                <div class="flex items-center gap-3 mb-4">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-700 flex items-center justify-center text-sm font-black">
                                        4</div>
                                    <h3 class="text-lg font-bold">Enter Transaction Hash</h3>
                                </div>
                                <p class="text-sm text-[var(--text-secondary)] mb-3">
                                    After sending the payment, paste the transaction hash (TX ID) from your wallet.
                                </p>
                                <input type="text" name="tx_hash" class="input font-mono" placeholder="0x..." required
                                    minlength="10">
                            </div>

                            <!-- Step 5: Shipping Address -->
                            <div class="card border border-[var(--border-color)]/50 mb-4">
                                <div class="flex items-center gap-3 mb-4">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-gradient-to-br from-pink-500 to-rose-700 flex items-center justify-center text-sm font-black">
                                        5</div>
                                    <h3 class="text-lg font-bold">Shipping Address</h3>
                                </div>
                                <textarea name="shipping_address" class="input" rows="3"
                                    placeholder="Enter your full shipping address including city, state, zip code, and country..."
                                    required></textarea>
                            </div>

                            <!-- Submit -->
                            <button type="submit" name="place_order"
                                class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-400 hover:to-emerald-500 text-black font-black text-lg py-4 rounded-2xl transition-all duration-300 hover:shadow-lg hover:shadow-green-500/20 hover:-translate-y-0.5 flex items-center justify-center gap-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                                <span>Confirm & Place Order</span>
                            </button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        const unitPrice = <?= $product['price_usd'] ?>;
        const walletsData = <?= json_encode($walletList) ?>;

        function changeQty(delta) {
            const input = document.getElementById('quantity');
            let val = parseInt(input.value) + delta;
            if (val < 1) val = 1;
            if (val > 99) val = 99;
            input.value = val;
            updateTotal();
        }

        function updateTotal() {
            const qty = parseInt(document.getElementById('quantity').value);
            const total = (unitPrice * qty).toFixed(2);
            document.getElementById('displayTotal').textContent = '$' + Number(total).toLocaleString('en-US', { minimumFractionDigits: 2 });
            document.getElementById('paymentAmount').textContent = '$' + Number(total).toLocaleString('en-US', { minimumFractionDigits: 2 });
        }

        function selectWallet(walletId, el) {
            document.querySelectorAll('.wallet-option').forEach(w => w.classList.remove('selected'));
            el.classList.add('selected');
            document.getElementById('payment_wallet_id').value = walletId;

            const wallet = walletsData.find(w => w.id == walletId);
            if (wallet) {
                document.getElementById('walletAddress').textContent = wallet.address;
                document.getElementById('paymentCoin').textContent = wallet.coin;
            }
        }

        function copyAddress() {
            const address = document.getElementById('walletAddress').textContent;
            navigator.clipboard.writeText(address).then(() => {
                const label = document.getElementById('copyLabel');
                label.textContent = 'Copied!';
                setTimeout(() => { label.textContent = 'Copy'; }, 2000);
            });
        }
    </script>
</body>

</html>