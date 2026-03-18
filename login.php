<?php
include_once "config/config.php";
if (isset($_SESSION["cryptup_user"])) {
    echo "<script>location.href = 'dashboard.php'</script>";
}
?>
<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>CryptUP || Login</title>
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
            --gray-900: #1a202c;
            --gray-800: #2d3748;
            --gray-700: #4a5568;
            --gray-600: #718096;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-color);
            color: var(--text-primary);
        }
        .main_container {
            @apply container mx-auto px-4 py-8;
        }
        .card {
            @apply bg-[var(--gray-900)] rounded-2xl p-8 shadow-2xl;
        }
        .button_primary {
            @apply bg-[var(--primary-color)] text-black font-bold rounded-full px-6 py-3 hover:bg-[var(--accent-color)] transition-colors duration-300;
        }
        .button_secondary {
            @apply bg-[var(--gray-700)] text-[var(--text-primary)] font-bold rounded-full px-6 py-3 hover:bg-[var(--gray-600)] transition-colors duration-300;
        }
        .input {
            @apply bg-[var(--gray-800)] text-[var(--text-primary)] border border-[var(--gray-600)] rounded-lg px-4 py-3 w-full focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:border-transparent;
        }
        .typography_h1 {
            @apply text-4xl font-black text-[var(--text-primary)];
        }
        .typography_h2 {
            @apply text-2xl font-semibold text-[var(--text-primary)];
        }
        .typography_body {
            @apply text-base text-[var(--text-secondary)];
        }
    </style>
    <?php include "components/pwa-head.php"; ?>
</head>

