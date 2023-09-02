<?php
namespace App\Repositories;


class AddressRepository
{
    public function getAllProvinces()
    {
        return \Indonesia::allProvinces();
    }

    public function getAddress($idProvince)
    {
        $with=['cities', 'districts', 'villages', 'cities.districts', 'cities.districts.villages', 'districts.villages'];

        return \Indonesia::findProvince($idProvince,$with);
    }

} 