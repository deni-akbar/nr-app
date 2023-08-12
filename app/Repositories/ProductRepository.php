<?php
namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function all()
    {
        return Product::all();
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function find($id)
    {
        return Product::find($id);
    }

    public function update($id, array $data)
    {
        $model = Product::find($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        $model = Product::find($id);
        return $model->delete();
    }
} 