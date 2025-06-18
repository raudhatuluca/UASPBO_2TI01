<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $harga = (int) $_POST['harga'];

  if ($harga > 0) {
    $stmt = $conn->prepare("INSERT INTO data_beras (harga) VALUES (?)");
    $stmt->bind_param("i", $harga);
    if ($stmt->execute()) {
      header("Location: data-beras.php?success=1");
      exit;
    } else {
      echo "Gagal menyimpan data.";
    }
  } else {
    echo "Harga tidak valid.";
  }
}
?>
