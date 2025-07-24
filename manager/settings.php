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
    .input {
      @apply w-full bg-[var(--on-surface-color)] text-[var(--text-primary)] border border-[var(--border-color)] rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] transition-shadow;
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
          <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2">Update Profile</h1>
        </div>


        <!-- User Coin Form -->
        <div class="card mb-3">
          <form method="post">
            <?php
            $getAdmin = mysqli_query($conn, "SELECT * FROM `admin`");
            $admin = mysqli_fetch_assoc($getAdmin);
            ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="mb-3 flex flex-col space-y-2">
                <label for="coin" class="font-semibold text-sm">Email</label>
                <input type="email" id="coin" name="email" value="<?= $admin['email'] ?>" class="p-3 input">
              </div>
              <div class="mb-3 flex flex-col space-y-2">
                <label for="aka" class="font-semibold text-sm">Password</label>
                <input type="text" id="aka" name="password" value="<?= $admin['password'] ?>" class="p-3 input">
              </div>
            </div>
            <button class="button_secondary" name="add" type="submit">Update</button>
            <?php
            if (isset($_POST["add"])) {
              $email = htmlspecialchars($_POST["email"]);
              $password = htmlspecialchars($_POST["password"]);

              $send = mysqli_query($conn, "UPDATE `admin` SET `email` = '$email', `password` = '$password'");
              if ($send) {
                echo "<script>alert('Updated Successfully ✔️');location.href = 'settings.php'</script>";
              } else {
                echo "<script>alert('Something went wrong 🚫');</script>";
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