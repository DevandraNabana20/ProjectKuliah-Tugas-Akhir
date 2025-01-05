<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location:http://localhost/projectlibment/app/Model/admin_login.php?pesan=You must login first!");
    exit();
}

// Ambil data dari session
$transactionID = $_SESSION['transactionID']; // Ambil transactionID dari session
// Ambil detail transaksi dan denda dari database
require_once "../../../../config/koneksi.php";
$con = db_connect();

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
        f.amount AS fine_amount,
        f.paid AS fine_paid,
        r.totalprice AS total_price,
        r.conditions AS book_condition  -- Ambil kondisi dari tabel returns
    FROM
        transaction t
    JOIN
        user u ON t.userID = u.userID
    JOIN
        transactionbook tb ON t.transactionID = tb.transactionID
    JOIN
        book b ON tb.bookID = b.bookID
    LEFT JOIN
        fine f ON f.returnID = (SELECT MAX(returnID) FROM returns WHERE transactionID = t.transactionID)
    LEFT JOIN
        returns r ON r.transactionID = t.transactionID
    WHERE
        t.transactionID = '$transactionID'
";

$result = mysqli_query($con, $sql);

// Debugging: Cek apakah query berhasil dan ada hasil
if (!$result) {
    die("Query Error: " . mysqli_error($con));
}

if (mysqli_num_rows($result) === 0) {
    die("No data found for transaction ID: " . htmlspecialchars($transactionID));
}

// Ambil data pertama untuk informasi pengguna dan total price
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @media print {
            .no-print {
                display: none;
                /* Sembunyikan elemen dengan kelas no-print saat mencetak */
            }
        }

        hr {
            border: none;
            height: 2px;
            /* Ketebalan garis pemisah */
            background-color: #000;
            /* Warna garis pemisah */
            margin: 20px 0;
            /* Margin atas dan bawah */
        }
    </style>
</head>
<?php include '../../include/header.php'; ?>

<body>
    <div class="container mt-5 text-center">
        <h2>Invoice for Return</h2>
        <p><strong>User Name:</strong> <?php echo htmlspecialchars($row['user_name'] ?? ''); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($row['user_email'] ?? ''); ?></p>
        <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($row['transactionID'] ?? ''); ?></p>
        <p><strong>Borrow Date:</strong> <?php echo htmlspecialchars($row['borrowdate'] ?? ''); ?></p>
        <p><strong>Due Date:</strong> <?php echo htmlspecialchars($row['duedate'] ?? ''); ?></p>

        <!-- Garis Pemisah -->
        <hr>

        <h4>Books Borrowed:</h4>
        <table class="table table-bordered mx-auto" style="width: 80%;">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Rent Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Reset the result pointer to fetch all rows
                mysqli_data_seek($result, 0);
                $total_rent_price = 0;
                while ($book = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($book['book_title'] ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($book['rentprice'] ?? '0') . '</td>';
                    echo '<td>' . htmlspecialchars($book['quantity'] ?? '0') . '</td>';
                    echo '</tr>';
                    $total_rent_price += $book['rentprice'] * $book['quantity'];
                }
                ?>
                <tr>
                    <th>Total</th>
                    <td colspan="2"><?php
                                    $sum = 0;
                                    mysqli_data_seek($result, 0);
                                    while ($book = mysqli_fetch_assoc($result)) {
                                        $date1 = new DateTime($book['borrowdate']);
                                        $date2 = new DateTime($book['duedate']);
                                        $diff = $date2->diff($date1);
                                        $sum += $book['rentprice'] * ($diff->days);
                                    }
                                    echo htmlspecialchars($total_rent_price) . ' * ' . htmlspecialchars($diff->days) . ' Days = ' . htmlspecialchars($sum);
                                    ?></td>
                </tr>
            </tbody>
        </table>

        <?php if ($row['book_condition'] === 'Bad'): ?>
            <hr>
            <p><strong>Fine Amount:</strong> <?php echo htmlspecialchars($row['fine_amount'] ?? '0'); ?></p>
            <p><strong>Fine Paid:</strong> <?php echo htmlspecialchars($row['fine_paid'] ?? 'no'); ?></p>
        <?php endif; ?>

        <p><strong>Total Price:</strong> <?php echo htmlspecialchars($row['total_price'] ?? '0'); ?></p>

        <hr>
        <div class="no-print">
            <button onclick="window.print();" class="btn btn-primary">Print Invoice</button>
            <form action="" method="post" style="display:inline;">
                <input type="hidden" name="reset_session" value="1">
                <button type="submit" class="btn btn-secondary">Back to Dashboard</button>
            </form>
        </div>

        <?php
        // Mengatur session menjadi null jika tombol Back to Dashboard diklik
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_session'])) {
            $_SESSION['transactionID'] = null; // Set session transactionID menjadi null
            header("Location: ../../admin_dashboard.php"); // Redirect ke dashboard
            exit();
        }
        ?>
    </div>
    <br>
    <br>
    <br>
    <br>
</body>

</html>