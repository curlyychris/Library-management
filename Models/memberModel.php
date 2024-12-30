<?php

class MemberModel{
    public int $meber_id;
    public string $contact;
    public string $membership_id;
    public UserModel $user;

    public function __construct(int $member_id, string $contact, string $membership_id, UserModel $user) {
        $this->member_id = $member_id;
        $this->contact = $contact;
        $this->membership_id = $membership_id;
        $this->user = $user;
    }

}