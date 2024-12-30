<?php
require_once '../Models/BookModel.php';
require_once '../Models/CreateBookModel.php';
require_once '../Persistence/books_repository.php';
require_once 'Components/navbar.php';

$bookRepository = new BookRepository();
$book = null;
$isEdit = false;

if (isset($_GET['id'])) {
    $book = $bookRepository->getBookById(intval($_GET['id']));
    $isEdit = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $isbn = $_POST['isbn'] ?? '';
    $librarian_id = $_SESSION['librarian_id'] ?? 0;

    if ($isEdit) {
        $book = new BookModel($_GET['id'], $title, $author, $isbn, $librarian_id);
        $bookRepository->updateBooks($book, $librarian_id);
    } else {
        $createBookModel = new CreateBookModel($title, $author, $isbn, $librarian_id);
        $bookRepository->createBook($createBookModel);
    }

    header('Location: my_books.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Edit Book' : 'Create Book' ?></title>
    <?php include('common_scripts_and_styles.php'); ?>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">
                        <h3 class="text-center"><?= $isEdit ? 'Edit Book' : 'Create Book' ?></h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($book->title ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="author">Author</label>
                                <input type="text" class="form-control" id="author" name="author" value="<?= htmlspecialchars($book->author ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="isbn">ISBN</label>
                                <input type="text" class="form-control" id="isbn" name="isbn" value="<?= htmlspecialchars($book->isbn ?? '') ?>" required>
                            </div>
                            <input type="hidden" name="id" value="<?= $book->book_id ?? 0 ?>">
                            <button type="submit" class="btn btn-primary btn-block"><?= $isEdit ? 'Update Book' : 'Create Book' ?></button>
                            <a href="my_books.php" class="btn btn-secondary btn-block mt-2">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>