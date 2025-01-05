<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Menu</div>
                <a class="nav-link" href="http://localhost/projectlibment/app/Model/admin_dashboard.php">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    Dashboard
                </a>
                <a class="nav-link" href="http://localhost/projectlibment/app/Model/admin/books/books.php">
                    <div class="sb-nav-link-icon">
                        <i class="bi bi-book"></i>
                    </div>
                    Books
                </a>
                <!-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    User
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="http://localhost/projectlibment/app/Model/admin/user/user.php">User</a>
                        <a class="nav-link" href="#">Blocked User</a>
                    </nav>
                </div> -->
                <a class="nav-link" href="http://localhost/projectlibment/app/Model/admin/user/user.php">
                    <div class="sb-nav-link-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    User
                </a>
                <a class="nav-link" href="http://localhost/projectlibment/app/Model/admin/rent/rent.php">
                    <div class="sb-nav-link-icon">
                        <i class="bi bi-handbag"></i>
                    </div>
                    Rent Books
                </a>
                <a class="nav-link" href="http://localhost/projectlibment/app/Model/admin/rentlist/rentlist.php">
                    <div class="sb-nav-link-icon">
                        <i class="bi bi-card-list"></i>
                    </div>
                    Rent list
                </a>
                <a class="nav-link" href="http://localhost/projectlibment/app/Model/admin/return/return.php">
                    <div class="sb-nav-link-icon">
                        <i class="bi bi-arrow-clockwise"></i>
                    </div>
                    Return Books
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?php echo $_SESSION['names']; // Menampilkan nama admin
            ?>
        </div>
    </nav>
</div>