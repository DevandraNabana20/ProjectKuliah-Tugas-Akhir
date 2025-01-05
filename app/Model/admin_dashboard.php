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
include 'include/header.php';
?>
<?php
include 'include/script.php';
?>

<body class="sb-nav-fixed">
    <?php
    include 'include/navbar.php';
    ?>
    <div id="layoutSidenav">
        <?php
        include 'include/side.php';
        ?>

        <?php
        require_once "../../config/koneksi.php";
        $con = db_connect();

        // Mengambil data buku teratas berdasarkan counter
        $bookName = mysqli_query($con, "SELECT title FROM book ORDER BY counter DESC LIMIT 5");
        $counter = mysqli_query($con, "SELECT counter FROM book ORDER BY counter DESC LIMIT 5");
        ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">𝐃𝐚𝐬𝐡𝐛𝐨𝐚𝐫𝐝</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">𝙒𝙚𝙡𝙘𝙤𝙢𝙚 𝙩𝙤 LibMent 𝙙𝙖𝙨𝙝𝙗𝙤𝙖𝙧𝙙 𝙛𝙤𝙧 𝙖𝙙𝙢𝙞𝙣</li>
                    </ol>
                    <label class="mt-1" style="font-size: 25px;color: lightsalmon;" for="">𝐓𝐨𝐩 𝟓 𝐕𝐢𝐞𝐰𝐞𝐝 𝐁𝐨𝐨𝐤𝐬</label>
                    <canvas id="myChart" width="35px" height="13px"></canvas>
                    <script>
                        var ctx = document.getElementById("myChart");
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: [<?php while ($b = mysqli_fetch_array($bookName)) {
                                                echo '"' . $b['title'] . '",';
                                            } ?>],
                                datasets: [{
                                    label: "Total of Visitors",
                                    data: [<?php while ($p = mysqli_fetch_array($counter)) {
                                                echo '"' . $p['counter'] . '",';
                                            } ?>],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                    ],
                                    borderColor: [
                                        'rgba(255,99,132,1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                    </script>
                </div>
            </main>
            <?php
            include 'include/footer.php';
            ?>
        </div>
    </div>

</body>

</html>