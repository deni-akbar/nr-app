<?php
namespace App\Repositories;

use App\Models\user;

class userRepository
{
    public function all()
    {
        return user::all();
    }

    public function create(array $data)
    {
        return user::create($data);
    }

    public function find($id)
    {
        return user::find($id);
    }

    public function findByEmail($id)
    {
        return user::where('email',$id)->first();
    }

    public function update($id, array $data)
    {
        $model = user::find($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        $model = user::find($id);
        return $model->delete();
    }
} 