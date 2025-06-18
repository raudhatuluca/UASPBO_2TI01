<?php
include 'config.php';

// Ambil semua data transaksi
$result = $conn->query("SELECT * FROM transaksi_zakat ORDER BY tanggal DESC");
$transaksi = [];
$total = 0;

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $transaksi[] = $row;
    $total += $row['total_bayar'];
  }
}

$jumlah = count($transaksi);
$tanggalTerbaru = $jumlah > 0 ? $transaksi[0]['tanggal'] : '-';
$recent = array_slice($transaksi, 0, 5); // Ambil 5 transaksi terbaru
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Pembayaran Zakat</title>
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <header>
    Aplikasi Pembayaran Zakat
  </header>

  <div class="container">
    <!-- Dashboard Stats -->
    <div class="stats">
      <div class="card">Total Pembayaran: Rp <?= number_format($total, 0, ',', '.') ?></div>
      <div class="card">Jumlah Transaksi: <?= $jumlah ?></div>
      <div class="card">Tanggal Terbaru: <?= $tanggalTerbaru ?></div>
    </div>

    <!-- Tabel Transaksi Terbaru -->
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Nama</th>
            <th>Jenis Zakat</th>
            <th>Total Bayar</th>
            <th>Tanggal Bayar</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($recent) > 0): ?>
            <?php foreach ($recent as $r): ?>
              <tr>
                <td><?= htmlspecialchars($r['nama']) ?></td>
                <td><?= htmlspecialchars($r['jenis']) ?></td>
                <td>Rp <?= number_format($r['total_bayar'], 0, ',', '.') ?></td>
                <td><?= $r['tanggal'] ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="4">Belum ada transaksi</td></tr>
          <?php endif; ?>
        </tbody>
      </table>

      <div class="buttons">
        <button class="btn" onclick="window.location.href='transaksi.php'">➕ Tambah Transaksi</button>
        <button class="btn" onclick="window.location.href='history.php'">📜 History Transaksi</button>
        <button class="btn" onclick="window.location.href='data-beras.php'">📦 Data Beras</button>
      </div>
    </div>
  </div>
</body>
</html>
