<?php
include_once "../config/config.php";
if (!isset($_SESSION["cryptup_admin"])) {
    echo "<script>location.href = 'login.php'</script>";
    exit;
}

// Handle status update
if (isset($_POST["update_status"])) {
    $order_id = intval($_POST["order_id"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);
    $admin_note = mysqli_real_escape_string($conn, $_POST["admin_note"]);

    $allowed = ['pending', 'confirmed', 'shipped', 'delivered', 'rejected'];
    if (in_array($status, $allowed)) {
        $stmt = mysqli_prepare($conn, "UPDATE `ledger_orders` SET `status` = ?, `admin_note` = ? WHERE `id` = ?");
        mysqli_stmt_bind_param($stmt, "ssi", $status, $admin_note, $order_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Order #$order_id updated ✔️'); location.href='orders.php';</script>";
        } else {
            echo "<script>alert('Update failed 🚫');</script>";
        }
        mysqli_stmt_close($stmt);
    }
}

$filter = isset($_GET["filter"]) ? mysqli_real_escape_string($conn, $_GET["filter"]) : "";
$where = $filter ? "WHERE o.status = '$filter'" : "";

$orders = mysqli_query($conn, "
  SELECT o.*, u.name AS user_name, u.email AS user_email,
         p.name AS product_name, p.capacity AS product_capacity, p.image_url AS product_image,
         w.coin AS wallet_coin, w.network AS wallet_network, w.address AS wallet_address
  FROM ledger_orders o
  LEFT JOIN users u ON o.user_id = u.id
  LEFT JOIN ledger_products p ON o.product_id = p.id
  LEFT JOIN payment_wallets w ON o.payment_wallet_id = w.id
  $where
  ORDER BY o.id DESC
");

$counts = [];
$countQ = mysqli_query($conn, "SELECT status, COUNT(*) as cnt FROM ledger_orders GROUP BY status");
while ($r = mysqli_fetch_assoc($countQ)) {
    $counts[$r['status']] = $r['cnt'];
}
$totalOrders = array_sum($counts);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CryptUP || Manage Orders</title>
    <link rel="icon" href="data:image/x-icon;base64," type="image/x-icon" />
    <link crossorigin href="https://fonts.gstatic.com/" rel="preconnect" />
    <link as="style" rel="stylesheet" onload="this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css2?display=swap&family=Manrope:wght@400;500;700;800&family=Noto+Sans:wght@400;500;700;900" />
    <script src="../assets/js/tailwindcss.js"></script>
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
    .sidebar-mobile { transform: translateX(-100%); }
    .sidebar-mobile.open { transform: translateX(0); }
    @media (min-width: 768px) { .sidebar-mobile { transform: translateX(0); } }
  </style>
    <?php include "../components/pwa-head.php"; ?>
</head>

<body class="bg-[var(--background-color)] text-[var(--text-primary)] overflow-x-hidden">
    <div class="flex min-h-screen">
        <?php include "components/sidebar.php"; ?>

        <div class="flex-1 flex flex-col min-w-0">
            <?php include "components/header.php"; ?>

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <div class="mb-6 sm:mb-8">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2">Ledger Orders</h1>
                    <p class="text-[var(--text-secondary)] text-sm sm:text-base">Review and confirm customer orders</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
                    <a href="orders.php"
                        class="card text-center hover:border-white/20 border border-transparent transition-colors <?= !$filter ? 'border-[var(--primary-color)]' : '' ?>">
                        <div class="text-2xl font-bold"><?= $totalOrders ?></div>
                        <div class="text-xs text-[var(--text-secondary)]">All</div>
                    </a>
                    <a href="?filter=pending"
                        class="card text-center hover:border-yellow-500/30 border border-transparent transition-colors <?= $filter === 'pending' ? 'border-yellow-500' : '' ?>">
                        <div class="text-2xl font-bold text-yellow-400"><?= $counts['pending'] ?? 0 ?></div>
                        <div class="text-xs text-[var(--text-secondary)]">Pending</div>
                    </a>
                    <a href="?filter=confirmed"
                        class="card text-center hover:border-green-500/30 border border-transparent transition-colors <?= $filter === 'confirmed' ? 'border-green-500' : '' ?>">
                        <div class="text-2xl font-bold text-green-400"><?= $counts['confirmed'] ?? 0 ?></div>
                        <div class="text-xs text-[var(--text-secondary)]">Confirmed</div>
                    </a>
                    <a href="?filter=shipped"
                        class="card text-center hover:border-blue-500/30 border border-transparent transition-colors <?= $filter === 'shipped' ? 'border-blue-500' : '' ?>">
                        <div class="text-2xl font-bold text-blue-400"><?= $counts['shipped'] ?? 0 ?></div>
                        <div class="text-xs text-[var(--text-secondary)]">Shipped</div>
                    </a>
                    <a href="?filter=rejected"
                        class="card text-center hover:border-red-500/30 border border-transparent transition-colors <?= $filter === 'rejected' ? 'border-red-500' : '' ?>">
                        <div class="text-2xl font-bold text-red-400"><?= $counts['rejected'] ?? 0 ?></div>
                        <div class="text-xs text-[var(--text-secondary)]">Rejected</div>
                    </a>
                </div>

                <!-- Orders -->
                <div class="space-y-4">
                    <?php if (mysqli_num_rows($orders) > 0): ?>
                        <?php while ($o = mysqli_fetch_assoc($orders)): ?>
                            <?php
                            $statusColors = [
                                'pending' => 'bg-yellow-500/20 text-yellow-400',
                                'confirmed' => 'bg-green-500/20 text-green-400',
                                'shipped' => 'bg-blue-500/20 text-blue-400',
                                'delivered' => 'bg-emerald-500/20 text-emerald-400',
                                'rejected' => 'bg-red-500/20 text-red-400',
                            ];
                            $statusClass = $statusColors[$o['status']] ?? 'bg-gray-500/20 text-gray-400';
                            ?>
                            <div class="card border border-[var(--border-color)]/50">
                                <div class="flex flex-col lg:flex-row lg:items-start gap-4">
                                    <!-- Product Info -->
                                    <div class="flex items-center gap-4 flex-1 min-w-0">
                                        <?php if ($o['product_image']): ?>
                                            <img src="../<?= htmlspecialchars($o['product_image']) ?>"
                                                class="w-16 h-16 rounded-xl object-cover flex-shrink-0" alt="">
                                        <?php else: ?>
                                            <div
                                                class="w-16 h-16 rounded-xl bg-gradient-to-br from-green-600 to-emerald-800 flex items-center justify-center text-2xl flex-shrink-0">
                                                🔐</div>
                                        <?php endif; ?>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span class="font-bold text-lg">Order #<?= $o['id'] ?></span>
                                                <span
                                                    class="<?= $statusClass ?> px-3 py-0.5 rounded-full text-xs font-bold uppercase"><?= $o['status'] ?></span>
                                            </div>
                                            <div class="text-sm text-[var(--text-secondary)]">
                                                <?= htmlspecialchars($o['product_name'] ?? 'Deleted Product') ?> &middot;
                                                <?= htmlspecialchars($o['product_capacity'] ?? '') ?></div>
                                            <div class="text-sm mt-1">
                                                <span class="text-[var(--text-secondary)]">Qty:</span> <?= $o['quantity'] ?>
                                                &middot;
                                                <span
                                                    class="text-green-400 font-bold">$<?= number_format($o['total_usd'], 2) ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Customer & Payment -->
                                    <div class="flex-1 min-w-0 space-y-2 text-sm">
                                        <div><span class="text-[var(--text-secondary)]">Customer:</span>
                                            <?= htmlspecialchars($o['user_name'] ?? 'Unknown') ?>
                                            (<?= htmlspecialchars($o['user_email'] ?? '') ?>)</div>
                                        <div><span class="text-[var(--text-secondary)]">Paid via:</span> <span
                                                class="text-cyan-400 font-bold"><?= htmlspecialchars($o['payment_coin']) ?></span>
                                            <?= $o['wallet_network'] ? '(' . htmlspecialchars($o['wallet_network']) . ')' : '' ?>
                                        </div>
                                        <div class="break-all"><span class="text-[var(--text-secondary)]">TX Hash:</span> <code
                                                class="bg-black/30 px-2 py-0.5 rounded text-xs"><?= htmlspecialchars($o['tx_hash']) ?></code>
                                        </div>
                                        <div class="break-all"><span class="text-[var(--text-secondary)]">Shipping:</span>
                                            <?= htmlspecialchars($o['shipping_address']) ?></div>
                                        <div class="text-xs text-[var(--text-secondary)]">
                                            <?= date('M j, Y g:i A', strtotime($o['created_at'])) ?></div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex-shrink-0">
                                        <button
                                            onclick="openOrderModal(<?= $o['id'] ?>, '<?= $o['status'] ?>', `<?= addslashes($o['admin_note'] ?? '') ?>`)"
                                            class="button_primary text-sm px-4 py-2">Update Status</button>
                                    </div>
                                </div>
                                <?php if ($o['admin_note']): ?>
                                    <div class="mt-3 pt-3 border-t border-[var(--border-color)]/30 text-sm">
                                        <span class="text-[var(--text-secondary)]">Admin Note:</span>
                                        <?= htmlspecialchars($o['admin_note']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="card text-center py-12">
                            <div class="text-4xl mb-3">📦</div>
                            <p class="text-[var(--text-secondary)]">No orders
                                found<?= $filter ? " with status \"$filter\"" : '' ?>.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div id="orderModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm hidden">
        <div class="card w-full max-w-md mx-4 relative">
            <button onclick="closeOrderModal()"
                class="absolute top-4 right-4 text-[var(--text-secondary)] hover:text-white text-xl">&times;</button>
            <h2 class="text-lg font-bold mb-4">Update Order Status</h2>
            <form method="post">
                <input type="hidden" name="order_id" id="modal_order_id">
                <div class="flex flex-col space-y-2 mb-4">
                    <label class="font-semibold text-sm text-[var(--text-secondary)]">Status</label>
                    <select name="status" id="modal_status" class="input">
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="flex flex-col space-y-2 mb-4">
                    <label class="font-semibold text-sm text-[var(--text-secondary)]">Admin Note (optional)</label>
                    <textarea name="admin_note" id="modal_note" class="input" rows="3"
                        placeholder="Add a note for the customer..."></textarea>
                </div>
                <button class="button_primary w-full" name="update_status" type="submit">Update Order</button>
            </form>
        </div>
    </div>

    <script>
        function openOrderModal(id, status, note) {
            document.getElementById('modal_order_id').value = id;
            document.getElementById('modal_status').value = status;
            document.getElementById('modal_note').value = note;
            document.getElementById('orderModal').classList.remove('hidden');
        }
        function closeOrderModal() {
            document.getElementById('orderModal').classList.add('hidden');
        }
    </script>
</body>

</html>