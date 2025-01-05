<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <title>LibMent System</title>
    <link rel="icon" href="assets/libmentlogo.ico" type="image/x-icon">
</head>

<body>
    <!-- Landing Page -->
    <section class="vh-100">
        <div class="container h-100">

            <div class="row p-5 h-100 align-items-center justify-content-center">
                <div class="col-12 col-md-6 order-md-2 text-center text-md-end align-self-center">
                    <img style="border-radius: 20px;" class="img-fluid" src="assets/booklogo.png" alt="book" width="50%">
                </div>
                <div class="col-12 col-md-6 order-md-1 align-self-center text-left">
                    <h1 class="title mt-2">Welcome to <span class="title1"></span> System</h1>
                    <p class="para mt-2">LibMent is a web-based library management system designed to be used internally within a physical library. The system aims to manage the book catalog, borrower registration, loan and return process, and provide detailed reports. By focusing on internal use, LibMent ensures that the physical library remains the main hub for visitors.</p>
                    <a href="allbook.php"><button class="btn btn-primary px-4 py-2">Let's get started</button></a>
                </div>
            </div>

        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/typeit@7.0.4/dist/typeit.min.js"></script>
    <script>
        new TypeIt('.title1', {
            strings: "LibMent",
            speed: 470,
            loop: true
        }).go();
    </script>
    <script src="JS/script.js"></script>
</body>

</html>