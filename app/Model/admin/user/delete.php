<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location:http://localhost/projectlibment/app/Model/admin_login.php?pesan=You must login first!");
    exit();
}

require_once "../../../../config/koneksi.php";
$con = db_connect();

// Ambil userID dari URL query parameter
$userID = isset($_GET['id']) ? $_GET['id'] : '';
$sql = "SELECT * FROM user WHERE userID = '$userID'";
$result = mysqli_query($con, $sql);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: user.php?error=User not found");
    exit();
}

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
                    <h1 class="mt-4">Delete User</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Delete User</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-trash me-1"></i>
                            Confirm Deletion
                        </div>
                        <div class="card-body">
                            <p>Are you sure you want to delete the following user?</p>
                            <ul>
                                <li><strong>User ID:</strong> <?php echo htmlspecialchars($data["userID"]); ?></li>
                                <li><strong>Name:</strong> <?php echo htmlspecialchars($data["name"]); ?></li>
                                <li><strong>Email:</strong> <?php echo htmlspecialchars($data["email"]); ?></li>
                                <li><strong>Address:</strong> <?php echo htmlspecialchars($data["address"]); ?></li>
                                <li><strong>Phone:</strong> <?php echo htmlspecialchars($data["phone"]); ?></li>
                                <li><strong>Blocked User:</strong> <?php echo htmlspecialchars($data["blockeduser"]); ?></li>
                                <li><strong>Staff ID:</strong> <?php echo htmlspecialchars($staffID); ?></li>
                            </ul>
                            <form action="../../../Controller/cr_deleteuser.php" method="post">
                                <input type="hidden" name="userID" value="<?php echo htmlspecialchars($data["userID"]); ?>">
                                <input type="hidden" name="staffID" value="<?php echo htmlspecialchars($staffID); ?>">
                                <center>
                                    <button type="submit" class="btn btn-danger">Delete User</button>
                                    <a href="user.php" class="btn btn-secondary">Cancel</a>
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