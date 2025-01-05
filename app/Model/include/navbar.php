<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <style>
        .navbar-brand:hover,
        .navbar-brand>span:hover {
            color: rgb(243, 230, 230) !important;
        }
    </style>
    <a class="navbar-brand ps-3" style="font-size: 40px; font-weight: 600;" href="http://localhost/projectlibment/app/View/index.php">Lib<span style="color:rgb(87, 129, 197);">Ment</span></a> <!-- Mengubah nama dan logo -->
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
    </button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item"><?php echo $_SESSION['names']; ?></a></li> <!-- Mengganti username dengan names -->
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="http://localhost/projectlibment/app/Model/logout.php">Log out</a></li>
            </ul>
        </li>
    </ul>
</nav>