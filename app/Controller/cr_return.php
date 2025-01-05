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
    $transactionID = mysqli_escape_string($con, $_POST['transactionID']);
    $conditions = mysqli_escape_string($con, $_POST['conditions']);
    $fineAmount = isset($_POST['fineAmount']) ? mysqli_escape_string($con, $_POST['fineAmount']) : 0;
    $paid = mysqli_escape_string($con, $_POST['paid']);
    $totalPrice = mysqli_escape_string($con, $_POST['totalPrice']);

    // Panggil prosedur untuk membuat pengembalian
    $sql = "CALL create_return('$transactionID', '$conditions', '$staffID')";

    if (mysqli_query($con, $sql)) {
        // Ambil returnID yang baru saja dibuat
        $returnID = mysqli_fetch_assoc(mysqli_query($con, "SELECT MAX(returnID) AS returnID FROM returns WHERE transactionID = '$transactionID'"))['returnID'];

        // Update status transaksi menjadi 'available'
        $sqlUpdate = "UPDATE transaction SET status = 'available' WHERE transactionID = '$transactionID'";
        mysqli_query($con, $sqlUpdate);

        // Update jumlah stock buku di tabel book
        $sqlBookUpdate = "
            UPDATE book b
            JOIN transactionbook tb ON b.bookID = tb.bookID
            SET b.stock = b.stock + tb.quantity
            WHERE tb.transactionID = '$transactionID'";
        mysqli_query($con, $sqlBookUpdate);

        // Jika kondisi buku adalah 'Bad', tambahkan denda
        if ($conditions === 'Bad') {
            // Masukkan denda baru
            $sqlFine = "CALL create_fine('$returnID', '$fineAmount', '$paid', '$staffID')";
            mysqli_query($con, $sqlFine);

            // Jika tidak dibayar, blokir pengguna
            if ($paid === 'no') {
                $userID = mysqli_fetch_assoc(mysqli_query($con, "SELECT userID FROM transaction WHERE transactionID = '$transactionID'"))['userID'];
                $sqlBlockUser = "UPDATE user SET blockeduser = 'yes' WHERE userID = '$userID'";
                mysqli_query($con, $sqlBlockUser);
            }
        }

        // Update trend
        $sqlTrend = "
            INSERT INTO trend (bookID, counter)
            SELECT tb.bookID, COUNT(*)
            FROM transactionbook tb
            WHERE tb.transactionID = '$transactionID'
            GROUP BY tb.bookID
            ON DUPLICATE KEY UPDATE counter = counter + 1";
        mysqli_query($con, $sqlTrend);

        // Simpan total price ke tabel returns
        $sqlReturnUpdate = "UPDATE returns SET totalprice = '$totalPrice' WHERE transactionID = '$transactionID'";
        mysqli_query($con, $sqlReturnUpdate);

        // Redirect ke invoice
        $_SESSION['transactionID'] = $transactionID; // Simpan transactionID di session untuk invoice
        header("Location: ../Model/admin/return/invoice.php");
    } else {
        throw new Exception("Error returning book: " . mysqli_error($con));
    }
} catch (Exception $e) {
    header("Location: ../Model/admin/return/return.php?error=" . urlencode($e->getMessage()));
} finally {
    // Tutup koneksi
    mysqli_close($con);
}
