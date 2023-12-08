<?php 

namespace App\Repositories;

use App\Models\Todo;
use App\Repositories\Interfaces\ToDoRepositoryInterface;

class ToDoRepository implements ToDoRepositoryInterface
{

    public function all($userId)
    {
        return Todo::where("user_id", $userId)->get()->all();
    }

    public function create(array $data)
    {
        return Todo::create($data);
    }

    public function show(array $data){
        return Todo::where(['user_id' => $data["user_id"], 'id' => $data["id"]])->first();
    }

    public function update(array $data, $id)
    {
        return Todo::where("id", $id)->update($data);
    }

    public function delete($id)
    {
        return Todo::destroy($id);
    }

    public function find($id)
    {
        return Todo::find($id);     
    }

}