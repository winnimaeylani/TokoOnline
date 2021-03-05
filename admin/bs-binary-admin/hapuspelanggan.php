<?php

$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE id_pelanggan='$_GET[id]'");
$pecah = $ambil->fetch_assoc();

if (isset($_POST['hapus']))
{
	$id_pelanggan = $_POST['id_pelanggan'];
}
$koneksi->query("DELETE FROM pelanggan WHERE id_pelanggan='$_GET[id]'");
echo "<script>alert('Data Pelanggan Terhapus');</script>";
echo "<script>location='index.php?halaman=pelanggan'</script>";
?>