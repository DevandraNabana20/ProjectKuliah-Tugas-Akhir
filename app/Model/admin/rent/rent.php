<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location:http://localhost/projectlibment/app/Model/admin_login.php?pesan=You must login first!");
    exit();
}

require_once "../../../../config/koneksi.php";
$con = db_connect();

// Ambil daftar pengguna yang tidak diblokir
$sql = "SELECT * FROM user WHERE blockeduser = 'no'";
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
                    <h1 class="mt-4">Rent Book</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Rent Book</li>
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
                            Select User
                        </div>
                        <div class="card-body">
                            <form action="../../../Controller/cr_rentbook.php" method="post">
                                <div class="mb-3">
                                    <label for="userID" class="form-label">Select User</label>
                                    <select name="userID" required class="form-control" id="userID">
                                        <option value="">-- Select User --</option>
                                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                            <option value="<?php echo htmlspecialchars($row['userID']); ?>">
                                                <?php echo htmlspecialchars($row['name']) . ' - ' . htmlspecialchars($row['email']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="borrowdate" class="form-label">Borrow Date</label>
                                    <input type="date" name="borrowdate" required class="form-control" id="borrowdate">
                                </div>
                                <div class="mb-3">
                                    <label for="duedate" class="form-label">Due Date</label>
                                    <input type="date" name="duedate" required class="form-control" id="duedate">
                                </div>
                                <center>
                                    <button type="submit" class="btn btn-success">Rent Book</button>
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