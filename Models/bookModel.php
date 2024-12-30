<?php
class BookModel{
    public int $book_id;
    public string $title;
    public string $author;
    public string $isbn;
    public int $librarian_id;
    public function __construct(int $book_id, string $title, string $author, string $isbn, int $librarian_id) {
        $this->book_id = $book_id;
        $this->title = $title;
        $this->author = $author;
        $this->isbn = $isbn;
        $this->librarian_id = $librarian_id;
    }

}