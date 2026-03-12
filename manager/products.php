<?php
include_once "../config/config.php";
if (!isset($_SESSION["cryptup_admin"])) {
    echo "<script>location.href = 'login.php'</script>";
    exit;
}

// Handle Add Product
if (isset($_POST["add_product"])) {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $capacity = mysqli_real_escape_string($conn, $_POST["capacity"]);
    $price = floatval($_POST["price_usd"]);
    $in_stock = isset($_POST["in_stock"]) ? 1 : 0;
    $image_url = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (in_array($_FILES['image']['type'], $allowed)) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('prod_') . '.' . $ext;
            $dest = __DIR__ . '/../uploads/products/' . $filename;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
                $image_url = 'uploads/products/' . $filename;
            }
        }
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO `ledger_products` (`name`, `description`, `capacity`, `price_usd`, `image_url`, `in_stock`) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssdsi", $name, $description, $capacity, $price, $image_url, $in_stock);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Product added successfully ✔️'); location.href='products.php';</script>";
    } else {
        echo "<script>alert('Failed to add product 🚫');</script>";
    }
    mysqli_stmt_close($stmt);
}

// Handle Delete Product
if (isset($_GET["delete"])) {
    $id = intval($_GET["delete"]);
    // Remove image file
    $imgQ = mysqli_prepare($conn, "SELECT image_url FROM `ledger_products` WHERE `id` = ?");
    mysqli_stmt_bind_param($imgQ, "i", $id);
    mysqli_stmt_execute($imgQ);
    $imgR = mysqli_stmt_get_result($imgQ);
    if ($row = mysqli_fetch_assoc($imgR)) {
        $imgPath = __DIR__ . '/../' . $row['image_url'];
        if ($row['image_url'] && file_exists($imgPath)) {
            unlink($imgPath);
        }
    }
    mysqli_stmt_close($imgQ);

    $stmt = mysqli_prepare($conn, "DELETE FROM `ledger_products` WHERE `id` = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "<script>location.href='products.php';</script>";
}

// Handle Toggle Stock
if (isset($_GET["toggle_stock"])) {
    $id = intval($_GET["toggle_stock"]);
    mysqli_query($conn, "UPDATE `ledger_products` SET `in_stock` = NOT `in_stock` WHERE `id` = $id");
    echo "<script>location.href='products.php';</script>";
}

// Handle Edit Product
if (isset($_POST["edit_product"])) {
    $id = intval($_POST["product_id"]);
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $capacity = mysqli_real_escape_string($conn, $_POST["capacity"]);
    $price = floatval($_POST["price_usd"]);
    $in_stock = isset($_POST["in_stock"]) ? 1 : 0;

    // Check for new image upload
    $image_sql = '';
    $image_url = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (in_array($_FILES['image']['type'], $allowed)) {
            // Delete old image
            $oldQ = mysqli_prepare($conn, "SELECT image_url FROM `ledger_products` WHERE `id` = ?");
            mysqli_stmt_bind_param($oldQ, "i", $id);
            mysqli_stmt_execute($oldQ);
            $oldR = mysqli_stmt_get_result($oldQ);
            if ($oldRow = mysqli_fetch_assoc($oldR)) {
                $oldPath = __DIR__ . '/../' . $oldRow['image_url'];
                if ($oldRow['image_url'] && file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            mysqli_stmt_close($oldQ);

            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('prod_') . '.' . $ext;
            $dest = __DIR__ . '/../uploads/products/' . $filename;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
                $image_url = 'uploads/products/' . $filename;
            }
        }
    }

    if ($image_url !== null) {
        $stmt = mysqli_prepare($conn, "UPDATE `ledger_products` SET `name`=?, `description`=?, `capacity`=?, `price_usd`=?, `image_url`=?, `in_stock`=? WHERE `id`=?");
        mysqli_stmt_bind_param($stmt, "sssdsii", $name, $description, $capacity, $price, $image_url, $in_stock, $id);
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE `ledger_products` SET `name`=?, `description`=?, `capacity`=?, `price_usd`=?, `in_stock`=? WHERE `id`=?");
        mysqli_stmt_bind_param($stmt, "sssdii", $name, $description, $capacity, $price, $in_stock, $id);
    }
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Product updated ✔️'); location.href='products.php';</script>";
    } else {
        echo "<script>alert('Update failed 🚫');</script>";
    }
    mysqli_stmt_close($stmt);
}

