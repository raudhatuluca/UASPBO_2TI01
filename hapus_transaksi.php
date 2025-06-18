<?php
include 'config.php';

if (isset($_GET['id'])) {
  $id = (int) $_GET['id'];
  $conn->query("DELETE FROM transaksi_zakat WHERE id = $id");
}

header("Location: history.php");
exit;
?>
