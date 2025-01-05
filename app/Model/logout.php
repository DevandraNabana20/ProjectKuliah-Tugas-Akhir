<?php
session_start();
session_destroy();
header("Location: admin_login.php?pesan=Logout successful.");
exit();
