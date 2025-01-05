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
<?php require_once "../../../../config/koneksi.php";
$con = db_connect(); ?>

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
                    <h1 class="mt-4">
                        <?php
                        // Get the bookID from the URL query parameter
                        $bookID = isset($_GET['id']) ? $_GET['id'] : '';
                        $sqlgetname = "SELECT title, releasedate FROM book WHERE bookID = '$bookID'";
                        $result1 = mysqli_query($con, $sqlgetname);
                        $row1 = mysqli_fetch_assoc($result1);
                        if (!empty($row1)) {
                            echo $row1["title"] . " (" . $row1["releasedate"] . ")";
                        } else {
                            echo "";
                        }
                        ?>
                    </h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"></li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Book Details
                        </div>
                        <div class="mt-3">
                            <!-- For update message -->
                            <?php if (!empty($_GET["error"])) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Failed! </strong><?php echo htmlspecialchars($_GET["error"]); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($_GET["update"])) : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success! </strong><?php echo htmlspecialchars($_GET["update"]); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" style="width: 100%;">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Book ID</th>
                                        <th>ISBN</th>
                                        <th>Title</th>
                                        <th>Book Image</th>
                                        <th>Genre</th>
                                        <th>Author</th>
                                        <th>Publisher</th>
                                        <th>Release Date</th>
                                        <th>Description</th> <!-- Menambahkan kolom Description -->
                                        <th>Language</th>
                                        <th>Pages</th> <!-- Menambahkan kolom Pages -->
                                        <th>Stock</th>
                                        <th>Rent Price</th>
                                        <th>Counter</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Select the book with the specified bookID
                                    $sql = "SELECT * FROM book WHERE bookID = '$bookID'";
                                    $result = mysqli_query($con, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        // Output data for the book
                                        $row = mysqli_fetch_assoc($result);
                                        $encode = base64_encode($row["bookimage"]); // Assuming bookimage is a BLOB
                                        $description = htmlspecialchars($row["description"]);
                                        $shortDescription = strlen($description) > 40 ? substr($description, 0, 40) . '...' : $description; // Membatasi deskripsi

                                        echo "<tr>
                    <td>" . htmlspecialchars($row["bookID"]) . "</td>
                    <td>" . htmlspecialchars($row["isbn"]) . "</td>
                    <td>" . htmlspecialchars($row["title"]) . "</td>
                    <td><img width='100px' src='data:image/jpeg;base64," . $encode . "' /></td>
                    <td>" . htmlspecialchars($row["genre"]) . "</td>
                    <td>" . htmlspecialchars($row["author"]) . "</td>
                    <td>" . htmlspecialchars($row["publisher"]) . "</td>
                    <td>" . htmlspecialchars($row["releasedate"]) . "</td>
                    <td>" . $shortDescription . "</td> <!-- Menampilkan Deskripsi -->
                    <td>" . htmlspecialchars($row["language"]) . "</td>
                    <td>" . htmlspecialchars($row["pages"]) . "</td> <!-- Menampilkan Pages -->
                    <td>" . htmlspecialchars($row["stock"]) . "</td>
                    <td>" . htmlspecialchars($row["rentprice"]) . "</td>
                    <td>" . htmlspecialchars($row["counter"]) . "</td>
                    <td><center>
                    <a href='update.php?id=" . htmlspecialchars($row["bookID"]) . "'><i class='fas fa-edit'></i></a>
                    <a href='delete.php?id=" . htmlspecialchars($row["bookID"]) . "'><i class='fas fa-trash'></i></a></center>
                    </td>
                    </tr>";
                                    } else {
                                        echo "<tr><td colspan='14' class='text-center'>No data found</td></tr>"; // Menampilkan pesan jika tidak ada data
                                    }

                                    // Close connection
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
    <script>
        $(document).ready(function() {
            $('#datatablesSimple').dataTable({
                destroy: true,
                paging: false,
                searching: false,
                "scrollX": true,
            });
        });
    </script>
</body>

</html>