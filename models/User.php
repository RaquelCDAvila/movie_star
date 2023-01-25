<?php


    class User{
        public $id;
        public $name;
        public $lastname;
        public $email;
        public $password;
        public $image;
        public $bio;
        public $token;
    }

    interface UserDAOInterface{

        public function buildUser($data);
        public function create(User $user, $authUser = false);
        public function update(User $user);
        public function verificToken($protected = false);
        public function setTokenToSession($token, $reditect = true);
        public function authenticateUser($email, $passaword);
        public function findByEmail($email);
        public function findById($id);
        public function findByToken($token);
        public function changePassword(User $user);
    }