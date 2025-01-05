<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location:http://localhost/projectlibment/app/Model/admin_login.php?pesan=You must login first!");
    exit();
}

require_once "../../../../config/koneksi.php";
$con = db_connect();
// Ambil staffID dari session names
$username = $_SESSION['names'];
$staffdata = mysqli_query($con, "SELECT staffID FROM staff WHERE names = '$username'");
$resultstaffid = mysqli_fetch_assoc($staffdata);
$staffID = $resultstaffid['staffID']; // ambil staff id dari database
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
                    <h1 class="mt-4">Add New User</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Add User</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            User Details
                        </div>
                        <div class="card-body">
                            <form action="../../../Controller/cr_createuser.php" method="post">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input name="name" required type="text" class="form-control" id="name">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea name="address" required class="form-control" id="address" cols="30" rows="5"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input name="email" required type="email" class="form-control" id="email">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input name="phone" required type="text" maxlength="13" pattern="\d{13}" class="form-control" id="phone">
                                </div>
                                <div class="mb-3">
                                    <label for="blockeduser" class="form-label">Blocked User</label>
                                    <select name="blockeduser" required class="form-control" id="blockeduser">
                                        <option value="no">No</option>
                                        <option value="yes">Yes</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="staffID" class="form-label">Staff ID</label>
                                    <input type="text" name="staffID" value="<?php echo htmlspecialchars($staffID); ?>" class="form-control" id="staffID" readonly>
                                </div>
                                <center>
                                    <button type="submit" class="btn btn-success">Add User</button>
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