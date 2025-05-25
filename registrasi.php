<?php
require 'function.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi - Kasir TokoKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://inspgr.id/app/uploads/2023/05/pixel-art-kirokaze-18.gif');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            max-width: 450px;
            width: 100%;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            transition: background-color 0.3s ease;
        }
        .dark-mode body {
            background-color: #121212;
        }
        .dark-mode .card {
            background-color: rgba(30, 30, 30, 0.95);
            color: #fff;
        }
        .toggle-btn {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <button class="btn btn-sm btn-light toggle-btn" onclick="toggleDarkMode()">🌙🌑 Dark Mode</button>
    <div class="card">
        <h3 class="text-center mb-4">Registrasi Kasir TokoKu</h3>
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input name="username" type="text" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input name="password" type="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input name="password2" type="password" class="form-control" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary w-100">Daftar</button>
        </form>
        <div class="mt-3 text-center">
            <p>Sudah punya akun? <a href="login.php">Login disini</a></p>
        </div>
    </div>

    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }
    </script>
</body>
</html>
