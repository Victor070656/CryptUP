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
                            Regular
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