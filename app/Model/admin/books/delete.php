<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location:http://localhost/projectlibment/app/Model/admin_login.php?pesan=You must login first!");
    exit(); // Pastikan untuk menghentikan eksekusi setelah redirect
}

require_once "../../../../config/koneksi.php";
$con = db_connect();

// Get the bookID from the URL query parameter
$bookID = isset($_GET['id']) ? $_GET['id'] : '';
$sql = "SELECT * FROM book WHERE bookID = '$bookID'";
$result = mysqli_query($con, $sql);
$data = mysqli_fetch_assoc($result);
$encode = base64_encode($data["bookimage"]); // Assuming bookimage is stored as BLOB

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
                    <h1 class="mt-4">Delete Confirmation</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Delete data</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Book Details
                        </div>
                        <div class="card-body">
                            <form action="../../../Controller/cr_deletebook.php" method="post">
                                <div class="mb-3">
                                    <label for="bookID" class="form-label">Book ID</label>
                                    <input readonly name="bookID" required value="<?php echo $data["bookID"]; ?>" type="text" class="form-control" id="bookID">
                                </div>
                                <div class="mb-3">
                                    <label for="isbn" class="form-label">ISBN</label>
                                    <input readonly name="isbn" required value="<?php echo $data["isbn"]; ?>" type="text" class="form-control" id="isbn">
                                </div>
                                <div class="mb-3">
                                    <label for="bookImage" class="form-label">Book Image</label>
                                    <br>
                                    <?php echo "<img width='170px' src='data:image/jpeg;base64," . $encode . "' />"; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input readonly name="title" value="<?php echo $data["title"]; ?>" required type="text" class="form-control" id="title">
                                </div>
                                <div class="mb-3">
                                    <label for="author" class="form-label">Author</label>
                                    <input readonly name="author" value="<?php echo $data["author"]; ?>" required type="text" class="form-control" id="author">
                                </div>
                                <div class="mb-3">
                                    <label for="genre" class="form-label">Genre</label>
                                    <input readonly name="genre" value="<?php echo $data["genre"]; ?>" required type="text" class="form-control" id="genre">
                                </div>
                                <div class="mb-3">
                                    <label for="publisher" class="form-label">Publisher</label>
                                    <input readonly name="publisher" value="<?php echo $data["publisher"]; ?>" required type="text" class="form-control" id="publisher">
                                </div>
                                <div class="mb-3">
                                    <label for="releasedate" class="form-label">Release Date</label>
                                    <input readonly type="date" value="<?php echo $data["releasedate"]; ?>" required class="form-control" id="releasedate" name="releasedate">
                                </div>
                                <div class="mb-3">
                                    <label for="language" class="form-label">Language</label>
                                    <input readonly name="language" value="<?php echo $data["language"]; ?>" required type="text" class="form-control" id="language">
                                </div>
                                <div class="mb-3">
                                    <label for="pages" class="form-label">Pages</label>
                                    <input readonly name="pages" required value="<?php echo $data["pages"]; ?>" type="number" class="form-control" id="pages" min="1" max="500">
                                </div>
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stock</label>
                                    <input readonly name="stock" required value="<?php echo $data["stock"]; ?>" type="number" class="form-control" id="stock" min="1" max="100">
                                </div>
                                <div class="mb-3">
                                    <label for="rentprice" class="form-label">Rent Price</label>
                                    <input readonly name="rentprice" required value="<?php echo $data["rentprice"]; ?>" type="number" class="form-control" id="rentprice" min="1000" max="50000" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea readonly class="form-control" required name="description" id="description" cols="30" rows="5"><?php echo $data["description"]; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="counter" class="form-label">Counter</label>
                                    <input readonly name="counter" required value="<?php echo $data['counter']; ?>" type="number" class="form-control" id="counter">
                                </div>
                                <div class="mb-3">
                                    <label for="staffID" class="form-label">Staff ID</label>
                                    <input readonly type="text" name="staffID" value="<?php echo htmlspecialchars($data['staffID']); ?>" class="form-control" id="staffID">
                                </div>
                                <center>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                    <a href="books.php"><button type="button" class="ms-3 btn btn-warning">Cancel</button></a>
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