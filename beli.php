<?php
session_start();
if (!isset($_SESSION['pelanggan'])) 
{
	echo "<script>alert('Silahkan login terlebih dahulu');</script>";
	echo "<script>location='login.php';</script>";
}
//mendapatkan id produk dari url

$id_produk = $_GET['id']; 

//jika produk dengan id tertentu sudah ada di keranjang, maka produk akan ditambah jumlahnya 
if (isset($_SESSION['keranjang'][$id_produk])) 
{
	$_SESSION['keranjang'][$id_produk] +=1;
}
//jika produk belum ada di keranjang, maka produk itu dianggap dibeli 1 
else
{
	$_SESSION['keranjang'][$id_produk] = 1;
}

//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";

//larikan ke halaman keranjang
echo "<script>alert('Produk telah masuk ke keranjang belanja');</script>";
echo "<script>location='keranjang.php';</script>";

?>