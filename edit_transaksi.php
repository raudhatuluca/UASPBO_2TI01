<?php
include 'config.php';

$id = (int) $_GET['id'];
$result = $conn->query("SELECT * FROM transaksi_zakat WHERE id = $id");
$data = $result->fetch_assoc();

$hargaBeras = $conn->query("SELECT * FROM data_beras ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Transaksi</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>Edit Transaksi Zakat</header>
  <div class="container">
    <form action="update_transaksi.php" method="POST">
      <input type="hidden" name="id" value="<?= $data['id'] ?>">
      <div class="form-group">
        <label>Tanggal</label>
        <input type="date" name="tanggal" value="<?= $data['tanggal'] ?>" required>
      </div>
      <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
      </div>
      <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat" rows="3" required><?= htmlspecialchars($data['alamat']) ?></textarea>
      </div>
      <div class="form-group">
        <label>Jumlah Jiwa</label>
        <input type="number" name="jiwa" value="<?= $data['jiwa'] ?>" min="1" required>
      </div>
      <div class="form-group">
        <label>Jenis Zakat</label>
        <select name="jenis" required>
          <option value="Beras" <?= $data['jenis'] === 'Beras' ? 'selected' : '' ?>>Beras</option>
          <option value="Uang" <?= $data['jenis'] === 'Uang' ? 'selected' : '' ?>>Uang</option>
        </select>
      </div>
      <div class="form-group">
        <label>Harga Beras/Kg</label>
        <select name="harga_beras_satuan" required>
          <?php $i = 1; while ($row = $hargaBeras->fetch_assoc()): ?>
            <option value="<?= $row['harga'] ?>" <?= $row['harga'] == $data['harga_beras_satuan'] ? 'selected' : '' ?>>
              List <?= $i ?> - Rp <?= number_format($row['harga'], 0, ',', '.') ?>
            </option>
          <?php $i++; endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label>Nominal Dibayarkan</label>
        <input type="number" name="nominal_dibayarkan" value="<?= $data['nominal_dibayarkan'] ?>" required>
      </div>
      <div class="form-group">
        <label>Metode Pembayaran</label>
        <select name="metode">
          <option value="tunai" <?= $data['metode'] === 'tunai' ? 'selected' : '' ?>>Tunai</option>
          <option value="qris" <?= $data['metode'] === 'qris' ? 'selected' : '' ?>>QRIS</option>
        </select>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn">Simpan Perubahan</button>
        <a href="history.php" class="btn">Batal</a>
      </div>
    </form>
  </div>
</body>
</html>
