<?php
include 'config.php';

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=riwayat_transaksi.csv");

$output = fopen("php://output", "w");

fputcsv($output, [
  "Tanggal", "Nama", "Alamat", "Jiwa", "Jenis", "Harga Beras", "Total Bayar", "Nominal Bayar",
  "Kembalian", "Metode", "Keterangan"
]);

$result = $conn->query("SELECT * FROM transaksi_zakat");

while ($row = $result->fetch_assoc()) {
  fputcsv($output, [
    $row['tanggal'],
    $row['nama'],
    $row['alamat'],
    $row['jiwa'],
    $row['jenis'],
    $row['harga_beras_satuan'],
    $row['total_bayar'],
    $row['nominal_dibayarkan'],
    $row['kembalian'],
    $row['metode'],
    $row['keterangan']
  ]);
}

fclose($output);
exit;
?>
