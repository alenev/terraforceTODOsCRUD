<?php 

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function all()
    {
        return User::all();
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(array $data, $id)
    {
        return User::where("id", $id)
            ->update($data);
    }

    public function delete($id)
    {
        return User::destroy($id);
    }

    public function find($id)
    {
        return User::find($id);     
    }

}