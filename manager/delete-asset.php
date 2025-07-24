<?php
include_once "../config/config.php";
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

$delete = mysqli_query($conn, "DELETE FROM `users_coins` WHERE `id` = '$id'");
if ($delete) {
  echo "<script>location.href = 'users.php'; alert('Deleted!')</script>";
} else {
  echo "<script>location.href = 'users.php'; alert('Something went wrong!')</script>";
}
