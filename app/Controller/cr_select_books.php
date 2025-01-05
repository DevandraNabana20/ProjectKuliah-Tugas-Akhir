<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location:http://localhost/projectlibment/app/Model/admin_login.php?pesan=You must login first!");
    exit();
}

require_once "../../config/koneksi.php";
require '../../vendor/autoload.php'; // Pastikan ini sesuai dengan lokasi autoload Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$con = db_connect();
// Ambil data dari form
$transactionID = mysqli_escape_string($con, $_POST['transactionID']);
$books = $_POST['books']; // Array of selected book IDs

// Loop through selected books and insert into transactionbook
foreach ($books as $bookID) {
    // Insert into transactionbook
    $sql = "INSERT INTO transactionbook (transactionID, bookID, quantity) VALUES ('$transactionID', '$bookID', 1)";
    if (!mysqli_query($con, $sql)) {
        throw new Exception("Error adding book to transaction: " . mysqli_error($con));
    }

    // Update stock in book table
    $sqlUpdate = "UPDATE book SET stock = stock - 1 WHERE bookID = '$bookID'";
    if (!mysqli_query($con, $sqlUpdate)) {
        throw new Exception("Error updating book stock: " . mysqli_error($con));
    }
}

// Ambil data pengguna dan buku yang dipinjam
$sql1 = "
    SELECT u.name, u.email, t.borrowdate, t.duedate, b.title
    FROM transaction t
    JOIN user u ON t.userID = u.userID
    JOIN transactionbook tb ON t.transactionID = tb.transactionID
    JOIN book b ON tb.bookID = b.bookID
    WHERE t.transactionID = '$transactionID'
";

$result = mysqli_query($con, $sql1);
$userData = [];
$bukuDipinjam = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $userData['name'] = $row['name'];
        $userData['email'] = $row['email'];
        $userData['borrowdate'] = $row['borrowdate'];
        $userData['duedate'] = $row['duedate'];
        $bukuDipinjam[] = $row['title'];
    }
} else {
    echo "No data found for the given transaction ID.";
    exit();
}

// Kirim email pada hari peminjaman dan satu hari sebelum due date
$dueDate = new DateTime($userData['duedate']);
$borrowDate = new DateTime($userData['borrowdate']);
$interval = $borrowDate->diff($dueDate);


if ($borrowDate->format('Y-m-d') || ($interval->days == 1 && $interval->invert == 0)) {
    $mail = new PHPMailer(true);
    try {
        // Konfigurasi server email
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Ganti dengan SMTP server Anda
        $mail->SMTPAuth = true;
        $mail->Username = 'c30109210137@aeu.edu.my'; // Ganti dengan email Anda
        $mail->Password = 'pmdo gdub khaw vevd'; // Ganti dengan App Password yang Anda buat
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Pengaturan email
        $mail->setFrom('t12098189@gmail.com', 'Library Notification'); // Ganti dengan email Anda
        $mail->addAddress($userData['email'], $userData['name']);
        $mail->isHTML(true);
        $mail->Subject = 'Reminder: Return Your Borrowed Books';

        // Buat isi email
        $bookList = !empty($bukuDipinjam) ? implode(", ", $bukuDipinjam) : 'No books found.';
        $mail->Body = "
            <h1>Hi {$userData['name']},</h1>
            <p>This is a reminder that you have borrowed the following books:</p>
            <ul>
                <li>{$bookList}</li>
            </ul>
            <p>Borrow Date: {$userData['borrowdate']}</p>
            <p>Due Date: {$userData['duedate']}</p>
            <p>Please return the books by the due date to avoid any fines.</p>
            <p>Thank you!</p>
        ";

        // Kirim email
        $mail->send();
        header("Location: ../Model/admin/rent/rent.php?create=Books rented successfully");
        $_SESSION['transactionID'] = null;
        exit();
    } catch (Exception $e) {
        header("Location: ../Model/admin/rent/rent.php?error=" . urlencode($e->getMessage()));
        $_SESSION['transactionID'] = null;
        exit(); // Pastikan untuk keluar setelah redirect
    }
} else {
    header("Location: ../Model/admin/rent/rent.php?create=Books rented successfully");
    $_SESSION['transactionID'] = null;
    exit(); // Pastikan untuk keluar setelah redirect
}

// Tutup koneksi
mysqli_close($con);
