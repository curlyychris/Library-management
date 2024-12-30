<?php
require_once '../Models/bookModel.php';
require_once '../Models/createBookModel.php';
require_once '../Persistence/books_repository.php';
require_once 'Components/navbar.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$search = $_GET['search'] ?? "";
$searchBy = $_GET['searchBy'] ?? "";
$bookRepository = new BookRepository();
$books = $bookRepository->getBooks($search, $searchBy, $_SESSION['librarian_id'] ?? 0);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <?php include('common_scripts_and_styles.php'); ?>
    <style>
        .fixed-bottom-right {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <div class="container">

    <form action="./my_books.php" class="pb-5 pt-5" method="GET">
            <div class="form-group">
                <label for="search">Search</label>
                <input type="text" class="form-control" id="search" name="search" value="<?= $search ?>">
            </div>
            <div class="form-group">
                <label for="searchBy">Search By</label>
                <select class="form-control" id="searchBy" name="searchBy" required>
                    <option <?= $searchBy=="title" ? "selected" : "" ?> value="title">Title</option>
                    <option <?= $searchBy=="author" ? "selected" : "" ?> value="author">Author</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>


        <div class="row">
            <?php foreach ($books as $book): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($book->title) ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($book->author) ?></h6>
                            <p class="card-text">ISBN: <?= htmlspecialchars($book->isbn) ?></p>
                            <p class="card-text">Librarian ID: <?= htmlspecialchars($book->librarian_id) ?></p>
                            <div class="d-grid gap-2">
                                <a href="../Views/book_details_view.php?id=<?= htmlspecialchars($book->book_id) ?>&backView=my_books.php" class="btn btn-primary">View</a>
                                    <a href="../views/create_book.php?id=<?= htmlspecialchars($book->book_id) ?>" class="btn btn-warning">Edit</a>
                                    <a href="../Actions/delete_book_handler.php?id=<?= htmlspecialchars($book->book_id) ?>" class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <a href="create_book.php" class="btn btn-success fixed-bottom-right">Create Book</a>
</body>
</html>