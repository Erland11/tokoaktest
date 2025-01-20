<?php 
include 'header.php';

// Set tanggal default ke tanggal hari ini
$date = date('Y-m-d');

// Inisialisasi variabel tanggal
$date1 = $date; // Default tanggal awal
$date2 = $date; // Default tanggal akhir

if (isset($_POST['submit'])) {
    // Ambil input tanggal dari form
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];
}
?>
<style type="text/css">
    @media print {
        .print {
            display: none;
        }
    }
</style>
<div class="container">
    <h2 style=" width: 100%; border-bottom: 4px solid gray; padding-bottom: 5px;"><b>Laporan Inventory</b></h2>
    <div class="row print">
        <div class="col-md-9">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <table>
                    <tr>
                        <td><input type="date" name="date1" class="form-control" value="<?= htmlspecialchars($date1); ?>"></td>
                        <td>&nbsp; - &nbsp;</td>
                        <td><input type="date" name="date2" class="form-control" value="<?= htmlspecialchars($date2); ?>"></td>
                        <td> &nbsp;</td>
                        <td><input type="submit" name="submit" class="btn btn-primary" value="Tampilkan"></td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="col-md-3">
            <form action="exp_pembatalan.php" method="POST">
                <table>
                    <tr>
                        <td><input type="hidden" name="date1" class="form-control" value="<?= htmlspecialchars($date1); ?>"></td>
                        <td><input type="hidden" name="date2" class="form-control" value="<?= htmlspecialchars($date2); ?>"></td>
                        <td><a href="" onclick="window.print()" class="btn btn-default"><i class="glyphicon glyphicon-print"></i> Cetak</a></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <br>
    <br>
    <table class="table table-striped">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Qty</th>
            <th>Tanggal</th>
        </tr>
        <?php 
        if (isset($_POST['submit'])) {
            // Query data berdasarkan rentang tanggal
            $result = mysqli_query($conn, "SELECT * FROM inventory WHERE tanggal BETWEEN '$date1' AND '$date2'");
            $no = 1;
            $total = 0;

            // Tampilkan data jika ada
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= htmlspecialchars($row['nama']); ?></td>
                    <td><?= htmlspecialchars($row['qty']); ?></td>
                    <td><?= htmlspecialchars($row['tanggal']); ?></td>
                </tr>
                <?php 
                $total += $row['qty'];
                $no++;
            }

            // Jika data ditemukan, tampilkan jumlah total barang
            ?>
            <tr>
                <td colspan="5" class="text-right"><b>Jumlah Barang = <?= $total; ?></b></td>
            </tr>
        <?php } ?>
    </table>
</div>
<br>
<br>
<br>
<br>
<br>
<?php 
include 'footer.php';
?>
