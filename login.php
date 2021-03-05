<?php
session_start();
//koneksi ke database
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Pelanggan</title>
	<link rel="stylesheet" type="text/css" href="admin/bs-binary-admin/assets/css/bootstrap.css">
</head>
<body>

<?php include 'menu.php'; ?>

<div class="container">
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Login Pelanggan</h3>
				</div>
				<div class="panel-body">
					<form method="post">
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" name="email">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control" name="password">
						</div>
						<button class="btn btn-primary" name="login">Login</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
//jika ada tombol simpan yang dipencet
if (isset($_POST["login"])) 
{
	$email = $_POST["email"];
	$password = $_POST["password"];
  	//maka akan melakukan kueri untuk cek akun di table pelanggan pada database
  	$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email_pelanggan='$email' 
  		AND password_pelanggan='$password'");
  	//menghitung akun yang terambil 
  	$akunyangcocok = $ambil->num_rows;

  	//jika ada akun yang cocok, maka akan berhasil login
  	if ($akunyangcocok==1) 
  	{
  		//anda berhasil login
  		//mendapatkan akun dalam bentuk array
  		$akun = $ambil->fetch_assoc();
  		//simpan di session pelanggan 
  		$_SESSION["pelanggan"] = $akun; 
  		echo "<script>alert('Anda berhasil login')</script>";
  		echo "<script>location='index.php';</script>";
  	}
  	else
  	{
  		//anda gagal login
  		echo "<script>alert('Anda gagal login, Periksa kembali akun anda');</script>";
  		echo "<script>location='login.php';</script>";
  	}
}  
?>

</body>
</html>