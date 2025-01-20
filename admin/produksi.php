<?php 
include 'header.php';

// Query untuk mengambil data pesanan
$sortage = mysqli_query($conn, "SELECT * FROM produksi WHERE cek = '1'");
$cek_sor = mysqli_num_rows($sortage);

?>

<div class="container">
    <h2 style="width: 100%; border-bottom: 4px solid gray"><b>Daftar Pesanan</b></h2>
    <br>
    <h5 class="bg-success" style="padding: 7px; width: 710px; font-weight: bold;">
        <marquee>Lakukan Reload Setiap Masuk Halaman ini, untuk menghindari terjadinya kesalahan data dan informasi</marquee>
    </h5>
    <a href="produksi.php" class="btn btn-default"><i class="glyphicon glyphicon-refresh"></i> Reload</a>
    <br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Invoice</th>
                <th scope="col">Kode Customer</th>
                <th scope="col">Status</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>

        <?php 
        $result = mysqli_query($conn, "SELECT DISTINCT invoice, kode_customer, status, kode_produk, qty, terima, tolak, cek, tanggal FROM produksi GROUP BY invoice");
        $no = 1;
        $nama_material = []; // Inisialisasi array untuk material

        while ($row = mysqli_fetch_assoc($result)) {
            // Pastikan data dari database ada sebelum diakses
            $kodep = isset($row['kode_produk']) ? $row['kode_produk'] : null;
            $inv = isset($row['invoice']) ? $row['invoice'] : null;
            $tanggal = isset($row['tanggal']) ? $row['tanggal'] : "Tanggal Tidak Diketahui";

            if (!$kodep || !$inv) continue; // Skip jika data tidak lengkap
        ?>

            <tr>
                <td><?= $no; ?></td>
                <td><?= htmlspecialchars($row['invoice']); ?></td>
                <td><?= htmlspecialchars($row['kode_customer']); ?></td>
                <td style="font-weight: bold; color: 
                    <?= $row['terima'] == 1 ? 'green' : ($row['tolak'] == 1 ? 'red' : 'orange'); ?>">
                    <?= $row['terima'] == 1 ? 'Pesanan Diterima (Siap Kirim)' : 
                       ($row['tolak'] == 1 ? 'Pesanan Ditolak' : htmlspecialchars($row['status'])); ?>
                </td>
                <td><?= htmlspecialchars($tanggal); ?></td>
                <td>
                    <?php if ($row['tolak'] == 0 && $row['cek'] == 1 && $row['terima'] == 0) { ?>
                        <a href="inventory.php?cek=0" id="rq" class="btn btn-warning"><i class="glyphicon glyphicon-warning-sign"></i> Request Barang Shortage</a> 
                        <a href="proses/tolak.php?inv=<?= htmlspecialchars($row['invoice']); ?>" class="btn btn-danger" onclick="return confirm('Yakin Ingin Menolak ?')"><i class="glyphicon glyphicon-remove-sign"></i> Tolak</a>
                    <?php } else if ($row['terima'] == 0 && $row['cek'] == 0) { ?>
                        <a href="proses/terima.php?inv=<?= htmlspecialchars($row['invoice']); ?>&kdp=<?= htmlspecialchars($row['kode_produk']); ?>" class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Terima</a> 
                        <a href="proses/tolak.php?inv=<?= htmlspecialchars($row['invoice']); ?>" class="btn btn-danger" onclick="return confirm('Yakin Ingin Menolak ?')"><i class="glyphicon glyphicon-remove-sign"></i> Tolak</a>
                    <?php } ?>

                    <a href="detailorder.php?inv=<?= htmlspecialchars($row['invoice']); ?>&cs=<?= htmlspecialchars($row['kode_customer']); ?>" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-eye-open"></i> Detail Pesanan</a>
                </td>
            </tr>

            <?php
            // Periksa stok barang untuk setiap produk
            $t_bom = mysqli_query($conn, "SELECT * FROM bom_produk WHERE kode_produk = '$kodep'");
            while ($row1 = mysqli_fetch_assoc($t_bom)) {
                $kodebk = $row1['kode_bk'];

                $inventory = mysqli_query($conn, "SELECT * FROM inventory WHERE kode_bk = '$kodebk'");
                $r_inv = mysqli_fetch_assoc($inventory);

                $kebutuhan = $row1['kebutuhan'] ?? 0;
                $qtyorder = $row['qty'] ?? 0;
                $stok_inventory = $r_inv['qty'] ?? 0;

                $bom = ($kebutuhan * $qtyorder);
                $hasil = $stok_inventory - $bom;

                if ($hasil < 0 && $row['tolak'] == 0) {
                    $nama_material[] = $r_inv['nama'] ?? 'Tidak diketahui';
                    mysqli_query($conn, "UPDATE produksi SET cek = '1' WHERE invoice = '$inv'");
                }
            }

            $no++; 
        }
        ?>
        </tbody>
    </table>

    <?php 
    // Tampilkan kekurangan stok jika ada
    if ($cek_sor > 0) {
    ?>
        <br>
        <br>
        <div class="row">
            <div class="col-md-4 bg-danger" style="padding:10px;">
                <h4>Kekurangan Barang </h4>
                <h5 style="color: red;font-weight: bold;">Silahkan Tambah Stok Barang di bawah ini: </h5>
                <table class="table table-striped">
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                    </tr>
                    <?php 
                    $arr = array_values(array_unique($nama_material));
                    for ($i = 0; $i < count($arr); $i++) { 
                    ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($arr[$i]); ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    <?php 
    }
    ?>

</div>

<?php 
include 'footer.php';
?>