<body class="bg-background-color text-text-primary">
    <div class="flex flex-col min-h-screen">
        <?php include "components/nav.php"; ?>

        <main class="main_container flex-grow flex items-center justify-center">
            <div class="grid md:grid-cols-2 gap-16 items-center w-full max-w-6xl">
                <div class="hidden md:flex flex-col items-center justify-center space-y-8">
                    <img alt="Wallet Safety Illustration" class="w-full max-w-md rounded-lg"
                        style="aspect-ratio: 4/3; object-fit: cover;" src="assets/image/wallet.png" />
                    <div class="text-center">
                        <h2 class="typography_h2 mb-2">Your Security is Our Priority</h2>
                        <p class="typography_body">We use state-of-the-art encryption and security protocols to protect
                            your assets.</p>
                    </div>
                </div>
                <div class="card w-full max-w-md mx-auto">
                    <div class="text-center mb-8">
                        <h2 class="typography_h1 mb-2 font-black">Welcome Back</h2>
                        <p class="typography_body">Choose your login method.</p>
                    </div>

                    <!-- Login Option Tabs -->
                    <div class="flex mb-6 bg-[var(--gray-800)] rounded-full p-1">
                        <button type="button" id="tab-regular-login" onclick="switchLoginTab('regular')"
                            class="flex-1 py-2.5 text-sm font-semibold rounded-full transition-colors duration-300 bg-[var(--primary-color)] text-black">
                            Centralized
                        </button>
                        <button type="button" id="tab-decentralized-login" onclick="switchLoginTab('decentralized')"
                            class="flex-1 py-2.5 text-sm font-semibold rounded-full transition-colors duration-300 text-[var(--text-secondary)]">
                            Decentralized
                        </button>
                    </div>

                    <!-- Regular Login Form -->
                    <form method="post" id="form-regular-login" class="space-y-6">
                        <div>
                            <label class="sr-only" for="email">Email</label>
                            <input class="input mb-2" id="email" name="email" autofocus placeholder="Email" required=""
                                type="email" />
                            <a class="text-sm align-end text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:underline"
                                href="forgot.php">Forgot Password</a>
                        </div>
                        <div>
                            <label class="sr-only" for="password">Password</label>
                            <input class="input" id="password" name="password" placeholder="Password" required=""
                                type="password" />
                        </div>
                        <button class="button_primary w-full" name="login" type="submit">Log In</button>
                        <?php
                        if (isset($_POST["login"])) {
                            $email = htmlspecialchars($_POST["email"]);
                            $password = htmlspecialchars($_POST["password"]);

                            $checkUser = mysqli_query($conn, "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$password'");
                            if (mysqli_num_rows($checkUser) > 0) {
                                $user = mysqli_fetch_assoc($checkUser);
                                $_SESSION["cryptup_user"] = $user["id"];
                                echo "<script>alert('Login Successful! ✔️'); location.href = 'dashboard.php'</script>";
                            } else {
                                echo "<script>alert('Login Failed! wrong credentials 🚫'); location.href = 'login.php'</script>";
                            }
                        }
                        ?>
                    </form>

                    <!-- Decentralized Login Form -->
                    <form method="post" id="form-decentralized-login" class="space-y-6" style="display: none;">
                        <div>
                            <label class="sr-only" for="dec_login_code">Decentralized Code</label>
                            <input class="input" id="dec_login_code" name="dec_login_code"
                                placeholder="Decentralized Code" required="" type="text" />
                        </div>
                        <div>
                            <label class="sr-only" for="dec_login_password">Password</label>
                            <input class="input" id="dec_login_password" name="dec_login_password"
                                placeholder="Password" required="" type="password" />
                        </div>
                        <button class="button_primary w-full" name="login_decentralized" type="submit">Log In</button>
                        <?php
                        if (isset($_POST["login_decentralized"])) {
                            $unique_code = htmlspecialchars($_POST["dec_login_code"]);
                            $password = htmlspecialchars($_POST["dec_login_password"]);

                            $checkUser = mysqli_query($conn, "SELECT * FROM `users` WHERE `unique_code` = '$unique_code' AND `password` = '$password'");
                            if (mysqli_num_rows($checkUser) > 0) {
                                $user = mysqli_fetch_assoc($checkUser);
                                $_SESSION["cryptup_user"] = $user["id"];
                                echo "<script>alert('Login Successful! ✔️'); location.href = 'dashboard.php'</script>";
                            } else {
                                echo "<script>alert('Login Failed! wrong credentials 🚫'); location.href = 'login.php'</script>";
                            }
                        }
                        ?>
                    </form>

                    <div class="text-center mt-4">
                        <a class="text-sm text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:underline"
                            href="register.php">Register</a>
                    </div>

                </div>

                <div class="fixed bottom-6 right-6 z-[99999]">
                    <a href="https://cryptup-live-support.onrender.com/" target="_blank" rel="noopener noreferrer">
                        <svg class="w-16 h-16" viewBox="0 0 1024 1024" class="icon" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M114.8 561.9l-0.8 92.6 151.1-92.6h291.3c39.4 0 71.3-32.6 71.3-72.9V206c0-40.3-31.9-72.9-71.3-72.9H114.8c-39.4 0-71.3 32.6-71.3 72.9v283c0 40.3 31.9 72.9 71.3 72.9z"
                                fill="#9ED5E4" />
                            <path
                                d="M114 669.1c-2.5 0-4.9-0.6-7.1-1.9-4.6-2.6-7.4-7.5-7.4-12.7l0.7-79.3C59.8 568.1 29 532.2 29 489V206c0-48.2 38.5-87.4 85.8-87.4h441.5c47.3 0 85.8 39.2 85.8 87.4v283c0 48.2-38.5 87.4-85.8 87.4H269.2l-147.6 90.5c-2.4 1.4-5 2.2-7.6 2.2z m0.8-521.5C83.5 147.6 58 173.8 58 206v283c0 32.2 25.5 58.4 56.9 58.4 3.9 0 7.6 1.5 10.3 4.3 2.7 2.7 4.2 6.5 4.2 10.3l-0.6 66.5 128.8-79c2.3-1.4 4.9-2.1 7.6-2.1h291.3c31.4 0 56.9-26.2 56.9-58.4V206c0-32.2-25.5-58.4-56.9-58.4H114.8z"
                                fill="#154B8B" />
                            <path
                                d="M890.1 773.1l1.1 117.4-195.6-117.4H318.4c-51 0-92.4-41.4-92.4-92.4V322.1c0-51 41.4-92.4 92.4-92.4h571.7c51 0 92.4 41.4 92.4 92.4v358.7c0 50.9-41.3 92.3-92.4 92.3z"
                                fill="#FAFCFC" />
                            <path
                                d="M891.2 905c-2.6 0-5.2-0.7-7.5-2.1L691.6 787.6H318.4c-58.9 0-106.9-47.9-106.9-106.9V322.1c0-58.9 47.9-106.9 106.9-106.9h571.7c58.9 0 106.9 47.9 106.9 106.9v358.7c0 54-40.2 98.7-92.2 105.9l1 103.8c0 5.2-2.7 10.1-7.3 12.7-2.3 1.1-4.8 1.8-7.3 1.8zM318.4 244.2c-42.9 0-77.9 34.9-77.9 77.9v358.7c0 42.9 34.9 77.9 77.9 77.9h377.2c2.6 0 5.2 0.7 7.5 2.1l173.5 104.1-0.8-91.5c0-3.9 1.5-7.6 4.2-10.3 2.7-2.7 6.4-4.3 10.3-4.3 42.9 0 77.9-34.9 77.9-77.9V322.1c0-42.9-34.9-77.9-77.9-77.9H318.4z"
                                fill="#154B8B" />
                            <path d="M376 499.8a47.3 44.8 0 1 0 94.6 0 47.3 44.8 0 1 0-94.6 0Z" fill="#144884" />
                            <path d="M557 499.8a47.3 44.8 0 1 0 94.6 0 47.3 44.8 0 1 0-94.6 0Z" fill="#144884" />
                            <path d="M737.9 499.8a47.3 44.8 0 1 0 94.6 0 47.3 44.8 0 1 0-94.6 0Z" fill="#144884" />
                        </svg>
                    </a>
                </div>

                <script>
                    function switchLoginTab(tab) {
                        const regularForm = document.getElementById('form-regular-login');
                        const decentralizedForm = document.getElementById('form-decentralized-login');
                        const tabRegular = document.getElementById('tab-regular-login');
                        const tabDecentralized = document.getElementById('tab-decentralized-login');

                        if (tab === 'regular') {
                            regularForm.style.display = '';
                            decentralizedForm.style.display = 'none';
                            tabRegular.className = 'flex-1 py-2.5 text-sm font-semibold rounded-full transition-colors duration-300 bg-[var(--primary-color)] text-black';
                            tabDecentralized.className = 'flex-1 py-2.5 text-sm font-semibold rounded-full transition-colors duration-300 text-[var(--text-secondary)]';
                        } else {
                            regularForm.style.display = 'none';
                            decentralizedForm.style.display = '';
                            tabDecentralized.className = 'flex-1 py-2.5 text-sm font-semibold rounded-full transition-colors duration-300 bg-[var(--primary-color)] text-black';
                            tabRegular.className = 'flex-1 py-2.5 text-sm font-semibold rounded-full transition-colors duration-300 text-[var(--text-secondary)]';
                        }
                    }

                    // Keep decentralized tab active after form submission attempt
                    <?php if (isset($_POST["login_decentralized"])): ?>
                        switchLoginTab('decentralized');
                    <?php endif; ?>
                </script>
            </div>
        </main>
    </div>

</body>

</html>