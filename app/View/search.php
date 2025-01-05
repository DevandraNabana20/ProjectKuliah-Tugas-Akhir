<?php
include('../../config/koneksi.php');
$con = db_connect();

// Inisialisasi variabel pencarian
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Tentukan jumlah hasil per halaman
$resultsPerPage = 12; // Ubah sesuai kebutuhan
// Hitung total hasil
$sqlCount = "SELECT COUNT(*) as total FROM book WHERE (isbn LIKE '%$searchTerm%'
    OR genre LIKE '%$searchTerm%'
    OR title LIKE '%$searchTerm%'
    OR author LIKE '%$searchTerm%'
    OR releasedate LIKE '%$searchTerm%'
    OR language LIKE '%$searchTerm%'
    OR publisher LIKE '%$searchTerm%')";
$resultCount = mysqli_query($con, $sqlCount);
$rowCount = mysqli_fetch_assoc($resultCount);
$totalResults = $rowCount['total'];

// Hitung total halaman
$totalPages = ceil($totalResults / $resultsPerPage);

// Dapatkan halaman saat ini dari URL, jika tidak ada, set ke 1
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$currentPage = max(1, min($currentPage, $totalPages)); // Pastikan halaman valid

// Hitung offset untuk query
$offset = ($currentPage - 1) * $resultsPerPage;

// SQL untuk mencari buku berdasarkan kolom yang ditentukan dengan pagination
$sqlSearch = "SELECT * FROM book WHERE (isbn LIKE '%$searchTerm%'
    OR genre LIKE '%$searchTerm%'
    OR title LIKE '%$searchTerm%'
    OR author LIKE '%$searchTerm%'
    OR releasedate LIKE '%$searchTerm%'
    OR language LIKE '%$searchTerm%'
    OR publisher LIKE '%$searchTerm%')
    ORDER BY bookID DESC
    LIMIT $offset, $resultsPerPage";

$resultSearch = mysqli_query($con, $sqlSearch);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Search Results</title>
    <link rel="icon" href="assets/libmentlogo.ico" type="image/x-icon">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
            /* Memastikan container mengisi ruang yang tersedia */
        }

        .navbar.navbar-expand-lg {
            background-color: #0142a8 !important;
        }

        .card {
            position: relative;
            margin-bottom: 65px;
        }

        .card-img-top {
            object-fit: fill;
            width: 100%;
            height: 250px;

        }


        .hover-info {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 1.2rem;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 1rem;
            border-radius: 10px;
            z-index: 1;
        }

        .card:hover .card-img-top {
            opacity: 0.5;
        }

        .card:hover .hover-info {
            display: block;
        }

        footer {
            background-color: #6c757d;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: 3rem;
            /* Jarak antara footer dan konten di atasnya */
        }

        .no-results {
            text-align: center;
            margin-top: 2rem;
            font-size: 3rem;
            color: #6c757d;
            margin-bottom: 20rem;
        }

        /* Responsif untuk tampilan mobile */
        @media (max-width: 760px) {
            .no-results {
                font-size: 2rem;
                /* Ukuran font lebih kecil di mobile */
            }
        }
    </style>
</head>

<body>

    <!-- navbar -->
    <section>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container d-flex justify-content-between">
                <a class="navbar-brand" href="allbook.php"><img src="assets/booklogo.png" width="60" alt="libment logo"></a>
                <span style="font-family: 'Poppins', sans-serif; font-size:2rem;" class="fw-bold text-white">LibMent</span>
                <div class="d-flex">
                    <div class="navbar-nav text-center">
                        <a class="nav-link text-white" href="allbook.php"><button class="btn btn-primary shadow fw-bold">Home</button></a>
                    </div>
                </div>
            </div>
        </nav>
    </section>

    <!-- jarak dari navbar -->
    <section style="height: 2rem;"></section>

    <!-- Search Results Section -->
    <section>
        <div class="container">
            <h3 class="fw-bold text-center mt-4 mb-3">Search Results for "<?php echo htmlspecialchars($searchTerm); ?>"</h3>
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4">
                <?php
                // Memeriksa apakah query berhasil
                if ($resultSearch) {
                    // Mengambil dan menampilkan hasil
                    if (mysqli_num_rows($resultSearch) > 0) {
                        while ($book = mysqli_fetch_assoc($resultSearch)) {
                            // Mengambil data yang diperlukan
                            $bookID = $book['bookID'];
                            $title = $book['title'];
                            $author = $book['author'];
                            $bookImage = 'data:image/jpeg;base64,' . base64_encode($book['bookimage']); // Mengonversi gambar dari BLOB ke base64
                            $rentPrice = $book['rentprice'];
                ?>
                            <div class="col">
                                <div class="card h-100">
                                    <img src="<?php echo $bookImage; ?>" class="card-img-top" alt="<?php echo $title; ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $title; ?></h5>
                                        <p class="card-text"><?php echo $author; ?></p>
                                        <div class="hover-info">
                                            <a href="bookdetail.php?id=<?php echo $bookID; ?>" class="btn btn-primary">Book Detail</a>
                                            <p class="mt-2">Rent: Rp<?php echo number_format($rentPrice); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php
                        }
                    } else {
                        // Menampilkan pesan jika tidak ada hasil
                        echo '<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"><div class="no-results">No results found for your search.</div></div>';
                    }
                } else {
                    // Menampilkan pesan error jika query gagal
                    echo "Error: " . mysqli_error($con);
                }
                ?>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mt-4">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $currentPage - 1; ?>">Previous</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                            <a class="page-link" href="?search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $currentPage + 1; ?>">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </section>

    <!-- footer -->
    <footer>
        <p class="mb-0">Copyright &copy; 2024 LibMent</p>
        <p class="mb-0">Developed by <a href="https://github.com/Devandranabana20" class="text-decoration-none text-light">Devandra Nabana</a></p>
    </footer>

    <!-- script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/4422c44224.js" crossorigin="anonymous"></script>

</body>

</html>

<?php
// Menutup koneksi
mysqli_close($con);
?>