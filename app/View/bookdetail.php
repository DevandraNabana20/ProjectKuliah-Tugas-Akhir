<!-- koneksi ke database -->
<?php
include('../../config/koneksi.php');
$con = db_connect();

// Get the bookID from the URL query parameter
$bookID = isset($_GET['id']) ? $_GET['id'] : '';

// Update the counter for the book
$sqlUpdateCounter = "UPDATE book SET counter = counter + 1 WHERE bookID = '$bookID'";

// Get the book details
$sqlBookDetail = "SELECT * FROM book WHERE bookID = '$bookID'";
$resultBookDetail = mysqli_query($con, $sqlBookDetail);
$bookDetail = mysqli_fetch_assoc($resultBookDetail);
?>

<!DOCTYPE html>
<html lang="en">
<html onload="<?php mysqli_query($con, $sqlUpdateCounter) ?>" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title><?php echo $bookDetail['title']; ?> - Book Detail</title>
    <link rel="icon" href="assets/libmentlogo.ico" type="image/x-icon">
    <style>
        .containerbook {
            display: flex;
            gap: 20px;
            padding: 20px;
        }

        @media (max-width: 575.98px) {
            .containerbook {
                flex-direction: column;
            }

            .card {
                width: 100%;
            }
        }

        @media (min-width: 576px) {
            .containerbook {
                flex-direction: row;
            }

            .card {
                width: 50%;
            }
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background-color: #fff;
        }

        .book-image {
            flex: 2;
            object-fit: fill;
            height: fit-content;
        }

        .book-details {
            flex: 8;
        }

        .book-details h2 {
            margin-top: 0;
        }

        .book-details p {
            margin: 5px 0;
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        .navbar.navbar-expand-lg {
            background-color: #0142a8 !important;
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


    <!-- Book Carddetail Section -->
    <section style="height: 2rem;"></section>

    <div class="containerbook">
        <div class="card book-image">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($bookDetail['bookimage']); ?>" alt="Book Image" style="width: 100%;">
        </div>
        <div class="card book-details">
            <h2><?php echo $bookDetail['title']; ?></h2>
            <p><strong>ISBN:</strong> <?php echo $bookDetail['isbn']; ?></p>
            <p><strong>Genre:</strong> <?php echo $bookDetail['genre']; ?></p>
            <p><strong>Description:</strong> <?php echo $bookDetail['description']; ?></p>
            <p><strong>Language:</strong> <?php echo $bookDetail['language']; ?></p>
            <p><strong>Author:</strong> <?php echo $bookDetail['author']; ?></p>
            <p><strong>Publisher:</strong> <?php echo $bookDetail['publisher']; ?></p>
            <p><strong>Release Date:</strong> <?php echo $bookDetail['releasedate']; ?></p>
            <p><strong>Pages:</strong> <?php echo $bookDetail['pages']; ?></p>
            <p><strong>Stock:</strong> <?php echo $bookDetail['stock']; ?></p>
            <p><strong>Rent Price:</strong> Rp<?php echo number_format($bookDetail['rentprice']); ?></p>
            <p><strong>Total Viewed:</strong> <?php echo $bookDetail['counter']; ?></p>
        </div>
    </div>

    <?php
    // Menutup koneksi
    mysqli_close($con);
    ?>

    <footer class="bg-secondary text-white text-center p-3 mt-5">
        <p class="mb-0">Copyright &copy; 2024 LibMent</p>
        <p class="mb-0">Developed by <a href="https://github.com/Devandranabana20" class="text-decoration-none text-light">Devandra Nabana</a></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>