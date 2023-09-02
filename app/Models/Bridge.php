<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Bridge extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'bridges';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'province_id',
        'village_id',
        'city_id',
        'district_id',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function province()
    {
        return $this->hasOne(Province::class, 'id', 'province_id');
    }

    public function village()
    {
        return $this->hasOne(Village::class, 'id', 'village_id');
    }

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function district()
    {
        return $this->hasOne(District::class, 'id', 'district_id');
    }
}
