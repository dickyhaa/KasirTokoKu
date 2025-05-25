<?php
session_start();

// Jika user sudah konfirmasi logout
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Jika user batal logout
if (isset($_GET['confirm']) && $_GET['confirm'] === 'no') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>
    <script>
        window.onload = function() {
            if (confirm("Apakah Anda yakin ingin logout?")) {
                window.location.href = "logout.php?confirm=yes";
            } else {
                window.location.href = "logout.php?confirm=no";
            }
        }
    </script>
</head>
<body>
</body>
</html>
