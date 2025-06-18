<?php
// Aktifkan CORS dan header JSON agar bisa dipanggil dari fetch
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

include 'config.php'; // koneksi database

// Ambil data dari JSON
$data = json_decode(file_get_contents("php://input"), true);

// Validasi minimal
if (!$data) {
  echo json_encode(["status" => "error", "message" => "Data tidak ditemukan"]);
  exit;
}

$tanggal = $data['tanggal'];
$nama = $data['nama'];
$alamat = $data['alamat'];
$jiwa = $data['jiwa'];
$jenis = $data['jenis'];
$harga_beras = $data['harga_beras_satuan'];
$total_bayar = $data['total_bayar'];
$nominal_dibayarkan = $data['nominal_dibayarkan'];
$kembalian = $data['kembalian'];
$metode = $data['metode'];
$keterangan = $data['keterangan'];

// Simpan ke database
$stmt = $conn->prepare("INSERT INTO transaksi_zakat (
  tanggal, nama, alamat, jiwa, jenis, harga_beras_satuan, total_bayar, nominal_dibayarkan, kembalian, metode, keterangan
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssisiissss", 
  $tanggal, $nama, $alamat, $jiwa, $jenis, $harga_beras, $total_bayar, $nominal_dibayarkan, $kembalian, $metode, $keterangan
);

if ($stmt->execute()) {
  echo json_encode(["status" => "success", "message" => "Transaksi berhasil disimpan"]);
} else {
  echo json_encode(["status" => "error", "message" => "Gagal menyimpan transaksi"]);
}

$stmt->close();
$conn->close();
?>
