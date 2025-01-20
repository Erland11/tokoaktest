<?php 
include 'header.php';
// generate kode material
$kode = mysqli_query($conn, "SELECT kode_produk from produk order by kode_produk desc");
$data = mysqli_fetch_assoc($kode);
$num = substr($data['kode_produk'], 1, 4);
$add = (int) $num + 1;
if(strlen($add) == 1){
	$format = "P000".$add;
}else if(strlen($add) == 2){
	$format = "P00".$add;
}
else if(strlen($add) == 3){
	$format = "P0".$add;
}else{
	$format = "P".$add;
}
?>


<div class="container">
	<h2 style=" width: 100%; border-bottom: 4px solid gray"><b>Tambah Barang</b></h2>

	<form action="proses/tm_produk.php" method="POST" enctype="multipart/form-data">

		<div class="form-group">
			<label for="exampleInputFile">Pilih Gambar </label>
			<input type="file" id="exampleInputFile" name="files">
			<p class="help-block">Pilih Gambar untuk Barang</p>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputEmail1">Kode Barang</label>
					<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Masukkan Nama Barang" disabled value="<?= $format; ?>">
					<input type="hidden" name="kode" class="form-control" id="exampleInputEmail1" placeholder="Masukkan Nama Barang"  value="<?= $format; ?>">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputEmail1">Nama Barang</label>
					<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Masukkan Nama Barang" name="nama">
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputEmail1">Harga</label>
					<input type="number" class="form-control" id="exampleInputEmail1" placeholder="Contoh : 12000" name="harga">
					<p class="help-block">Isi Harga tanpa menggunakan Titik(.) atau Koma (,)</p>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="exampleInputPassword1">Deskripsi</label>
			<textarea name="desk" class="form-control" va>

			</textarea>
		</div>
		<hr>
		<h3 style=" width: 100%; border-bottom: 4px solid gray">BOM Barang</h3>
		<br>
		<div class="row">
			<div class="col-md-6">
				<h4>Daftar Barang yang ada di Gudang/Inventory</h4>
				<table class="table table-striped ">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Kode Barang</th>
							<th scope="col">Nama Barang</th>
						</tr>
					</thead>
					<?php 
					$result2 = mysqli_query($conn, "SELECT * FROM inventory order by kode_bk asc");
					$no2 =1;
					while ($row2 = mysqli_fetch_assoc($result2)) {
						?>
						<tbody>
							<tr>
								<th scope="row"><?= $no2;  ?></th>
								<td><?= $row2['kode_bk']; ?></td>
								<td><?= $row2['nama']; ?></td>
							</tr>
						</tbody>
						<?php 
						$no2++;
					}
					?>
				</table>
			</div>


			<div class="col-md-6">
				<div class="bg-danger" style="padding: 5px;">
				<p style="color: red; font-weight: bold;">NB. Form dibawah tidak harus diisi semua</p>
				<p style="color: red; font-weight: bold;">Kode Barang tidak boleh sama</p>
				</div>
				<br>
				<?php 
				$result3 = mysqli_query($conn, "SELECT * FROM inventory");
				$jml = mysqli_num_rows($result3);
				$no3 = 1	;
				while ($no3 <= $jml) {
					?>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputPassword1">Kode Barang</label>
								<input type="text" name="material[]" class="form-control" placeholder="Masukkan Kode Barang">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label >Kebutuhan Barang</label>
								<input type="text" class="form-control"placeholder="Contoh : 250" name="keb[]">
							</div>
						</div>
					</div>
					<?php 
					$no3++;
				}	
				?>

			</div>
		</div>

				<div class="row">
			
			<div class="col-md-6">
				<button type="submit"  class="btn btn-success btn-block" ><i class="glyphicon glyphicon-plus-sign"></i> Tambah</button>
			</div>	
			<div class="col-md-6">
				<a href="m_produk.php" class="btn btn-danger btn-block">Cancel</a>
			</div>
		</div>

		<br>

	</div>
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