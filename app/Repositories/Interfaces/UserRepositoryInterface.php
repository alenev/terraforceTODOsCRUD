<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface {
    public function all();
    public function create(array  $data);
    public function update(array $data, $id);
    public function delete(int $id);
    public function find(int $id);
}