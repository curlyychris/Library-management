<?php
class UserModel{

    public int $user_id;
    public string $email; 
    public string $name;
    public RoleModel $role;
    public function __construct(int $user_id, string $email, string $name, RoleModel $role) {
        $this->user_id = $user_id;
        $this->email = $email;
        $this->name = $name;
        $this->role = $role;
    }

}