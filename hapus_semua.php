<?php
include 'config.php';

$conn->query("DELETE FROM transaksi_zakat");

header("Location: history.php");
exit;
?>
