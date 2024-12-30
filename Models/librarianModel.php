<?php
class LibrarianModel
{
    public int $librarian_id;
    public UserModel $user;
    public function __construct(int $librarian_id, UserModel $user) {
        $this->librarian_id = $librarian_id;
        $this->user = $user;
    }
}