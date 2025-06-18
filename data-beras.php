<?php
include 'config.php';

$result = $conn->query("SELECT * FROM data_beras ORDER BY id DESC");
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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Harga Beras</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <header>Data Harga Beras</header>

  <div class="container">
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Harga Beras/Kg (Rp)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $d): ?>
            <tr>
              <td><?= $d['id'] ?></td>
              <td>Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="buttons">
        <button class="btn" onclick="window.location.href='index.php'">Kembali</button>
        <button class="btn" onclick="document.getElementById('formTambah').style.display='block'">Tambah Data</button>
      </div>
    </div>

    <!-- Form Tambah Harga -->
    <div id="formTambah" class="popup" style="display:none;">
      <div class="popup-content">
        <h3>Tambah Harga Beras</h3>
        <form method="POST" action="simpan_beras.php">
          <input type="number" name="harga" placeholder="Contoh: 13000" required>
          <br><br>
          <button type="submit" class="btn">Simpan</button>
          <button type="button" class="btn" onclick="document.getElementById('formTambah').style.display='none'">Batal</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
