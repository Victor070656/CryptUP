<?php
include_once "../config/config.php";
include_once "../config/functions.php";
if (!isset($_SESSION["cryptup_admin"])) {
  echo "<script>location.href = 'login.php'</script>";
}

if (!empty($_GET["id"])) {
  $id = $_GET["id"];
} else {
  echo "<script>location.href = 'users.php'</script>";
}

$getUserCoin = mysqli_query($conn, "SELECT * FROM `users_coins` WHERE `id` = '$id'");
if (mysqli_num_rows($getUserCoin) == 0) {
  echo "<script>location.href = 'users.php'</script>";
}
$userCoin = mysqli_fetch_assoc($getUserCoin);

$coinData = getCoinMarketCapData() ?? [];
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
          <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2">Update User Coin</h1>
        </div>


        <!-- User Coin Form -->
        <div class="card mb-3">
          <form method="post">
            <h2 class="font-semibold text-xl mb-3">Edit Coin For This User</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

              <div class="mb-3 flex flex-col space-y-2">
                <label for="aka" class="font-semibold text-sm">Coin</label>
                <select name="aka" id="aka" class="p-3 input">
                  <?php
                  if (isset($coinData['data']) && is_array($coinData['data'])):
                    foreach ($coinData['data'] as $coin):
                      ?>
                      <option value="<?= $coin['symbol']; ?>" <?= $userCoin['aka'] == $coin['symbol'] ? "selected" : ""; ?>
                        class="bg-[var(--surface-color)] text-[var(--text-primary)]">
                        <?= strtoupper($coin['name']) . " (" . strtoupper($coin['symbol']) . ")"; ?>
                      </option>
                      <?php
                    endforeach;
                  else:
                    ?>
                    <option value="BTC">Bitcoin (BTC)</option>
                    <?php
                  endif;
                  ?>
                </select>
              </div>
              <div class="mb-3 flex flex-col space-y-2">
                <label for="coin_bal" class="font-semibold text-sm">Coin Balance</label>
                <input type="text" id="coin_bal" name="coin_bal" value="<?= $userCoin['coin_balance']; ?>"
                  placeholder="e.g 0.0123" class="p-3 input">
              </div>
              <div class="mb-3 flex flex-col space-y-2">
                <label for="address" class="font-semibold text-sm">Address</label>
                <input type="text" id="address" name="address" value="<?= $userCoin['address']; ?>"
                  placeholder="your wallet address for this coin" class="p-3 input">
              </div>
            </div>
            <button class="button_secondary" name="add" type="submit">Edit Coin</button>
            <?php
            if (isset($_POST["add"])) {
              // $coin = htmlspecialchars($_POST["coin"]);
              $aka = htmlspecialchars($_POST["aka"]);
              // $price = htmlspecialchars($_POST["price"]);
              // $balance = htmlspecialchars($_POST["balance"]);
              $coin_bal = htmlspecialchars($_POST["coin_bal"]);
              $address = htmlspecialchars($_POST["address"]);

              // check through the coindata array and find the coin that matches the aka
              $coin = '';
              foreach ($coinData['data'] as $data) {
                if (strtoupper($data['symbol']) === strtoupper($aka)) {
                  $coin = $data['name'];
                  break;
                }
              }

              $send = mysqli_query($conn, "UPDATE `users_coins` SET `coin` = '$coin', `aka` = '$aka', `coin_balance` = '$coin_bal', `address` = '$address' WHERE `id` = '$id' ");
              if ($send) {
                echo "<script>alert('Updated Successfully ✔️');location.href = 'users.php'</script>";
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