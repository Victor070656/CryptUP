<?php
include_once "../config/config.php";
if (!isset($_SESSION["cryptup_admin"])) {
    echo "<script>location.href = 'login.php'</script>";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CryptUP || Admin Dashboard</title>
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
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2">Users</h1>
                </div>


                <!-- Assets Table -->
                <div class="card">
                    <!-- <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6">Users</h2> -->

                    <!-- Desktop Table View -->
                    <div class="block overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="border-b border-[var(--border-color)]">
                                    <th class="p-3 text-[var(--text-secondary)] font-semibold">Name</th>
                                    <th class="p-3 text-[var(--text-secondary)] font-semibold">Email</th>
                                    <th class="p-3 text-right text-[var(--text-secondary)] font-semibold">Reg. Date</th>
                                    <th class="p-3 text-right text-[var(--text-secondary)] font-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $getUsers = mysqli_query($conn, "SELECT * FROM `users` ORDER BY `id` DESC");
                                if (mysqli_num_rows($getUsers) > 0) {
                                    while ($user = mysqli_fetch_assoc($getUsers)) {
                                        $regDate = date("d/m/Y", strtotime($user['created_at']));
                                        ?>
                                        <tr class="border-b border-[var(--border-color)] hover:bg-white/5 transition-colors">
                                            <td class="p-3">
                                                <p class="font-semibold text-white"><?= $user["name"]; ?></p>
                                            </td>
                                            <td class="p-3 font-medium text-white"><?= $user["email"]; ?></td>
                                            <td class="p-3 text-right font-semibold text-white"><?= $regDate; ?></td>
                                            <td class="p-3 text-right font-semibold text-white">
                                                <a href="view-user.php?id=<?= $user['id']; ?>">👁️</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>


</body>

</html>