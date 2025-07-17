<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Stitch Design</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
                        <p class="typography_body">Securely log in to your wallet.</p>
                    </div>
                    <form class="space-y-6">
                        <div>
                            <label class="sr-only" for="email">Email</label>
                            <input class="input" id="email" placeholder="Email" required="" type="email" />
                        </div>
                        <div>
                            <label class="sr-only" for="password">Password</label>
                            <input class="input" id="password" placeholder="Password" required="" type="password" />
                        </div>
                        <button class="button_primary w-full" type="submit">Log In</button>
                    </form>
                    <div class="text-center mt-4">
                        <a class="text-sm text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:underline"
                            href="register.php">Register</a>
                    </div>

                </div>
            </div>
        </main>
    </div>

</body>

</html>