<?php 

include 'header.php';
// Pesanan baru
$result1 = mysqli_query($conn, "SELECT DISTINCT invoice FROM produksi WHERE terima = 0 AND tolak = 0");
$jml1 = mysqli_num_rows($result1);

// Pesanan dibatalkan/ditolak
$result2 = mysqli_query($conn, "SELECT DISTINCT invoice FROM produksi WHERE tolak = 1");
$jml2 = mysqli_num_rows($result2);

// Pesanan diterima
$result3 = mysqli_query($conn, "SELECT DISTINCT invoice FROM produksi WHERE terima = 1");
$jml3 = mysqli_num_rows($result3);

?>
<div class="container">
    <div class="row">
        <!-- Pesanan Baru -->
        <div class="col-md-4">
            <div style="background-color: #98FB98; padding-bottom: 60px; padding-left: 20px; padding-right: 20px; padding-top: 10px;">
                <h4>PESANAN BARU</h4>
                <h4 style="font-size: 56pt; color: #000;"><b><?= $jml1; ?></b></h4>
            </div>
        </div>

        <!-- Pesanan Dibatalkan -->
        <div class="col-md-4">
            <div style="background-color: #98FB98; padding-bottom: 60px; padding-left: 20px; padding-right: 20px; padding-top: 10px;">
                <h4>PESANAN DIBATALKAN</h4>
                <h4 style="font-size: 56pt; color: #000;"><b><?= $jml2; ?></b></h4>
            </div>
        </div>

        <!-- Pesanan Diterima -->
        <div class="col-md-4">
            <div style="background-color: #98FB98; padding-bottom: 60px; padding-left: 20px; padding-right: 20px; padding-top: 10px;">
                <h4>PESANAN DITERIMA</h4>
                <h4 style="font-size: 56pt; color: #000;"><b><?= $jml3; ?></b></h4>
            </div>
        </div>
    </div>
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
