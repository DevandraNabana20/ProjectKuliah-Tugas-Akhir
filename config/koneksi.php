<?php function db_connect()
{
    $con = mysqli_connect("localhost", "root", "", "db_libment");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $con;
}

function db_disconnect($con)
{
    mysqli_close($con);
}
