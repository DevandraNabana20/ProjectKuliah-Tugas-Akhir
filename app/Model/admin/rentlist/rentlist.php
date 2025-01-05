<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location:http://localhost/projectlibment/app/Model/admin_login.php?pesan=You must login first!");
    exit(); // Pastikan untuk menghentikan eksekusi setelah redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
include '../../include/header.php';
?>

<body class="sb-nav-fixed">
    <?php
    include '../../include/navbar.php';
    ?>
    <div id="layoutSidenav">
        <?php
        include '../../include/side.php';
        ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Rent List</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Rent Details</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Rent Data
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>Borrow Date</th>
                                        <th>Due Date</th>
                                        <th>Book Titles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require_once "../../../../config/koneksi.php";
                                    $con = db_connect();
                                    $sql = "
                                    SELECT DISTINCT
                                    t.transactionID,
                                    u.name AS user_name,
                                    u.email as user_email,
                                    t.borrowdate,
                                    t.duedate,
                                    GROUP_CONCAT(b.title SEPARATOR ', ') AS book_titles
                                    FROM
                                        transaction t
                                    JOIN
                                        user u ON t.userID = u.userID
                                    JOIN
                                        transactionbook tb ON t.transactionID = tb.transactionID
                                    JOIN
                                        book b ON tb.bookID = b.bookID
                                    WHERE
                                        t.status = 'borrowed'  -- Pastikan untuk memeriksa status transaksi
                                    GROUP BY
                                        t.transactionID, u.name, t.borrowdate, t.duedate
                                    ORDER BY
                                        t.transactionID DESC;

                                    ";
                                    $result = mysqli_query($con, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        // Menampilkan data untuk setiap baris
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>
                                                <td>" . htmlspecialchars($row["transactionID"]) . "</td>
                                                <td>" . htmlspecialchars($row["user_name"]) . "</td>
                                                <td>" . htmlspecialchars($row["user_email"]) . "</td>
                                                <td>" . htmlspecialchars($row["borrowdate"]) . "</td>
                                                <td>" . htmlspecialchars($row["duedate"]) . "</td>
                                                <td>" . htmlspecialchars($row["book_titles"]) . "</td>
                                            </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>No data found</td></tr>"; // Menampilkan pesan jika tidak ada data
                                    }

                                    // Menutup koneksi
                                    mysqli_close($con);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php
            include '../../include/footer.php';
            ?>
        </div>
    </div>
    <?php
    include '../../include/script.php';
    ?>
</body>

</html>