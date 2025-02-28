<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelGo - <?= ucfirst(str_replace('.php', '', $current_page)) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">TravelGo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($current_page == 'packages.php') ? 'active' : '' ?>" href="packages.php">Packages</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link <?= ($current_page == 'profile.php') ? 'active' : '' ?>" href="profile.php">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link <?= ($current_page == 'login.php') ? 'active' : '' ?>" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link <?= ($current_page == 'register.php') ? 'active' : '' ?>" href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container" style="margin-top: 80px;">