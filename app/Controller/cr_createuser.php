<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location:http://localhost/projectlibment/app/Model/admin_login.php?pesan=You must login first!");
    exit();
}

require_once "../../config/koneksi.php";
$con = db_connect();

try {
    // Ambil data dari form
    $name = mysqli_escape_string($con, $_POST['name']);
    $address = mysqli_escape_string($con, $_POST['address']);
    $email = mysqli_escape_string($con, $_POST['email']);
    $phone = mysqli_escape_string($con, $_POST['phone']);
    $blockeduser = mysqli_escape_string($con, $_POST['blockeduser']);
    $staffID = mysqli_escape_string($con, $_POST['staffID']); // Mengambil staffID dari form

    // Call the stored procedure to create a new user
    $sql = "CALL create_user('$name', '$address', '$email', '$phone', '$blockeduser', '$staffID')";

    if (mysqli_query($con, $sql)) {
        header("Location: ../Model/admin/user/user.php?create=User created successfully");
    } else {
        throw new Exception("Error creating user: " . mysqli_error($con));
    }
} catch (Exception $e) {
    header("Location: ../Model/admin/user/user.php?error=" . urlencode($e->getMessage()));
} finally {
    // Tutup koneksi
    mysqli_close($con);
}
