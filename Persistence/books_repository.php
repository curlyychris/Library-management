<?php
require_once('db_connection.php');
require_once("../Models/CreateBookModel.php");


class BookRepository
{
    private $conn;

    public function __construct() {
        $dbConnection = new DbConnection();
        $this->conn = $dbConnection->conn;
    }

    function createBook(CreateBookModel $book)
    {
        $conn=$this->conn;
        $sql = "INSERT INTO books (title, author, isbn, librarian_id) VALUES (?, ?, ?, ?)";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssi', $book->title, $book->author, $book->isbn, $book->librarian_id);
            $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            echo "Failed to prepare statement";
        }

    }

    function getBooks(string $search, string $searchBy, int $librarianId = null)
    {
        $conn=$this->conn;
        $sql = "SELECT * FROM books";
        $wasSearchByAdded = false;
        try {

            if ($librarianId != null) {
                $sql .= " WHERE librarian_id = ?";
            }

            if ($searchBy == "author") {
                $sql .= $librarianId != null ? " AND author LIKE ?" : " WHERE author LIKE ?";
                $wasSearchByAdded = true;
            } else if ($searchBy == "title") {
                $sql .= $librarianId != null ? " AND title LIKE ?" : " WHERE title LIKE ?";
                $wasSearchByAdded = true;
            }
            $stmt = $conn->prepare($sql);
            if ($librarianId == null && $wasSearchByAdded) {
                $search = "%" . $search . "%";
                $stmt->bind_param("s", $search);
            } else if ($librarianId != null && $wasSearchByAdded) {
                $search = "%" . $search . "%";
                $stmt->bind_param("is", $librarianId, $search);
            } else if ($librarianId != null && !$wasSearchByAdded) {
                $stmt->bind_param("i", $librarianId);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            $books = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $book = new BookModel($row["id"], $row["title"], $row["author"], $row["isbn"], $row["librarian_id"]);
                    array_push($books, $book);
                }
            }
            return $books;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function getBookById(int $id): ?BookModel
    {
        $conn=$this->conn;

        $sql = "SELECT * FROM books WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $book = null;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $book = new BookModel($row["id"], $row["title"], $row["author"], $row["isbn"], $row["librarian_id"]);
        }
        return $book;
    }

    function updateBooks(BookModel $book, int $librarian_id)
    {
        $conn=$this->conn;
        $sql = "UPDATE books SET title = ?, author = ?, isbn = ? WHERE id = ? AND librarian_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssii', $book->title, $book->author, $book->isbn, $book->book_id, $librarian_id);
        $stmt->execute();
        $stmt->close();
    }

    function deleteBook(int $book_id, int $librarian_id)
    {
        $conn=$this->conn;
        $sql = "DELETE FROM books WHERE id = ? AND librarian_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $book_id, $librarian_id);
        $stmt->execute();
        $stmt->close();
    }

}
