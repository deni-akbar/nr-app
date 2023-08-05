<?php
namespace App\Repositories;

use App\Models\Bridge;

class BridgeRepository
{
    public function all()
    {
        return Bridge::all();
    }

    public function create(array $data)
    {
        return Bridge::create($data);
    }

    public function find($id)
    {
        return Bridge::find($id);
    }

    public function findByEmail($id)
    {
        return Bridge::where('email',$id)->first();
    }

    public function update($id, array $data)
    {
        $model = Bridge::find($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        $model = Bridge::find($id);
        return $model->delete();
    }
} 