// Handle Add Wallet
if (isset($_POST["add_wallet"])) {
    $coin = mysqli_real_escape_string($conn, $_POST["coin"]);
    $network = mysqli_real_escape_string($conn, $_POST["network"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);

    $stmt = mysqli_prepare($conn, "INSERT INTO `payment_wallets` (`coin`, `network`, `address`) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $coin, $network, $address);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Wallet added ✔️'); location.href='products.php';</script>";
    } else {
        echo "<script>alert('Failed to add wallet 🚫');</script>";
    }
    mysqli_stmt_close($stmt);
}

// Handle Edit Wallet
if (isset($_POST["edit_wallet"])) {
    $id = intval($_POST["wallet_id"]);
    $coin = mysqli_real_escape_string($conn, $_POST["coin"]);
    $network = mysqli_real_escape_string($conn, $_POST["network"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);

    $stmt = mysqli_prepare($conn, "UPDATE `payment_wallets` SET `coin`=?, `network`=?, `address`=? WHERE `id`=?");
    mysqli_stmt_bind_param($stmt, "sssi", $coin, $network, $address, $id);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Wallet updated ✔️'); location.href='products.php';</script>";
    } else {
        echo "<script>alert('Update failed 🚫');</script>";
    }
    mysqli_stmt_close($stmt);
}

// Handle Delete Wallet
if (isset($_GET["delete_wallet"])) {
    $id = intval($_GET["delete_wallet"]);
    $stmt = mysqli_prepare($conn, "DELETE FROM `payment_wallets` WHERE `id` = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "<script>location.href='products.php';</script>";
}

$products = mysqli_query($conn, "SELECT * FROM `ledger_products` ORDER BY `id` DESC");
$wallets = mysqli_query($conn, "SELECT * FROM `payment_wallets` ORDER BY `id` DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CryptUP || Manage Products</title>
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
    .button_secondary { @apply bg-gray-700 text-[var(--text-primary)] rounded-full px-4 py-2 sm:px-6 sm:py-3 font-bold hover:bg-gray-600 transition-colors duration-300; }
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
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2">Hardware Ledgers</h1>
                    <p class="text-[var(--text-secondary)] text-sm sm:text-base">Manage products and payment wallets</p>
                </div>

                <!-- Tab Navigation -->
                <div class="flex gap-2 mb-6">
                    <button onclick="switchTab('products')" id="tab-products"
                        class="px-5 py-2 rounded-full font-bold text-sm transition-colors duration-200 bg-[var(--primary-color)] text-black">
                        Products
                    </button>
                    <button onclick="switchTab('wallets')" id="tab-wallets"
                        class="px-5 py-2 rounded-full font-bold text-sm transition-colors duration-200 bg-gray-700 text-[var(--text-primary)]">
                        Payment Wallets
                    </button>
                </div>

                <!-- Products Section -->
                <div id="section-products">
                    <!-- Add Product Form -->
                    <div class="card mb-6">
                        <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                            <span
                                class="w-8 h-8 rounded-lg bg-gradient-to-br from-green-500 to-emerald-700 flex items-center justify-center text-sm">+</span>
                            Add New Ledger
                        </h2>
                        <form method="post" enctype="multipart/form-data">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div class="flex flex-col space-y-2">
                                    <label class="font-semibold text-sm text-[var(--text-secondary)]">Product
                                        Name</label>
                                    <input type="text" name="name" class="input" placeholder="e.g. Ledger Nano X"
                                        required>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <label class="font-semibold text-sm text-[var(--text-secondary)]">Capacity /
                                        Model</label>
                                    <input type="text" name="capacity" class="input" placeholder="e.g. 100 Apps, 256KB"
                                        required>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <label class="font-semibold text-sm text-[var(--text-secondary)]">Price
                                        (USD)</label>
                                    <input type="number" step="0.01" name="price_usd" class="input" placeholder="149.99"
                                        required>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <label class="font-semibold text-sm text-[var(--text-secondary)]">Product
                                        Image</label>
                                    <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif"
                                        class="input file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-green-500/20 file:text-green-400 hover:file:bg-green-500/30">
                                </div>
                            </div>
                            <div class="flex flex-col space-y-2 mb-4">
                                <label class="font-semibold text-sm text-[var(--text-secondary)]">Description</label>
                                <textarea name="description" class="input" rows="3"
                                    placeholder="Product description..."></textarea>
                            </div>
                            <div class="flex items-center gap-3 mb-4">
                                <input type="checkbox" name="in_stock" id="in_stock" checked
                                    class="w-4 h-4 accent-green-500">
                                <label for="in_stock" class="text-sm text-[var(--text-secondary)]">In Stock</label>
                            </div>
                            <button class="button_primary" name="add_product" type="submit">Add Product</button>
                        </form>
                    </div>

                    <!-- Products Table -->
                    <div class="card">
                        <h2 class="text-lg font-bold mb-4">All Products</h2>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-[var(--border-color)] text-[var(--text-secondary)]">
                                        <th class="text-left py-3 px-2">Product</th>
                                        <th class="text-left py-3 px-2">Capacity</th>
                                        <th class="text-left py-3 px-2">Price</th>
                                        <th class="text-left py-3 px-2">Stock</th>
                                        <th class="text-left py-3 px-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($products) > 0): ?>
                                        <?php while ($p = mysqli_fetch_assoc($products)): ?>
                                            <tr
                                                class="border-b border-[var(--border-color)]/30 hover:bg-white/5 transition-colors">
                                                <td class="py-3 px-2">
                                                    <div class="flex items-center gap-3">
                                                        <?php if ($p['image_url']): ?>
                                                            <img src="../<?= htmlspecialchars($p['image_url']) ?>"
                                                                class="w-10 h-10 rounded-lg object-cover" alt="">
                                                        <?php else: ?>
                                                            <div
                                                                class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-600 to-emerald-800 flex items-center justify-center text-lg">
                                                                🔐</div>
                                                        <?php endif; ?>
                                                        <div>
                                                            <div class="font-bold"><?= htmlspecialchars($p['name']) ?></div>
                                                            <div
                                                                class="text-xs text-[var(--text-secondary)] max-w-[200px] truncate">
                                                                <?= htmlspecialchars($p['description'] ?? '') ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-2 text-[var(--text-secondary)]">
                                                    <?= htmlspecialchars($p['capacity']) ?>
                                                </td>
                                                <td class="py-3 px-2 font-bold text-green-400">
                                                    $<?= number_format($p['price_usd'], 2) ?></td>
                                                <td class="py-3 px-2">
                                                    <?php if ($p['in_stock']): ?>
                                                        <span
                                                            class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-xs font-bold">In
                                                            Stock</span>
                                                    <?php else: ?>
                                                        <span
                                                            class="bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-xs font-bold">Out
                                                            of Stock</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="py-3 px-2">
                                                    <div class="flex items-center gap-2">
                                                        <button
                                                            onclick="openEditModal(<?= htmlspecialchars(json_encode($p)) ?>)"
                                                            class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-lg text-xs font-bold hover:bg-blue-500/30 transition-colors">Edit</button>
                                                        <a href="?toggle_stock=<?= $p['id'] ?>"
                                                            class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-lg text-xs font-bold hover:bg-yellow-500/30 transition-colors">Toggle</a>
                                                        <a href="?delete=<?= $p['id'] ?>"
                                                            onclick="return confirm('Delete this product?')"
                                                            class="bg-red-500/20 text-red-400 px-3 py-1 rounded-lg text-xs font-bold hover:bg-red-500/30 transition-colors">Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-[var(--text-secondary)]">No
                                                products yet. Add your first hardware ledger above.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Wallets Section -->
                <div id="section-wallets" class="hidden">
                    <div class="card mb-6">
                        <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                            <span
                                class="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-500 to-blue-700 flex items-center justify-center text-sm">+</span>
                            Add Payment Wallet
                        </h2>
                        <form method="post">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div class="flex flex-col space-y-2">
                                    <label class="font-semibold text-sm text-[var(--text-secondary)]">Coin</label>
                                    <input type="text" name="coin" class="input" placeholder="e.g. BTC, ETH, USDT"
                                        required>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <label class="font-semibold text-sm text-[var(--text-secondary)]">Network</label>
                                    <input type="text" name="network" class="input"
                                        placeholder="e.g. ERC-20, TRC-20, BEP-20">
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <label class="font-semibold text-sm text-[var(--text-secondary)]">Wallet
                                        Address</label>
                                    <input type="text" name="address" class="input" placeholder="0x..." required>
                                </div>
                            </div>
                            <button class="button_primary" name="add_wallet" type="submit">Add Wallet</button>
                        </form>
                    </div>

                    <div class="card">
                        <h2 class="text-lg font-bold mb-4">Payment Wallets</h2>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-[var(--border-color)] text-[var(--text-secondary)]">
                                        <th class="text-left py-3 px-2">Coin</th>
                                        <th class="text-left py-3 px-2">Network</th>
                                        <th class="text-left py-3 px-2">Address</th>
                                        <th class="text-left py-3 px-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($wallets) > 0): ?>
                                        <?php while ($w = mysqli_fetch_assoc($wallets)): ?>
                                            <tr
                                                class="border-b border-[var(--border-color)]/30 hover:bg-white/5 transition-colors">
                                                <td class="py-3 px-2 font-bold"><?= htmlspecialchars($w['coin']) ?></td>
                                                <td class="py-3 px-2 text-[var(--text-secondary)]">
                                                    <?= htmlspecialchars($w['network'] ?? '-') ?>
                                                </td>
                                                <td class="py-3 px-2">
                                                    <code
                                                        class="bg-black/30 px-2 py-1 rounded text-xs break-all"><?= htmlspecialchars($w['address']) ?></code>
                                                </td>
                                                <td class="py-3 px-2">
                                                    <div class="flex items-center gap-2">
                                                        <button
                                                            onclick="openWalletEditModal(<?= htmlspecialchars(json_encode($w)) ?>)"
                                                            class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-lg text-xs font-bold hover:bg-blue-500/30 transition-colors">Edit</button>
                                                        <a href="?delete_wallet=<?= $w['id'] ?>"
                                                            onclick="return confirm('Delete this wallet?')"
                                                            class="bg-red-500/20 text-red-400 px-3 py-1 rounded-lg text-xs font-bold hover:bg-red-500/30 transition-colors">Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="py-8 text-center text-[var(--text-secondary)]">No payment
                                                wallets configured. Add one above.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Edit Wallet Modal -->
    <div id="walletEditModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm hidden">
        <div class="card w-full max-w-lg mx-4 relative">
            <button onclick="closeWalletEditModal()"
                class="absolute top-4 right-4 text-[var(--text-secondary)] hover:text-white text-xl">&times;</button>
            <h2 class="text-lg font-bold mb-4">Edit Wallet</h2>
            <form method="post">
                <input type="hidden" name="wallet_id" id="edit_wallet_id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="flex flex-col space-y-2">
                        <label class="font-semibold text-sm text-[var(--text-secondary)]">Coin</label>
                        <input type="text" name="coin" id="edit_wallet_coin" class="input" required>
                    </div>
                    <div class="flex flex-col space-y-2">
                        <label class="font-semibold text-sm text-[var(--text-secondary)]">Network</label>
                        <input type="text" name="network" id="edit_wallet_network" class="input">
                    </div>
                </div>
                <div class="flex flex-col space-y-2 mb-4">
                    <label class="font-semibold text-sm text-[var(--text-secondary)]">Wallet Address</label>
                    <input type="text" name="address" id="edit_wallet_address" class="input" required>
                </div>
                <button class="button_primary" name="edit_wallet" type="submit">Update Wallet</button>
            </form>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm hidden">
        <div class="card w-full max-w-lg mx-4 relative">
            <button onclick="closeEditModal()"
                class="absolute top-4 right-4 text-[var(--text-secondary)] hover:text-white text-xl">&times;</button>
            <h2 class="text-lg font-bold mb-4">Edit Product</h2>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="product_id" id="edit_id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="flex flex-col space-y-2">
                        <label class="font-semibold text-sm text-[var(--text-secondary)]">Product Name</label>
                        <input type="text" name="name" id="edit_name" class="input" required>
                    </div>
                    <div class="flex flex-col space-y-2">
                        <label class="font-semibold text-sm text-[var(--text-secondary)]">Capacity</label>
                        <input type="text" name="capacity" id="edit_capacity" class="input" required>
                    </div>
                    <div class="flex flex-col space-y-2">
                        <label class="font-semibold text-sm text-[var(--text-secondary)]">Price (USD)</label>
                        <input type="number" step="0.01" name="price_usd" id="edit_price" class="input" required>
                    </div>
                    <div class="flex flex-col space-y-2">
                        <label class="font-semibold text-sm text-[var(--text-secondary)]">Product Image</label>
                        <div id="edit_current_image" class="mb-2 hidden">
                            <img id="edit_image_preview" src="" class="w-16 h-16 rounded-lg object-cover" alt="">
                            <span class="text-xs text-[var(--text-secondary)] ml-2">Current image (leave empty to
                                keep)</span>
                        </div>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif"
                            class="input file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-green-500/20 file:text-green-400 hover:file:bg-green-500/30">
                    </div>
                </div>
                <div class="flex flex-col space-y-2 mb-4">
                    <label class="font-semibold text-sm text-[var(--text-secondary)]">Description</label>
                    <textarea name="description" id="edit_description" class="input" rows="3"></textarea>
                </div>
                <div class="flex items-center gap-3 mb-4">
                    <input type="checkbox" name="in_stock" id="edit_in_stock" class="w-4 h-4 accent-green-500">
                    <label for="edit_in_stock" class="text-sm text-[var(--text-secondary)]">In Stock</label>
                </div>
                <button class="button_primary" name="edit_product" type="submit">Update Product</button>
            </form>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            document.getElementById('section-products').classList.toggle('hidden', tab !== 'products');
            document.getElementById('section-wallets').classList.toggle('hidden', tab !== 'wallets');
            document.getElementById('tab-products').className = tab === 'products'
                ? 'px-5 py-2 rounded-full font-bold text-sm transition-colors duration-200 bg-[var(--primary-color)] text-black'
                : 'px-5 py-2 rounded-full font-bold text-sm transition-colors duration-200 bg-gray-700 text-[var(--text-primary)]';
            document.getElementById('tab-wallets').className = tab === 'wallets'
                ? 'px-5 py-2 rounded-full font-bold text-sm transition-colors duration-200 bg-[var(--primary-color)] text-black'
                : 'px-5 py-2 rounded-full font-bold text-sm transition-colors duration-200 bg-gray-700 text-[var(--text-primary)]';
        }

        function openEditModal(product) {
            document.getElementById('edit_id').value = product.id;
            document.getElementById('edit_name').value = product.name;
            document.getElementById('edit_capacity').value = product.capacity;
            document.getElementById('edit_price').value = product.price_usd;
            document.getElementById('edit_description').value = product.description || '';
            document.getElementById('edit_in_stock').checked = product.in_stock == 1;
            // Show current image preview
            const preview = document.getElementById('edit_current_image');
            const previewImg = document.getElementById('edit_image_preview');
            if (product.image_url) {
                previewImg.src = '../' + product.image_url;
                preview.classList.remove('hidden');
                preview.classList.add('flex', 'items-center');
            } else {
                preview.classList.add('hidden');
                preview.classList.remove('flex', 'items-center');
            }
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function openWalletEditModal(wallet) {
            document.getElementById('edit_wallet_id').value = wallet.id;
            document.getElementById('edit_wallet_coin').value = wallet.coin;
            document.getElementById('edit_wallet_network').value = wallet.network || '';
            document.getElementById('edit_wallet_address').value = wallet.address;
            document.getElementById('walletEditModal').classList.remove('hidden');
        }

        function closeWalletEditModal() {
            document.getElementById('walletEditModal').classList.add('hidden');
        }
    </script>
</body>

</html>