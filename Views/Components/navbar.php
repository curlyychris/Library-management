<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
        <a class="navbar-brand">Welcome <?= $_SESSION['name'] ?? "" ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php if($_SESSION['role_name']=='librarian'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="my_books.php">My Books</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="all_books.php">All Books</a>
                </li>
                <?php endif ?>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../Actions/logout_handler.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
</body>
</html>