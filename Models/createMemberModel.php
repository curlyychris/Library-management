<?php

class CreateMemberModel{
    public string $contact;
    public string $membership_id;
    public string $email; 
    public string $name;
    public string $password;

    public function __construct(string $contact, string $membership_id, string $email, string $name, string $password) {
        $this->contact = $contact;
        $this->membership_id = $membership_id;
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;

    }
}