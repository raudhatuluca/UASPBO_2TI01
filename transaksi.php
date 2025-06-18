<?php
include 'config.php';
$hargaList = $conn->query("SELECT * FROM data_beras ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Transaksi Zakat</title>
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <header>Form Transaksi Zakat</header>
  <div class="container">
    <form id="formZakat">
      <div class="form-group">
        <label for="tanggalTransaksi">Tanggal Transaksi</label>
        <input type="date" id="tanggalTransaksi" required />
      </div>
      <div class="form-group">
        <label for="namaLengkap">Nama Lengkap</label>
        <input type="text" id="namaLengkap" required />
      </div>
      <div class="form-group">
        <label for="alamatLengkap">Alamat Lengkap</label>
        <textarea id="alamatLengkap" rows="3" required></textarea>
      </div>
      <div class="form-group">
        <label for="jumlahJiwa">Jumlah Jiwa</label>
        <input type="number" id="jumlahJiwa" min="1" value="1" required />
      </div>
      <div class="form-group">
        <label for="jenisZakat">Jenis Zakat</label>
        <select id="jenisZakat" required>
          <option value="">-- Pilih Jenis Zakat --</option>
          <option value="Beras">Beras</option>
          <option value="Uang">Uang</option>
        </select>
      </div>
      <div class="form-group">
        <label for="hargaBerasDropdown">Harga Beras/Kg</label>
        <select id="hargaBerasDropdown" required>
          <option value="">-- Pilih Harga Beras/Kg --</option>
          <?php $i = 1; while ($row = $hargaList->fetch_assoc()): ?>
            <option value="<?= $row['harga'] ?>">List <?= $i ?> - Rp <?= number_format($row['harga'], 0, ',', '.') ?></option>
          <?php $i++; endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="totalBayar">Total Bayar (Rp)</label>
        <input type="text" id="totalBayar" readonly />
      </div>
      <div class="form-group">
        <label for="nominalBayar">Nominal Dibayarkan (Rp)</label>
        <input type="number" id="nominalBayar" required />
      </div>
      <div class="form-group">
        <label for="kembalian">Kembalian (Rp)</label>
        <input type="text" id="kembalian" readonly />
      </div>
      <div class="form-group">
        <label for="metodePembayaran">Metode Pembayaran</label>
        <select id="metodePembayaran" required>
          <option value="tunai">Tunai</option>
          <option value="qris">QRIS</option>
        </select>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn">Simpan Transaksi</button>
        <button type="button" class="btn" onclick="window.location.href='index.php'">Kembali</button>
      </div>
    </form>
  </div>

  <script>
    const form = document.getElementById('formZakat');

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      const tanggal = document.getElementById('tanggalTransaksi').value;
      const nama = document.getElementById('namaLengkap').value;
      const alamat = document.getElementById('alamatLengkap').value;
      const jiwa = parseInt(document.getElementById('jumlahJiwa').value);
      const jenis = document.getElementById('jenisZakat').value;
      const hargaBeras = parseInt(document.getElementById('hargaBerasDropdown').value);
      const totalBayar = Math.round(2.5 * hargaBeras * jiwa);
      const nominalBayar = parseInt(document.getElementById('nominalBayar').value);
      const kembalian = nominalBayar - totalBayar;
      const metode = document.getElementById('metodePembayaran').value;
      const keterangan = jenis === 'Beras'
        ? `Zakat Fitrah Beras (${(2.5 * jiwa).toFixed(1)} kg)`
        : `Zakat Fitrah Uang (dihitung dari harga beras)`;

      fetch('simpan_transaksi.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          tanggal,
          nama,
          alamat,
          jiwa,
          jenis,
          harga_beras_satuan: hargaBeras,
          total_bayar: totalBayar,
          nominal_dibayarkan: nominalBayar,
          kembalian,
          metode,
          keterangan
        })
      })
      .then(response => response.json())
      .then(data => {
        alert(data.message);
        if (data.status === 'success') {
          window.location.href = 'index.php';
        }
      })
      .catch(error => {
        alert('Gagal menyimpan data!');
        console.error(error);
      });
    });

    function hitungBayar() {
      const jiwa = parseInt(document.getElementById('jumlahJiwa').value || 0);
      const harga = parseInt(document.getElementById('hargaBerasDropdown').value || 0);
      const bayar = parseInt(document.getElementById('nominalBayar').value || 0);

      const total = Math.round(2.5 * harga * jiwa);
      const kembali = bayar - total;

      document.getElementById('totalBayar').value = total.toLocaleString('id-ID');
      document.getElementById('kembalian').value = `Rp ${kembali.toLocaleString('id-ID')}`;
    }

    document.getElementById('hargaBerasDropdown').addEventListener('input', hitungBayar);
    document.getElementById('jumlahJiwa').addEventListener('input', hitungBayar);
    document.getElementById('nominalBayar').addEventListener('input', hitungBayar);
  </script>
</body>
</html>
