<?php

class RoleModel
{
    public $role_id;
    public $name;

    public function __construct($role_id, $name) {
        $this->role_id = $role_id;
        $this->name = $name;
    }
}