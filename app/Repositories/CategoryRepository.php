<?php
namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function all()
    {
        return Category::all();
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function find($id)
    {
        return Category::find($id);
    }

    public function update($id, array $data)
    {
        $model = Category::find($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        $model = Category::find($id);
        return $model->delete();
    }
} 