<?php
session_start(); // Memulai session

require_once "../../config/koneksi.php"; // Pastikan path ini sesuai
$con = db_connect();

$names = mysqli_real_escape_string($con, $_POST["names"]);
$password = mysqli_real_escape_string($con, $_POST["password"]);

// Hash password menggunakan MD5
$hashedPassword = md5($password);

// Melakukan validasi terhadap data
if (empty($names)) {
    header("Location: admin_login.php?pesan=Username cannot be empty!");
    exit();
}
if (empty($password)) {
    header("Location: admin_login.php?pesan=Password cannot be empty!");
    exit();
}

// Query untuk mendapatkan data staff
$sql = "SELECT * FROM staff WHERE names = ? AND password = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("ss", $names, $hashedPassword);
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah username ada dan password cocok
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Ambil data staff
    $_SESSION['admin_logged_in'] = true; // Set session
    $_SESSION['names'] = $row['names']; // Simpan nama admin dalam session

    header("Location: admin_dashboard.php"); // Redirect ke dashboard admin
    exit();
} else {
    header("Location: admin_login.php?pesan=Invalid username or password.");
    exit();
}
