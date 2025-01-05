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
$encode = base64_encode($data["bookimage"]); // Menggunakan bookImage dengan huruf "I" kecil

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
                    <h1 class="mt-4">Update Book Details</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Update data</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Book Details
                        </div>
                        <div class="card-body">
                            <form onsubmit="return validateFile(event)" action="../../../Controller/cr_updatebook.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="bookID" class="form-label">Book ID</label>
                                    <input readonly name="bookID" required value="<?php echo $data["bookID"]; ?>" type="text" class="form-control" id="bookID">
                                </div>
                                <div class="mb-3">
                                    <label for="isbn" class="form-label">ISBN</label>
                                    <input name="isbn" required value="<?php echo $data["isbn"]; ?>" type="text" class="form-control" id="isbn" maxlength="13" pattern="\d{13}" title="ISBN must be 13 digits">
                                </div>
                                <div class="mb-3">
                                    <label for="image-upload" class="form-label">Book Image</label>
                                    <input type="file" accept="image/png,image/jpeg" class="form-control" id="image-upload" name="bookImage" onchange="previewImage(event)">
                                    <br>
                                    <?php if ($data["bookimage"]) { ?>
                                        <img id="image-preview" width='170px' src='data:image/jpeg;base64,<?php echo $encode; ?>' />
                                    <?php } ?>
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input name="title" value="<?php echo $data["title"]; ?>" required type="text" class="form-control" id="title">
                                </div>
                                <div class="mb-3">
                                    <label for="author" class="form-label">Author</label>
                                    <input name="author" value="<?php echo $data["author"]; ?>" required type="text" class="form-control" id="author">
                                </div>
                                <div class="mb-3">
                                    <label for="genre" class="form-label">Genre</label>
                                    <select name="genre" required class="form-control" id="genre">
                                        <option value="romance" <?php echo ($data["genre"] == "romance") ? 'selected' : ''; ?>>Romance</option>
                                        <option value="education" <?php echo ($data["genre"] == "education") ? 'selected' : ''; ?>>Education</option>
                                        <option value="health" <?php echo ($data["genre"] == "health") ? 'selected' : ''; ?>>Health</option>
                                        <option value="technology" <?php echo ($data["genre"] == "technology") ? 'selected' : ''; ?>>Technology</option>
                                        <option value="history" <?php echo ($data["genre"] == "history") ? 'selected' : ''; ?>>History</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="publisher" class="form-label">Publisher</label>
                                    <input name="publisher" value="<?php echo $data["publisher"]; ?>" required type="text" class="form-control" id="publisher">
                                </div>
                                <div class="mb-3">
                                    <label for="releasedate" class="form-label">Release Date</label>
                                    <input type="date" required class="form-control" id="releasedate" name="releasedate" value="<?php echo $data["releasedate"]; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="language" class="form-label">Language</label>
                                    <input name="language" value="<?php echo $data["language"]; ?>" required type="text" class="form-control" id="language">
                                </div>
                                <div class="mb-3">
                                    <label for="pages" class="form-label">Pages</label>
                                    <input name="pages" required value="<?php echo $data["pages"]; ?>" type="number" class="form-control" id="pages" min="1" max="500">
                                </div>
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stock</label>
                                    <input name="stock" required value="<?php echo $data["stock"]; ?>" type="number" class="form-control" id="stock" min="1" max="100">
                                </div>
                                <div class="mb-3">
                                    <label for="rentprice" class="form-label">Rent Price</label>
                                    <input name="rentprice" required value="<?php echo $data["rentprice"]; ?>" type="number" class="form-control" id="rentprice" min="1000" max="50000" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" required name="description" id="description" cols="30" rows="5"><?php echo $data["description"]; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="counter" class="form-label">Counter</label>
                                    <input readonly name="counter" min="0" value="<?php echo $data['counter']; ?>" required type="number" class="form-control" id="counter">
                                </div>
                                <div class="mb-3">
                                    <label for="staffID" class="form-label">Staff ID</label>
                                    <input type="text" name="staffID" value="<?php echo htmlspecialchars($staffID); ?>" class="form-control" id="staffID" readonly>
                                </div>
                                <center>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="books.php" class="btn btn-secondary">Cancel</a>
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
        function previewImage(event) {
            const imagePreview = document.getElementById('image-preview');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>