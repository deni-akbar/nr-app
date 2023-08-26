<?php
namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function all()
    {
        return Product::with('category')->get();
    }

    public function getRandomProduct($limit)
    {
        return Product::with('category')->inRandomOrder()->take($limit)->get();
    }

    public function getByVendor($id)
    {
        return Product::where('vendor_id',$id)->with('category')->get();
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