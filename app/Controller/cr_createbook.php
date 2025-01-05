<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location:http://localhost/projectlibment/app/Model/admin_login.php?pesan=You must login first!");
    exit(); // Pastikan untuk menghentikan eksekusi setelah redirect
}

require_once "../../config/koneksi.php";
$con = db_connect();

// Ambil staffID dari session names
$username = $_SESSION['names'];
$staffdata = mysqli_query($con, "SELECT staffID FROM staff WHERE names = '$username'");
$resultstaffid = mysqli_fetch_assoc($staffdata);
$staffID = $resultstaffid['staffID']; // ambil staff id dari database

// Prepare the call to the stored procedure
$stmt = mysqli_prepare($con, 'CALL create_book(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)');

// Bind the parameters to the call
mysqli_stmt_bind_param($stmt, 'ssssssssiidssi', $isbn, $bookImage, $title, $genre, $author, $publisher, $releasedate, $language, $pages, $stock, $rentprice, $description, $staffID, $counter);

// Set the values of the parameters
$bookImage = file_get_contents($_FILES['bookImage']['tmp_name']);
$isbn = mysqli_escape_string($con, $_POST['isbn']);
$title = mysqli_escape_string($con, $_POST['title']);
$genre = mysqli_escape_string($con, $_POST['genre']);
$author = mysqli_escape_string($con, $_POST['author']);
$publisher = mysqli_escape_string($con, $_POST['publisher']);
$releasedate = mysqli_escape_string($con, $_POST['releasedate']);
$language = mysqli_escape_string($con, $_POST['language']);
$pages = (int)$_POST['pages'];
$stock = (int)$_POST['stock'];
$rentprice = (float)$_POST['rentprice']; // Menggunakan float untuk rentprice
$description = stripslashes(nl2br(mysqli_escape_string($con, $_POST['description']))); // Menggunakan nl2br untuk description
$counter = 0; // Default counter value

try {
    // Melakukan validasi terhadap data
    if (empty($bookImage)) {
        header("Location: ../Model/admin/books/books.php?error=Book image cannot be empty!");
        die();
    }
    if (empty($isbn)) {
        header("Location: ../Model/admin/books/books.php?error=ISBN cannot be empty!");
        die();
    }
    if (empty($title)) {
        header("Location: ../Model/admin/books/books.php?error=Title cannot be empty!");
        die();
    }
    if (empty($genre)) {
        header("Location: ../Model/admin/books/books.php?error=Genre cannot be empty!");
        die();
    }
    if (empty($author)) {
        header("Location: ../Model/admin/books/books.php?error=Author cannot be empty!");
        die();
    }
    if (empty($publisher)) {
        header("Location: ../Model/admin/books/books.php?error=Publisher cannot be empty!");
        die();
    }
    if (empty($releasedate)) {
        header("Location: ../Model/admin/books/books.php?error=Release date cannot be empty!");
        die();
    }
    if (empty($language)) {
        header("Location: ../Model/admin/books/books.php?error=Language cannot be empty!");
        die();
    }
    if ($pages < 1 || $pages > 500) {
        header("Location: ../Model/admin/books/books.php?error=Pages must be between 1 and 500!");
        die();
    }
    if ($stock < 0 || $stock > 100) {
        header("Location: ../Model/admin/books/books.php?error=Stock must be between 0 and 100!");
        die();
    }
    if ($rentprice < 1000 || $rentprice > 50000) {
        header("Location: ../Model/admin/books/books.php?error=Rent price must be between 1000 and 50000!");
        die();
    }
    if (empty($description)) {
        header("Location: ../Model/admin/books/books.php?error=Description cannot be empty!");
        die();
    }

    // Execute the call
    if (mysqli_stmt_execute($stmt)) {
        // Success, redirect the user to a different page
        header('Location: ../Model/admin/books/books.php?create=Create Successful');
        exit;
    } else {
        throw new Exception("Error executing statement");
    }
} catch (Exception $e) {
    // Error, redirect the user to a different page
    header('Location: ../Model/admin/books/books.php?error=Create Error: ' . $e->getMessage());
    exit;
}

// Close the statement
mysqli_stmt_close($stmt);

// Close the connection
mysqli_close($con);
