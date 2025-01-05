<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location:http://localhost/projectlibment/app/Model/admin_login.php?pesan=You must login first!");
    exit();
}

require_once "../../../../config/koneksi.php";
$con = db_connect();

// Ambil daftar transaksi yang belum dikembalikan
$sql = "SELECT t.transactionID, u.name, t.borrowdate, t.duedate
        FROM transaction t
        JOIN user u ON t.userID = u.userID
        WHERE t.status = 'borrowed'";
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
                    <h1 class="mt-4">Return Book</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Return Book</li>
                    </ol>
                    <div class="mt-3">
                        <!-- For delete message -->
                        <?php if (!empty($_GET["delete"])) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success! </strong><?php echo htmlspecialchars($_GET["delete"]); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- For error message -->
                        <?php if (!empty($_GET["error"])) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Failed! </strong><?php echo htmlspecialchars($_GET["error"]); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- For create message -->
                        <?php if (!empty($_GET["create"])) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success! </strong><?php echo htmlspecialchars($_GET["create"]); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- For update message -->
                        <?php if (!empty($_GET["update"])) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success! </strong><?php echo htmlspecialchars($_GET["update"]); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-book me-1"></i>
                            Select Transaction to Return
                        </div>
                        <div class="card-body">
                            <form action="../../../Controller/cr_return.php" method="post" id="returnForm">
                                <div class="mb-3">
                                    <label for="transactionID" class="form-label">Select Transaction</label>
                                    <select name="transactionID" required class="form-control" id="transactionID" onchange="fetchTransactionDetails(this.value)">
                                        <option value="">-- Select Transaction --</option>
                                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                            <option value="<?php echo htmlspecialchars($row['transactionID']); ?>">
                                                <?php echo htmlspecialchars($row['transactionID']) . ' - ' . htmlspecialchars($row['name']) . ' (Due: ' . htmlspecialchars($row['duedate']) . ')'; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3" id="transactionDetails" style="display: none;">
                                    <h5>Transaction Details</h5>
                                    <div id="detailsContent"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="conditions" class="form-label">Condition of the Book (If Bad, fines = 300.000)</label>
                                    <select name="conditions" required class="form-control" id="conditions" onchange="toggleFineFields(this.value)">
                                        <option value="Good">Good</option>
                                        <option value="Bad">Bad</option>
                                    </select>
                                </div>
                                <div class="mb-3" id="fineFields" style="display: none;">
                                    <label for="fineAmount" class="form-label">Fine Amount</label>
                                    <input type="text" name="fineAmount" class="form-control" id="fineAmount" value="300000" readonly>
                                    <label for="paid" class="form-label">Paid</label>
                                    <select name="paid" required class="form-control" id="paid">
                                        <option value="no">No</option>
                                        <option value="yes">Yes</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="totalPrice" class="form-label">Total Price</label>
                                    <input type="text" name="totalPrice" class="form-control" id="totalPrice" readonly>
                                </div>
                                <center>
                                    <button type="submit" class="btn btn-success">Return Book</button>
                                    <a href="http://localhost/projectlibment/app/Model/admin/return/return.php" class="btn btn-secondary">Cancel</a>
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

    <script>
        let baseTotalPrice = 0; // Variabel untuk menyimpan total harga dasar

        function fetchTransactionDetails(transactionID) {
            if (transactionID) {
                // Fetch transaction details using AJAX
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'fetch_transaction_details.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (this.status === 200) {
                        const response = JSON.parse(this.responseText);
                        document.getElementById('detailsContent').innerHTML = response.details;
                        baseTotalPrice = response.totalPrice; // Set total price dasar
                        document.getElementById('totalPrice').value = baseTotalPrice; // Set total price
                        document.getElementById('transactionDetails').style.display = 'block';
                    }
                };
                xhr.send('transactionID=' + transactionID);
            } else {
                document.getElementById('transactionDetails').style.display = 'none';
            }
        }

        function updateTotalPrice(condition) {
            const fineAmount = parseFloat(document.getElementById('fineAmount').value);
            let totalPrice = baseTotalPrice; // Mulai dengan total harga dasar

            if (condition === 'Bad') {
                totalPrice += fineAmount; // Tambahkan denda jika kondisi "Bad"
            }

            document.getElementById('totalPrice').value = totalPrice; // Update total price
        }

        function toggleFineFields(condition) {
            const fineFields = document.getElementById('fineFields');
            if (condition === 'Bad') {
                fineFields.style.display = 'block';
                updateTotalPrice(condition); // Update total price saat kondisi diubah
            } else {
                fineFields.style.display = 'none';
                document.getElementById('totalPrice').value = baseTotalPrice; // Reset total price jika kondisi "Good"
            }
        }
    </script>
</body>

</html>