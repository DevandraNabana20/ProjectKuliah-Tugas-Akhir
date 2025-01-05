<!-- koneksi ke database-->
<?php
include('../../config/koneksi.php');
$con = db_connect();
// SQL untuk mengambil buku berdasarkan genre
// SQL Popular Books
$sqlpopular = "SELECT * FROM book ORDER BY counter DESC LIMIT 6";
$resultpopular = mysqli_query($con, $sqlpopular);


// SQL Most Rented Books
$sqlmostrented = "
    SELECT
        b.bookID,
        b.title,
        b.author,
        b.bookimage,
        b.rentprice
    FROM
        trend t
    JOIN
        book b ON t.bookID = b.bookID
    ORDER BY
        t.counter DESC
    LIMIT 6;
";

$resultmostrented = mysqli_query($con, $sqlmostrented);

// SQL Education Books
$sqleducation = "SELECT * FROM book WHERE genre = 'education' ORDER BY bookID DESC LIMIT 6";
$resulteducation = mysqli_query($con, $sqleducation);

// SQL Romance Books
$sqlromance = "SELECT * FROM book WHERE genre = 'romance' ORDER BY bookID DESC LIMIT 6";
$resultromance = mysqli_query($con, $sqlromance);

// SQL Technology Books
$sqltechnology = "SELECT * FROM book WHERE genre = 'technology' ORDER BY bookID DESC LIMIT 6";
$resulttechnology = mysqli_query($con, $sqltechnology);

// SQL History Books
$sqlhistory = "SELECT * FROM book WHERE genre = 'history' ORDER BY bookID DESC LIMIT 6";
$resulthistory = mysqli_query($con, $sqlhistory);

// SQL Health Books
$sqlhealth = "SELECT * FROM book WHERE genre = 'health' ORDER BY bookID DESC LIMIT 6";
$resulthealth = mysqli_query($con, $sqlhealth);
?>


<!DOCTYPE html>
<html lang="en">

