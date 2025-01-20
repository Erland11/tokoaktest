<?php 
include 'header.php';
$date = date('Y-m-d');

// Inisialisasi variabel tanggal untuk menghindari kesalahan undefined
$date1 = $date2 = $date;

if (isset($_POST['submit'])) {
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
    <h2 style="width: 100%; border-bottom: 4px solid gray; padding-bottom: 5px;"><b>Laporan Penjualan</b></h2>
    <div class="row print">
        <div class="col-md-9">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <table>
                    <tr>
                        <td><input type="date" name="date1" class="form-control" value="<?= htmlspecialchars($date1); ?>"></td>
                        <td>&nbsp; - &nbsp;</td>
                        <td><input type="date" name="date2" class="form-control" value="<?= htmlspecialchars($date2); ?>"></td>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="submit" class="btn btn-primary" value="Tampilkan"></td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="col-md-3">
            <form action="exp_penjualan.php" method="POST">
                <table>
                    <tr>
                        <td><input type="hidden" name="date1" class="form-control" value="<?= htmlspecialchars($date1); ?>"></td>
                        <td><input type="hidden" name="date2" class="form-control" value="<?= htmlspecialchars($date2); ?>"></td>
                        <td><button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-save-file"></i> Export to Excel</button></td>
                        <td>&nbsp;</td>
                        <td><a href="#" onclick="window.print()" class="btn btn-default"><i class="glyphicon glyphicon-print"></i> Cetak</a></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <br><br>

    <table class="table table-striped">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Tanggal</th>
            <th>Qty</th>
        </tr>

        <?php 
        if (isset($_POST['submit'])) {
            // Query untuk menampilkan data berdasarkan filter tanggal
            $query = "SELECT * FROM produksi WHERE terima = 1 AND tanggal BETWEEN '$date1' AND '$date2'";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "<tr><td colspan='4' class='text-center'>Terjadi kesalahan pada query: " . mysqli_error($conn) . "</td></tr>";
            } else {
                $no = 1;
                $total = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= htmlspecialchars($row['nama_produk']); ?></td>
                        <td><?= htmlspecialchars($row['tanggal']); ?></td>
                        <td><?= htmlspecialchars($row['qty']); ?></td>
                    </tr>
                    <?php 
                    $total += $row['qty'];
                    $no++;
                }

                // Menampilkan total
                ?>
                <tr>
                    <td colspan="4" class="text-right"><b>Total Jumlah Terjual = <?= $total; ?></b></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</div>

<?php 
include 'footer.php';
?>
