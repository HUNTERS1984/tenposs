<?php
    namespace App\Repositories\Contracts;
    interface UsersRepositoryInterface
    {
        public function all();
        public function find($id);
        public function login();
        public function logout();
    }