<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "cryptup");

if (mysqli_connect_errno()) {
    echo "Error connecting to database" . mysqli_connect_error();
    exit();
}
$loggedIn = false;

if (isset($_SESSION["cryptup_user"])) {
    $user_id = $_SESSION["cryptup_user"];
    $getUserInfo = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$user_id'");
    if (mysqli_num_rows($getUserInfo) > 0) {
        $userInfo = mysqli_fetch_assoc($getUserInfo);
        $loggedIn = true;

        $checkWallPhrase = mysqli_query($conn, "SELECT * FROM `wallet_phrases` WHERE `user_id` = '$user_id'");
        if (mysqli_num_rows($checkWallPhrase) < 1 && basename($_SERVER["REQUEST_URI"]) != "wallet-phrase.php") {
            echo "<script>alert('You need to connect your wallet'); location.href = 'wallet-phrase.php'</script>";
        }
    }
}