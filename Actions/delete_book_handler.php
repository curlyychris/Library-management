<?php
require_once '../Models/BookModel.php';
require_once '../Persistence/books_repository.php';

$bookRepository = new BookRepository();

if (isset($_GET['id'])) {
    session_start();
    $bookId = intval($_GET['id']);
    $bookRepository->deleteBook($bookId, $_SESSION['librarian_id']?? 0);
}

header('Location: ../Views/my_books.php');
exit();
