<?php
namespace App\Repositories;

use App\Models\Vendor;

class VendorRepository
{
    public function all()
    {
        return Vendor::all();
    }

    public function getRandomVendor($limit)
    {
        return Vendor::inRandomOrder()->take($limit)->get();
    }

    public function create(array $data)
    {
        return Vendor::create($data);
    }

    public function find($id)
    {
        return Vendor::find($id);
    }

    public function findByEmail($id)
    {
        return Vendor::where('email',$id)->first();
    }

    public function update($id, array $data)
    {
        $model = Vendor::find($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        $model = Vendor::find($id);
        return $model->delete();
    }
} 