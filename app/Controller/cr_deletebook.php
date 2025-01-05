<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location:http://localhost/projectlibment/app/Model/admin_login.php?pesan=You must login first!");
    exit(); // Pastikan untuk menghentikan eksekusi setelah redirect
}

require_once "../../config/koneksi.php";
$con = db_connect();

// Get the bookID from the form data
$bookID = mysqli_escape_string($con, $_POST['bookID']);

try {
    // Delete the book from the database
    $sql = "DELETE FROM book WHERE bookID='$bookID'";
    if (mysqli_query($con, $sql)) {
        // Redirect to the book page with a success message
        header("Location: ../Model/admin/books/books.php?delete=Delete Successful");
    } else {
        throw new Exception("Error deleting record: " . mysqli_error($con));
    }
} catch (Exception $e) {
    // Redirect to the book page with an error message
    header("Location: ../Model/admin/books/books.php?error=Delete Error: " . $e->getMessage());
}

// Close connection
mysqli_close($con);
