<?php
require_once '../Models/BookModel.php';
require_once '../Models/CreateBookModel.php';
require_once '../Persistence/books_repository.php';
require_once 'Components/navbar.php';

$backView = isset($_GET['backView']) ? $_GET['backView'] : 'all_books.php';
$bookRepository = new BookRepository();
$book = isset($_GET['id']) ? $bookRepository->getBookById(intval($_GET['id'])) : null;
$showManagementButtons = true; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <?php include('common_scripts_and_styles.php'); ?>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php if ($book): ?>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($book->title) ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($book->author) ?></h6>
                            <p class="card-text">ISBN: <?= htmlspecialchars($book->isbn) ?></p>
                            <p class="card-text">Librarian ID: <?= htmlspecialchars($book->librarian_id) ?></p>
                            <div class="d-grid gap-2">
                                <?php if ($showManagementButtons): ?>
                                    <a href="<?= $backView?>" class="btn btn-primary">Back</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger" role="alert">
                        Book not found.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
</body>
</html>