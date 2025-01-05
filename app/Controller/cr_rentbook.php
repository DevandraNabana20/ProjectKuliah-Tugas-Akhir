<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location:http://localhost/projectlibment/app/Model/admin_login.php?pesan=You must login first!");
    exit();
}

require_once "../../config/koneksi.php";
$con = db_connect();

// Ambil staffID dari session names
$username = $_SESSION['names'];
$staffdata = mysqli_query($con, "SELECT staffID FROM staff WHERE names = '$username'");
$resultstaffid = mysqli_fetch_assoc($staffdata);
$staffID = $resultstaffid['staffID']; // ambil staff id dari database

try {
    // Ambil data dari form
    $userID = mysqli_escape_string($con, $_POST['userID']);
    $borrowdate = mysqli_escape_string($con, $_POST['borrowdate']);
    $duedate = mysqli_escape_string($con, $_POST['duedate']);

    // Deklarasikan variabel untuk OUT parameter
    $transactionID = '';

    // Panggil prosedur untuk membuat transaksi
    $sql = "CALL create_transaction('$userID', '$borrowdate', '$duedate', '$staffID', @transactionID)";

    if (mysqli_query($con, $sql)) {
        // Ambil transactionID yang baru saja dibuat
        $result = mysqli_query($con, "SELECT @transactionID AS transactionID");
        $row = mysqli_fetch_assoc($result);
        $transactionID = $row['transactionID'];

        // Simpan transactionID di session
        $_SESSION['transactionID'] = $transactionID;

        // Redirect ke select_books.php
        header("Location: ../Model/admin/rent/select_books.php");
        exit(); // Pastikan untuk keluar setelah redirect
    } else {
        throw new Exception("Error creating transaction: " . mysqli_error($con));
    }
} catch (Exception $e) {
    header("Location: ../Model/admin/rent/rent.php?error=" . urlencode($e->getMessage()));
} finally {
    // Tutup koneksi
    mysqli_close($con);
}
