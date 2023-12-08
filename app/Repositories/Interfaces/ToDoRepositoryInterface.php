<?php

namespace App\Repositories\Interfaces;

interface ToDoRepositoryInterface {
    public function all(int $userId);
    public function create(array  $data);
    public function show(array $data);
    public function update(array $data, $id);
    public function delete(int $id);
    public function find(int $id);
}