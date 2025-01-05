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
                    <h1 class="mt-4">Users</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">User Details</li>
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
                            <i class="fas fa-table me-1"></i>
                            User Data
                        </div>
                        <div style="text-align: left;" class="mt-3 ms-3">
                            <a href="create.php"><button style="font-size: 20px; border-radius: 15px;" class="btn btn-success"><i class="bi bi-plus-lg"></i> Add User</button></a>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead class="table-dark">
                                    <tr>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Blocked User</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require_once "../../../../config/koneksi.php";
                                    $con = db_connect();
                                    $sql = "SELECT * FROM user"; // Pastikan query ini sesuai dengan tabel 'user'
                                    $result = mysqli_query($con, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        // Menampilkan data untuk setiap baris
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>
                        <td>" . htmlspecialchars($row["userID"]) . "</td>
                        <td>" . htmlspecialchars($row["name"]) . "</td>
                        <td>" . htmlspecialchars($row["address"]) . "</td>
                        <td>" . htmlspecialchars($row["email"]) . "</td>
                        <td>" . htmlspecialchars($row["phone"]) . "</td>
                        <td>" . htmlspecialchars($row["blockeduser"]) . "</td>
                        <td>
                        <center>
                        <a href='update.php?id=" . htmlspecialchars($row["userID"]) . "' class='btn btn-warning'><i class='fas fa-edit'></i></a>
                        <a href='delete.php?id=" . htmlspecialchars($row["userID"]) . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\");'><i class='fas fa-trash'></i></a>
                        </center>
                        </td>
                        </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7' class='text-center'>No data found</td></tr>"; // Menampilkan pesan jika tidak ada data
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