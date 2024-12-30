<?php
class CreateBookModel{
    public string $title;
    public string $author;
    public string $isbn;
    public int $librarian_id;
    public function __construct(string $title, string $author, string $isbn, int $librarian_id) {
        $this->title = $title;
        $this->author = $author;
        $this->isbn = $isbn;
        $this->librarian_id = $librarian_id;
    }

}