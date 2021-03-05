<?php
session_start();
//koneksi ke database
include 'koneksi.php';

//jika tidak ada session pelanggan (blm login)
if (!isset($_SESSION["pelanggan"]) OR empty($_SESSION["pelanggan"])) 
{
	echo "<script>alert('Silahkan login dulu ya bosq');</script>";
	echo "<script>location='login.php';</script>";
	exit();
}
//mendapatkan id pembelian dari url
$idpem = $_GET["id"];
$ambil= $koneksi->query("SELECT * FROM pembelian WHERE id_pembelian='$idpem'");
$detpem = $ambil->fetch_assoc();

//mendapatkan id pelanggan yang beli 
$idpelangganygbeli = $detpem["id_pelanggan"];

//mendapatkan id pelanggan yg login
$idpelangganyglogin = $_SESSION["pelanggan"]["id_pelanggan"];

if ($idpelangganyglogin !== $idpelangganygbeli) 
{
	echo "<script>alert('Oops jangan iseng ya bosq');</script>";
	echo "<script>location='riwayat.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pembayaran</title>
	<link rel="stylesheet" href="admin/bs-binary-admin/assets/css/bootstrap.css">
</head>
<body>

<?php include 'menu.php'; ?>

<div class="container">
	<h2>Konfirmasi Pembayaran</h2>
	<p>Kirim bukti pembayaran anda disini</p>
	<div class="alert alert-info">Total Tagihan Anda <strong>Rp. <?php echo number_format($detpem["total_pembelian"]); ?></strong></div>

	<form method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label>Nama Penyetor</label>
			<input type="text" name="nama" class="form-control">
		</div>
		<div class="form-group">
			<label>Bank</label>
			<input type="text" name="bank" class="form-control">
		</div>
		<div class="form-group">
			<label>Jumlah</label>
			<input type="number" name="jumlah" class="form-control"min="1">
		</div>
		<div class="form-group">
			<label>Foto Bukti</label>
			<input type="file" name="bukti" class="form-control">
			<p class="text-danger">Foto bukti harus JPG dan maksimal 2MB</p>
		</div>
		<button class="btn btn-primary" name="kirim">Kirim</button>
	</form>
</div>

<?php
//jika ada tombol kirim yg ditekan
if (isset ($_POST["kirim"])) 
{
  	//upload foto bukti
  	$namabukti = $_FILES["bukti"]["name"];
  	$lokasibukti = $_FILES["bukti"]["tmp_name"];
  	$namafix = date("YmdHis").$namabukti;
  	move_uploaded_file($lokasibukti, "bukti_pembayaran/$namafix");
  	$nama = $_POST["nama"];
  	$bank = $_POST["bank"];
  	$jumlah = $_POST["jumlah"];
  	$tanggal = date("y-m-d");

  	//simpan pembayaran 
  	$koneksi->query("INSERT INTO pembayaran(id_pembelian,nama,bank,jumlah,tanggal,bukti) VALUES ('$idpem','$nama','$bank','$jumlah','$tanggal','$namafix')");
  	//update data pembelian dari pending ke sudah membayar 
  	$koneksi->query("UPDATE pembelian SET status_pembelian='sudah kirim bukti pembayaran' WHERE id_pembelian='$idpem'");
  	echo "<script>alert('Terimakasih sudah mengirim bukti pembayaran');</script>";
	echo "<script>location='riwayat.php';</script>";
}  
?>

</body>
</html>