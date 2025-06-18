<?php
include 'config.php';

$result = $conn->query("SELECT * FROM transaksi_zakat ORDER BY tanggal DESC");
$data = [];

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Riwayat Transaksi Zakat</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <header>Riwayat Transaksi Zakat</header>

  <div class="container">
    <div class="button-group-kanan">
      <button class="btn" onclick="window.location.href='index.php'">Kembali</button>
      <button class="btn" onclick="window.location.href='export_excel.php'">Export ke Excel</button>
      <button class="btn" onclick="if(confirm('Yakin hapus semua data?')) window.location.href='hapus_semua.php'">Hapus Semua</button>
    </div>

    <div class="table-container">
      <table>
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Nama</th>
      <th>Alamat</th>
      <th>Jiwa</th>
      <th>Jenis</th>
      <th>Harga Beras</th>
      <th>Total Bayar</th>
      <th>Nominal Bayar</th>
      <th>Kembalian</th>
      <th>Metode</th>
      <th>Keterangan</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data as $i => $row): ?>
    <tr>
      <td><?= $i + 1 ?></td>
      <td><?= $row['tanggal'] ?></td>
      <td><?= htmlspecialchars($row['nama']) ?></td>
      <td><?= htmlspecialchars($row['alamat']) ?></td>
      <td><?= $row['jiwa'] ?></td>
      <td><?= $row['jenis'] ?></td>
      <td>Rp <?= number_format($row['harga_beras_satuan'], 0, ',', '.') ?></td>
      <td>Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
      <td>Rp <?= number_format($row['nominal_dibayarkan'], 0, ',', '.') ?></td>
      <td>Rp <?= number_format($row['kembalian'], 0, ',', '.') ?></td>
      <td><?= $row['metode'] ?></td>
      <td><?= htmlspecialchars($row['keterangan']) ?></td>
      <td>
        <a href="edit_transaksi.php?id=<?= $row['id'] ?>">Edit</a>
        <a href="hapus_transaksi.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin hapus?')" >Hapus</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

    </div>
  </div>
</body>
</html>
