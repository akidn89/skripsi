<?php
session_start();

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "jnt_pajak");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];
$hashed = hash('sha256', $password);

// Cek ke database
$sql = "SELECT * FROM users WHERE username=? AND password=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $hashed);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['username'] = $username;
    header("Location: dashboard.php");
    exit();
} else {
    echo "<script>alert('Login gagal: Username atau password salah'); window.location.href='login.html';</script>";
}
?>
