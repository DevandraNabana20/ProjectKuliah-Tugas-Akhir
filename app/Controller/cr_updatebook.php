<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location:http://localhost/projectlibment/app/Model/admin_login.php?pesan=You must login first!");
    exit(); // Pastikan untuk menghentikan eksekusi setelah redirect
}

require_once "../../config/koneksi.php";
$con = db_connect();

// Ambil data dari form
$bookID = mysqli_escape_string($con, $_POST['bookID']);
$isbn = mysqli_escape_string($con, $_POST['isbn']);
$title = mysqli_escape_string($con, $_POST['title']);
$author = mysqli_escape_string($con, $_POST['author']);
$genre = mysqli_escape_string($con, $_POST['genre']);
$publisher = mysqli_escape_string($con, $_POST['publisher']);
$releasedate = mysqli_escape_string($con, $_POST['releasedate']);
$language = mysqli_escape_string($con, $_POST['language']);
$pages = mysqli_escape_string($con, $_POST['pages']);
$stock = mysqli_escape_string($con, $_POST['stock']);
$rentprice = mysqli_escape_string($con, $_POST['rentprice']);
$description = mysqli_escape_string($con, $_POST['description']);
$counter = mysqli_escape_string($con, $_POST['counter']);
$staffID = mysqli_escape_string($con, $_POST['staffID']);

// Cek apakah ada gambar baru yang diupload
if (isset($_FILES['bookImage']) && $_FILES['bookImage']['error'] == 0) {
    $bookImage = $_FILES['bookImage']['tmp_name'];
    $bookImageContent = file_get_contents($bookImage);
    $bookImageEncoded = mysqli_real_escape_string($con, $bookImageContent);

    // Update query dengan gambar baru
    $sql = "UPDATE book SET
                isbn='$isbn',
                title='$title',
                author='$author',
                genre='$genre',
                publisher='$publisher',
                releasedate='$releasedate',
                language='$language',
                pages='$pages',
                stock='$stock',
                rentprice='$rentprice',
                description='$description',
                bookimage='$bookImageEncoded',  -- Menggunakan bookimage sesuai dengan nama kolom di database
                counter='$counter',
                staffID='$staffID'
            WHERE bookID='$bookID'";
} else {
    // Update query tanpa mengganti gambar
    $sql = "UPDATE book SET
                isbn='$isbn',
                title='$title',
                author='$author',
                genre='$genre',
                publisher='$publisher',
                releasedate='$releasedate',
                language='$language',
                pages='$pages',
                stock='$stock',
                rentprice='$rentprice',
                description='$description',
                counter='$counter',
                staffID='$staffID'
            WHERE bookID='$bookID'";
}

try {
    // Eksekusi query
    if (mysqli_query($con, $sql)) {
        // Redirect ke halaman buku dengan pesan sukses
        header("Location: ../Model/admin/books/books.php?update=Update Successful");
    } else {
        throw new Exception("Error updating record: " . mysqli_error($con));
    }
} catch (Exception $e) {
    // Redirect ke halaman buku dengan pesan error
    header("Location: ../Model/admin/books/books.php?error=Update Error: " . $e->getMessage());
}

// Tutup koneksi
mysqli_close($con);
