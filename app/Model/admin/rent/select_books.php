<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location:http://localhost/projectlibment/app/Model/admin_login.php?pesan=You must login first!");
    exit();
}

require_once "../../../../config/koneksi.php";
$con = db_connect();

// Ambil transactionID dari session
$transactionID = $_SESSION['transactionID'] ?? null;

if (!$transactionID) {
    header("Location: rent.php?error=Transaction ID not found");
    exit();
}

// Ambil daftar buku yang tersedia
$sql = "SELECT * FROM book WHERE stock > 0"; // Hanya ambil buku yang tersedia
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../../include/header.php'; ?>

<body class="sb-nav-fixed">
    <?php include '../../include/navbar.php'; ?>
    <div id="layoutSidenav">
        <?php include '../../include/side.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Select Books to Rent</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Select Books</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-book me-1"></i>
                            Available Books
                        </div>
                        <div class="card-body">
                            <form action="../../../Controller/cr_select_books.php" method="post">
                                <input type="text" readonly name="transactionID" value="<?php echo htmlspecialchars($transactionID); ?>">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Book ID</th>
                                            <th>Title</th>
                                            <th>Stock</th>
                                            <th>Rent Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                            <tr>
                                                <td><input type="checkbox" name="books[]" value="<?php echo htmlspecialchars($row['bookID']); ?>"></td>
                                                <td><?php echo htmlspecialchars($row['bookID']); ?></td>
                                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                                <td><?php echo htmlspecialchars($row['stock']); ?></td>
                                                <td><?php echo htmlspecialchars($row['rentprice']); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                                <center>
                                    <button type="submit" class="btn btn-success">Confirm Rent</button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <?php include '../../include/footer.php'; ?>
        </div>
    </div>
    <?php include '../../include/script.php'; ?>
</body>

</html>