<?php
session_start(); // Memulai session

// Cek apakah admin sudah login
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin_dashboard.php"); // Redirect ke dashboard admin jika sudah login
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../View/assets/libmentlogo.ico" type="image/x-icon">
    <title>Admin Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .login-container {
            width: 400px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h3 class="text-center">Admin Login</h3>
        <?php if (isset($_GET['pesan'])): ?>
            <div class="alert <?php echo ($_GET['pesan'] == 'Logout successful.') ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                <?php echo htmlspecialchars($_GET['pesan']); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="proses_login.php">
            <div class="mb-3">
                <label for="names" class="form-label">Username</label>
                <input type="text" class="form-control" id="names" name="names" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>