<?php
include_once "config/config.php";
if (!isset($_SESSION["cryptup_user"])) {
    echo "<script>location.href = 'login.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CryptUP || Transactions</title>
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
      --card-background: #1f2937;
        --border-color: #374151;
        --green-accent-light: #10b9811a;
        --green-accent: #10b981;
        --red-accent-light: #ef44441a;
        --red-accent: #ef4444;
        --yellow-accent-light: #f59e0b1a;
        --yellow-accent: #f59e0b;
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

                <div class="layout-content-container flex flex-col max-w-7xl mx-auto flex-1">
                    <div class="flex flex-wrap justify-between items-center gap-4 py-6">
                        <div class="flex flex-col gap-1">
                            <h1 class="typography_h1">Transactions</h1>
                            <p class="typography_body">View your transaction history.</p>
                        </div>
                    </div>
                    <div class="card @container">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="border-b border-[var(--border-color)]">
                                    <tr>
                                        <th class="px-4 py-3 text-sm font-medium text-[var(--text-secondary)]">
                                            Transaction</th>
                                        <th class="px-4 py-3 text-sm font-medium text-[var(--text-secondary)]">Amount
                                        </th>
                                        <th class="px-4 py-3 text-sm font-medium text-[var(--text-secondary)]">Status
                                        </th>
                                        <th class="px-4 py-3 text-sm font-medium text-[var(--text-secondary)]">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $getTransactions = mysqli_query($conn, "SELECT * FROM `transactions` WHERE `user_id` = '$user_id' ORDER BY `id` DESC");
                                    if (mysqli_num_rows($getTransactions) > 0):
                                        while ($transaction = mysqli_fetch_assoc($getTransactions)):
                                            ?>
                                            <tr
                                                class="border-b border-[var(--border-color)] hover:bg-[var(--background-color)]">
                                                <td class="h-[72px] px-4 py-2 text-sm font-medium text-[var(--text-primary)]">
                                                    Sent <?= strtoupper($transaction["coin"]) ?>
                                                    <!-- <div class="text-xs text-[var(--text-secondary)]">To: 0x...4321</div> -->
                                                </td>
                                                <td class="h-[72px] px-4 py-2 text-sm text-[var(--red-accent)] font-medium">
                                                    -<?= $transaction["coin_amount"] ?>         <?= strtoupper($transaction["coin"]) ?>
                                                </td>
                                                <td class="h-[72px] px-4 py-2">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[var(--yellow-accent-light)] text-[var(--yellow-accent)]"><?= strtolower($transaction["status"]) ?></span>
                                                </td>
                                                <td class="h-[72px] px-4 py-2 text-sm text-[var(--text-secondary)]">
                                                    <?= date("d M, Y, h:i", strtotime($transaction["created_at"])) ?>
                                                </td>

                                            </tr>
                                            <?php
                                        endwhile;
                                    else:
                                        ?>
                                        <tr
                                            class='border-b border-[var(--border-color)] hover:bg-[var(--background-color)]'>
                                            <td colspan='4'
                                                class='h-[72px] px-4 py-2 text-sm text-center text-[var(--text-secondary)]'>
                                                No transactions found.</td>
                                        </tr>
                                        <?php
                                    endif;
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


</body>

</html>