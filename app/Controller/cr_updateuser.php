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
    $name = mysqli_escape_string($con, $_POST['name']);
    $address = mysqli_escape_string($con, $_POST['address']);
    $email = mysqli_escape_string($con, $_POST['email']);
    $phone = mysqli_escape_string($con, $_POST['phone']);
    $blockeduser = mysqli_escape_string($con, $_POST['blockeduser']);
    $staffID = mysqli_escape_string($con, $_POST['staffID']); // Mengambil staffID dari form

    // Update user in database
    $sql = "UPDATE user SET
                name='$name',
                address='$address',
                email='$email',
                phone='$phone',
                blockeduser='$blockeduser',
                staffID='$staffID'  -- Menambahkan staffID ke query
            WHERE userID='$userID'";

    if (mysqli_query($con, $sql)) {
        header("Location: ../Model/admin/user/user.php?update=User updated successfully");
    } else {
        throw new Exception("Error updating user: " . mysqli_error($con));
    }
} catch (Exception $e) {
    header("Location: ../Model/admin/user/user.php?id=$userID&error=" . urlencode($e->getMessage()));
} finally {
    // Tutup koneksi
    mysqli_close($con);
}
