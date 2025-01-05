<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location:http://localhost/projectlibment/app/Model/admin_login.php?pesan=You must login first!");
    exit(); // Pastikan untuk menghentikan eksekusi setelah redirect
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
                    <h1 class="mt-4">Add New Book</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Add data</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Book Details
                        </div>
                        <div class="card-body">
                            <form onsubmit="return validateFile(event)" action="../../../Controller/cr_createbook.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="isbn" class="form-label">ISBN</label>
                                    <input name="isbn" required type="text" class="form-control" id="isbn" maxlength="13" pattern="\d{13}" title="ISBN must be 13 digits">
                                </div>
                                <div class="mb-3">
                                    <label for="image-upload" class="form-label">Book Image</label>
                                    <input type="file" accept="image/png,image/jpeg" required class="form-control" id="image-upload" name="bookImage" onchange="previewImage(event)">
                                    <br>
                                    <img id="image-preview" width='170px' style="display:none;" />
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input name="title" required type="text" class="form-control" id="title">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" required name="description" id="description" cols="30" rows="5"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="genre" class="form-label">Genre</label>
                                    <select name="genre" required class="form-control" id="genre">
                                        <option value="romance">romance</option>
                                        <option value="education">education</option>
                                        <option value="health">health</option>
                                        <option value="technology">technology</option>
                                        <option value="history">history</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="author" class="form-label">Author</label>
                                    <input name="author" required type="text" class="form-control" id="author">
                                </div>
                                <div class="mb-3">
                                    <label for="publisher" class="form-label">Publisher</label>
                                    <input name="publisher" required type="text" class="form-control" id="publisher">
                                </div>
                                <div class="mb-3">
                                    <label for="releasedate" class="form-label">Release Date</label>
                                    <input type="date" required class="form-control" id="releasedate" name="releasedate">
                                </div>
                                <div class="mb-3">
                                    <label for="language" class="form-label">Language</label>
                                    <input name="language" required type="text" class="form-control" id="language">
                                </div>
                                <div class="mb-3">
                                    <label for="pages" class="form-label">Pages</label>
                                    <input name="pages" required type="number" class="form-control" id="pages" maxlength="3" min="1" max="500">
                                </div>
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stock</label>
                                    <input name="stock" maxlength="3" required type="number" class="form-control" id="stock" min="1" max="100">
                                </div>
                                <div class="mb-3">
                                    <label for="rentprice" class="form-label">Rent Price</label>
                                    <input name="rentprice" required type="number" class="form-control" id="rentprice" min="1000" max="50000" maxlength="5" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="counter" class="form-label">Counter</label>
                                    <input type="number" name="counter" value="0" class="form-control" id="counter" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="staffID" class="form-label">Staff ID</label>
                                    <input type="text" name="staffID" value="<?php echo htmlspecialchars($staffID); ?>" class="form-control" id="staffID" readonly>
                                </div>
                                <center>
                                    <button type="submit" class="btn btn-success">Add Book</button>
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
                imagePreview.style.display = 'block'; // Menampilkan gambar
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>