<?php 
include 'header.php';

// Generate kode barang
$kode = mysqli_query($conn, "SELECT kode_bk FROM inventory ORDER BY kode_bk DESC");

if ($kode && mysqli_num_rows($kode) > 0) {
    $data = mysqli_fetch_assoc($kode);
    $num = substr($data['kode_bk'], 1, 4); // Ambil 4 digit terakhir dari kode_bk
    $add = (int)$num + 1; // Tambahkan 1 untuk kode berikutnya
} else {
    // Jika tidak ada data di tabel, mulai dari kode pertama
    $add = 1;
}

// Format kode barang
if (strlen($add) == 1) {
    $format = "M000" . $add;
} elseif (strlen($add) == 2) {
    $format = "M00" . $add;
} elseif (strlen($add) == 3) {
    $format = "M0" . $add;
} else {
    $format = "M" . $add;
}

?>

<div class="container">
    <h2 style="width: 100%; border-bottom: 4px solid gray"><b>Tambah Barang</b></h2>

    <form action="proses/tambah_inv.php" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="kodeBarang">Kode Barang</label>
                    <input type="text" class="form-control" id="kodeBarang" disabled value="<?php echo $format; ?>">
                    <input type="hidden" class="form-control" name="kd_material" value="<?php echo $format; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="namaBarang">Nama Barang</label>
                    <input type="text" class="form-control" id="namaBarang" placeholder="Masukkan Nama Barang" name="nama" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" placeholder="Contoh: 20" min="1" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="satuan">Satuan</label>
                    <input type="text" class="form-control" id="satuan" placeholder="Contoh: Pcs" name="satuan" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" placeholder="Contoh: 1000" min="1" required>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Tambah</button>
        <a href="inventory.php" class="btn btn-danger">Cancel</a>
    </form>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<?php 
include 'footer.php';
?>
