<?php
include_once "config/config.php";
include_once "config/functions.php";
if (!isset($_SESSION["cryptup_user"])) {
    echo "<script>location.href = 'login.php'</script>";
    exit;
}

$stmt = mysqli_prepare($conn, "
  SELECT o.*, p.name AS product_name, p.capacity AS product_capacity, p.image_url AS product_image,
         w.coin AS wallet_coin, w.network AS wallet_network
  FROM ledger_orders o
  LEFT JOIN ledger_products p ON o.product_id = p.id
  LEFT JOIN payment_wallets w ON o.payment_wallet_id = w.id
  WHERE o.user_id = ?
  ORDER BY o.id DESC
");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$orders = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CryptUP || My Orders</title>
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
    .button_primary { @apply bg-[var(--primary-color)] text-black rounded-full px-4 py-2 sm:px-6 sm:py-3 font-bold hover:bg-[var(--accent-color)] transition-colors duration-300; }
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

        .status-pulse {
            animation: statusPulse 2s ease-in-out infinite;
        }

        @keyframes statusPulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }
        }

        .order-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px -4px rgba(0, 0, 0, 0.3);
        }

        .progress-track {
            height: 3px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 999px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 999px;
            transition: width 0.6s ease;
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
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 sm:mb-8 gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-1">My Orders</h1>
                        <p class="text-[var(--text-secondary)] text-sm sm:text-base">Track your hardware ledger orders
                        </p>
                    </div>
                    <a href="shop.php" class="button_primary text-sm px-6 py-2.5 flex items-center gap-2 w-fit">
                        <span>Browse Shop</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>

                <!-- Orders List -->
                <div class="space-y-4">
                    <?php if (mysqli_num_rows($orders) > 0): ?>
                        <?php while ($o = mysqli_fetch_assoc($orders)): ?>
                            <?php
                            $statusConfig = [
                                'pending' => ['color' => 'yellow', 'icon' => '⏳', 'label' => 'Pending Verification', 'progress' => 25],
                                'confirmed' => ['color' => 'green', 'icon' => '✅', 'label' => 'Payment Confirmed', 'progress' => 50],
                                'shipped' => ['color' => 'blue', 'icon' => '🚀', 'label' => 'Shipped', 'progress' => 75],
                                'delivered' => ['color' => 'emerald', 'icon' => '📦', 'label' => 'Delivered', 'progress' => 100],
                                'rejected' => ['color' => 'red', 'icon' => '❌', 'label' => 'Rejected', 'progress' => 0],
                            ];
                            $s = $statusConfig[$o['status']] ?? $statusConfig['pending'];
                            ?>
                            <div class="order-card card border border-[var(--border-color)]/50">
                                <!-- Progress Bar -->
                                <?php if ($o['status'] !== 'rejected'): ?>
                                    <div class="progress-track mb-4">
                                        <div class="progress-fill bg-<?= $s['color'] ?>-500" style="width: <?= $s['progress'] ?>%">
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="flex flex-col md:flex-row md:items-start gap-4">
                                    <!-- Product -->
                                    <div class="flex items-center gap-4 flex-1 min-w-0">
                                        <?php if ($o['product_image']): ?>
                                            <img src="<?= htmlspecialchars($o['product_image']) ?>"
                                                class="w-16 h-16 rounded-xl object-cover flex-shrink-0" alt="">
                                        <?php else: ?>
                                            <div
                                                class="w-16 h-16 rounded-xl bg-gradient-to-br from-green-600 to-emerald-800 flex items-center justify-center text-2xl flex-shrink-0">
                                                🔐</div>
                                        <?php endif; ?>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2 flex-wrap mb-1">
                                                <span class="font-bold">Order #<?= $o['id'] ?></span>
                                                <span
                                                    class="bg-<?= $s['color'] ?>-500/20 text-<?= $s['color'] ?>-400 px-3 py-0.5 rounded-full text-xs font-bold flex items-center gap-1">
                                                    <span
                                                        class="<?= $o['status'] === 'pending' ? 'status-pulse' : '' ?>"><?= $s['icon'] ?></span>
                                                    <?= $s['label'] ?>
                                                </span>
                                            </div>
                                            <div class="text-sm text-[var(--text-secondary)]">
                                                <?= htmlspecialchars($o['product_name'] ?? 'Product') ?> &middot;
                                                <?= htmlspecialchars($o['product_capacity'] ?? '') ?></div>
                                            <div class="text-xs text-[var(--text-secondary)] mt-1">
                                                <?= date('M j, Y g:i A', strtotime($o['created_at'])) ?></div>
                                        </div>
                                    </div>

                                    <!-- Details -->
                                    <div class="flex-shrink-0 text-right">
                                        <div class="text-xs text-[var(--text-secondary)]">Qty: <?= $o['quantity'] ?></div>
                                        <div class="text-xl font-black text-green-400">$<?= number_format($o['total_usd'], 2) ?>
                                        </div>
                                        <div class="text-xs text-cyan-400"><?= htmlspecialchars($o['payment_coin']) ?>
                                            <?= $o['wallet_network'] ? '(' . htmlspecialchars($o['wallet_network']) . ')' : '' ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- TX Hash -->
                                <div class="mt-3 pt-3 border-t border-[var(--border-color)]/30 text-sm">
                                    <span class="text-[var(--text-secondary)]">TX Hash:</span>
                                    <code
                                        class="bg-black/30 px-2 py-0.5 rounded text-xs break-all ml-1"><?= htmlspecialchars($o['tx_hash']) ?></code>
                                </div>

                                <!-- Admin Note -->
                                <?php if ($o['admin_note']): ?>
                                    <div
                                        class="mt-2 bg-<?= $s['color'] ?>-500/10 border border-<?= $s['color'] ?>-500/20 rounded-xl p-3 text-sm">
                                        <span class="text-[var(--text-secondary)]">Note from admin:</span>
                                        <span class="ml-1"><?= htmlspecialchars($o['admin_note']) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="card text-center py-16">
                            <div class="text-6xl mb-4">🛒</div>
                            <h3 class="text-xl font-bold mb-2">No Orders Yet</h3>
                            <p class="text-[var(--text-secondary)] mb-6">Browse our hardware ledger collection and make your
                                first purchase.</p>
                            <a href="shop.php" class="button_primary inline-flex items-center gap-2">
                                <span>Visit Shop</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
</body>

</html>