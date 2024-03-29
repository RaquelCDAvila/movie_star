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

        public function generateToken(){
            return bin2hex(random_bytes(50));
        }

        public function generatePassword($password){
            return password_hash($password, PASSWORD_DEFAULT);
        }
    }

    interface UserDAOInterface{

        public function buildUser($data);
        public function create(User $user, $authUser = false);
        public function update(User $user, $redirect = true);
        public function verificToken($protected = false);
        public function setTokenToSession($token, $reditect = true);
        public function authenticateUser($email, $passaword);
        public function findByEmail($email);
        public function findById($id);
        public function findByToken($token);
        public function destroyToken();
        public function changePassword(User $user);
    }