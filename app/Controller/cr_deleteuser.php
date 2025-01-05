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
    $userID = mysqli_escape_string($con, $_POST['userID']);
    $staffID = mysqli_escape_string($con, $_POST['staffID']); // Mengambil staffID dari form

    // Hapus user dari database
    $sql = "DELETE FROM user WHERE userID='$userID'";

    if (mysqli_query($con, $sql)) {
        header("Location: ../Model/admin/user/user.php?delete=User deleted successfully");
    } else {
        throw new Exception("Error deleting user: " . mysqli_error($con));
    }
} catch (Exception $e) {
    header("Location: ../Model/admin/user/user.php?error=" . urlencode($e->getMessage()));
} finally {
    // Tutup koneksi
    mysqli_close($con);
}