<!-- inline css -->
<style>
    * {
        font-family: 'Poppins', sans-serif;
    }

    .navbar.navbar-expand-lg {
        background-color: #0142a8 !important;
    }

    .card-img-top {
        object-fit: fill;
        width: 100%;
        height: 250px;
        border-radius: 20px 20px 0 0;
    }

    .card {
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-title {
        font-weight: bold;
        font-size: 1.2rem;
    }

    .card-text {
        font-size: 0.9rem;
        color: #6c757d;
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
    }

    .card:hover .card-img-top {
        opacity: 0.5;
    }

    .card:hover .hover-info {
        display: block;
    }

    #go-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 99;
        font-size: 18px;
        border: none;
        outline: none;
        background-color: #0142a8;
        color: white;
        cursor: pointer;
        padding: 15px;
        border-radius: 4px;
        display: none;
    }

    #go-top:hover {
        background-color: #555;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>All Book</title>
    <link rel="icon" href="assets/libmentlogo.ico" type="image/x-icon">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

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
                        <a class="nav-link text-white" href="index.php"><button class="btn btn-primary shadow fw-bold">Home</button></a>
                    </div>
                </div>
            </div>
        </nav>
    </section>

    <!-- jarak dari navbar -->
    <section style="height: 2rem;"></section>

    <!-- carousel -->
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div id="carouselExampleIndicators" class="carousel slide col-12" data-bs-ride="true" data-bs-interval="3000">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1" style="background-color: #0142a8;"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2" style="background-color: #0142a8;"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3" style="background-color: #0142a8;"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="assets/promo1.jpeg" class="d-block w-100 img-fluid" style="width: 100%; border-radius: 20px;" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/promo2.jpg" class="d-block w-100 img-fluid" style="width: 100%; border-radius: 20px;" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/promo1.jpeg" class="d-block w-100 img-fluid" style="width: 100%; border-radius: 20px;" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- search -->
    <section class="mt-3">
        <div class="container p-4">
            <div class="row">
                <form action="search.php" method="GET"> <!-- Mengubah action ke search.php dan menambahkan method GET -->
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input style="color: #0142a8;" type="search" name="search" class="form-control rounded text-center" placeholder="Search book in here!" role="search" aria-label="Search" aria-describedby="search-addon" required />
                            <button type="submit" class="btn btn-outline-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- search -->

    <!-- Most Popular Books -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12"></div>
                <h3 class="fw-bold mt-4 mb-3">Most Popular Books <span><i style="color: #0142a8;" class="animate__animated animate__flash animate__infinite fa-solid fa-fire"></i></span></h3>
            </div>
        </div>
        </div>
    </section>


    <!-- Most Popular Books Card -->
    <section>
        <div class="container">
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4">
                <?php
                // Memeriksa apakah query berhasil
                if ($resultpopular) {
                    // Mengambil dan menampilkan hasil
                    while ($book = mysqli_fetch_assoc($resultpopular)) {
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
                    // Menampilkan pesan error jika query gagal
                    echo "Error: " . mysqli_error($con);
                }
                ?>
            </div>
        </div>
    </section>


    <!-- Most Rented Books -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12"></div>
                <h3 class="fw-bold mt-4 mb-3">Most Rented Books <span><i style="color: #0142a8;" class="animate__animated animate__flash animate__infinite fa-solid fa-window-restore"></i></span></h3>
            </div>
        </div>
        </div>
    </section>


    <!-- Most Rented Books Card -->

    <section>
        <div class="container">
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4">
                <?php
                // Memeriksa apakah query berhasil
                if ($resultmostrented) {
                    // Mengambil dan menampilkan hasil
                    while ($book = mysqli_fetch_assoc($resultmostrented)) {
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
                    // Menampilkan pesan error jika query gagal
                    echo "Error: " . mysqli_error($con);
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Education Books -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12"></div>
                <h3 class="fw-bold mt-4 mb-3">Education Books <span><i style="color: #0142a8;" class="animate__animated animate__flash animate__infinite fa-solid fa-school"></i></span><span class="title float-end"><a href="search.php?search=education"><button class="btn btn-secondary">See
                                more</button></a>
                    </span></h3>
            </div>
        </div>
        </div>
    </section>


    <!-- Education Books Card -->
    <section>
        <div class="container">
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4">
                <?php
                // Memeriksa apakah query berhasil
                if ($resulteducation) {
                    // Mengambil dan menampilkan hasil
                    while ($book = mysqli_fetch_assoc($resulteducation)) {
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
                    // Menampilkan pesan error jika query gagal
                    echo "Error: " . mysqli_error($con);
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Romance Books -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12"></div>
                <h3 class="fw-bold mt-4 mb-3">Romance Books <span><i style="color: #0142a8;" class="animate__animated animate__flash animate__infinite fa-solid fa-heart"></i></span><span class="title float-end"><a href="search.php?search=romance"><button class="btn btn-secondary">See
                                more</button></a>
                    </span></h3>
            </div>
        </div>
        </div>
    </section>


    <!-- Romance Books Card -->

    <section>
        <div class="container">
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4">
                <?php
                // Memeriksa apakah query berhasil
                if ($resultromance) {
                    // Mengambil dan menampilkan hasil
                    while ($book = mysqli_fetch_assoc($resultromance)) {
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
                    // Menampilkan pesan error jika query gagal
                    echo "Error: " . mysqli_error($con);
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Health Books -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12"></div>
                <h3 class="fw-bold mt-4 mb-3">Health Books <span><i style="color: #0142a8;" class="animate__animated animate__flash animate__infinite fa-solid fa-notes-medical"></i></span><span class="title float-end"><a href="search.php?search=health"><button class="btn btn-secondary">See
                                more</button></a>
                    </span></h3>
            </div>
        </div>
        </div>
    </section>


    <!-- Health Books Card -->

    <section>
        <div class="container">
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4">
                <?php
                // Memeriksa apakah query berhasil
                if ($resulthealth) {
                    // Mengambil dan menampilkan hasil
                    while ($book = mysqli_fetch_assoc($resulthealth)) {
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
                    // Menampilkan pesan error jika query gagal
                    echo "Error: " . mysqli_error($con);
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Technology Books -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12"></div>
                <h3 class="fw-bold mt-4 mb-3">Technology Books <span><i style="color: #0142a8;" class="animate__animated animate__flash animate__infinite fa-solid fa-microchip"></i></span><span class="title float-end"><a href="search.php?search=technology"><button class="btn btn-secondary">See
                                more</button></a>
                    </span></h3>
            </div>
        </div>
        </div>
    </section>


    <!-- Technology Books Card -->

    <section>
        <div class="container">
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4">
                <?php
                // Memeriksa apakah query berhasil
                if ($resulttechnology) {
                    // Mengambil dan menampilkan hasil
                    while ($book = mysqli_fetch_assoc($resulttechnology)) {
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
                    // Menampilkan pesan error jika query gagal
                    echo "Error: " . mysqli_error($con);
                }
                ?>
            </div>
        </div>
    </section>

    <!-- History Books -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12"></div>
                <h3 class="fw-bold mt-4 mb-3">History Books <span><i style="color: #0142a8;" class="animate__animated animate__flash animate__infinite fa-solid fa-monument"></i></span><span class="title float-end"><a href="search.php?search=history"><button class="btn btn-secondary">See
                                more</button></a>
                    </span></h3>
            </div>
        </div>
        </div>
    </section>


    <!-- History Books Card -->

    <section>
        <div class="container">
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4">
                <?php
                // Memeriksa apakah query berhasil
                if ($resulthistory) {
                    // Mengambil dan menampilkan hasil
                    while ($book = mysqli_fetch_assoc($resulthistory)) {
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
                    // Menampilkan pesan error jika query gagal
                    echo "Error: " . mysqli_error($con);
                }
                ?>
            </div>
        </div>
    </section>

    <!-- footer -->
    <footer class="bg-secondary text-white text-center p-3 mt-5">
        <p class="mb-0">Copyright &copy; 2024 LibMent</p>
        <p class="mb-0">Developed by <a href="https://github.com/Devandranabana20" class="text-decoration-none text-light">Devandra Nabana</a></p>
    </footer>

    <!-- script -->
    <script>
        // All animations will take half the time to accomplish
        document.documentElement.style.setProperty('--animate-duration', '9s');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/4422c44224.js" crossorigin="anonymous"></script>

    <!-- Go to top -->
    <button onclick="topFunction()" id="go-top" title="Go to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("go-top").style.display = "block";
            } else {
                document.getElementById("go-top").style.display = "none";
            }
        }

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
</body>

</html>