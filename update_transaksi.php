<?php
include 'config.php';

$id       = $_POST['id'];
$tanggal  = $_POST['tanggal'];
$nama     = $_POST['nama'];
$alamat   = $_POST['alamat'];
$jiwa     = (int) $_POST['jiwa'];
$jenis    = $_POST['jenis'];
$harga    = (int) $_POST['harga_beras_satuan'];
$nominal  = (int) $_POST['nominal_dibayarkan'];
$total    = 2.5 * $harga * $jiwa;
$kembali  = $nominal - $total;
$metode   = $_POST['metode'];
$keterangan = $jenis === 'Beras' 
  ? "Zakat Fitrah Beras (" . (2.5 * $jiwa) . " kg)"
  : "Zakat Fitrah Uang (dihitung dari harga beras)";

$stmt = $conn->prepare("UPDATE transaksi_zakat SET
  tanggal = ?, nama = ?, alamat = ?, jiwa = ?, jenis = ?, harga_beras_satuan = ?, total_bayar = ?, nominal_dibayarkan = ?, kembalian = ?, metode = ?, keterangan = ?
  WHERE id = ?");
$stmt->bind_param("sssisiissssi", 
  $tanggal, $nama, $alamat, $jiwa, $jenis, $harga, $total, $nominal, $kembali, $metode, $keterangan, $id);
$stmt->execute();

header("Location: history.php");
exit;
?>
