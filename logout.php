<?php
session_start();

//menghancurkan $_SESSION["pelanggan"]
session_destroy();

echo "<script>alert('Anda sudah logout')</script>";
echo "<script>location='index.php';</script>";
?>