<?php
session_start();
require_once "../../../../config/koneksi.php";
$con = db_connect();

if (isset($_POST['transactionID'])) {
    $transactionID = mysqli_escape_string($con, $_POST['transactionID']);

    // Ambil detail transaksi
    $sql = "
        SELECT
            t.transactionID,
            u.name AS user_name,
            u.email AS user_email,
            t.borrowdate,
            t.duedate,
            b.title AS book_title,
            b.rentprice,
            tb.quantity,
            b.bookimage,
            b.releasedate,
            b.author
        FROM
            transaction t
        JOIN
            user u ON t.userID = u.userID
        JOIN
            transactionbook tb ON t.transactionID = tb.transactionID
        JOIN
            book b ON tb.bookID = b.bookID
        WHERE
            t.transactionID = '$transactionID'
    ";

    $result = mysqli_query($con, $sql);
    $details = '';
    $totalPrice = 0;
    $userDetailsDisplayed = false; // Flag untuk menampilkan detail pengguna hanya sekali

    while ($row = mysqli_fetch_assoc($result)) {
        // Tampilkan detail pengguna hanya sekali
        if (!$userDetailsDisplayed) {
            $details .= '<p><strong>User Name:</strong> ' . htmlspecialchars($row['user_name']) . '</p>';
            $details .= '<p><strong>Email:</strong> ' . htmlspecialchars($row['user_email']) . '</p>';
            $details .= '<p><strong>Borrow Date:</strong> ' . htmlspecialchars($row['borrowdate']) . '</p>';
            $details .= '<p><strong>Due Date:</strong> ' . htmlspecialchars($row['duedate']) . '</p>';
            $details .= '<hr>';
            $userDetailsDisplayed = true; // Set flag ke true setelah menampilkan detail pengguna
        }


        // Format detail buku
        $details .= '<div class="book-detail">';
        $details .= '<img src="data:image/jpeg;base64,' . base64_encode($row['bookimage']) . '" alt="Book Image" style="width:100px;height:auto;">'; // Menampilkan gambar buku
        $details .= '<p><strong>Book Title:</strong> ' . htmlspecialchars($row['book_title']) . ' - ' . htmlspecialchars($row['releasedate']) . ' - ' . htmlspecialchars($row['author']) . '</p>';
        $details .= '<p><strong>Rent Price:</strong> ' . htmlspecialchars($row['rentprice']) . '</p>';
        $details .= '<p><strong>Quantity:</strong> ' . htmlspecialchars($row['quantity']) . '</p>';
        $details .= '<hr>';
        $details .= '</div>';

        // Hitung total price
        $daysBorrowed = (strtotime($row['duedate']) - strtotime($row['borrowdate'])) / (60 * 60 * 24);
        $totalPrice += $daysBorrowed * $row['rentprice'] * $row['quantity'];
    }

    echo json_encode(['details' => $details, 'totalPrice' => $totalPrice]);
}
