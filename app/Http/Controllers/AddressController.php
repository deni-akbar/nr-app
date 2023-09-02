<?php
namespace App\Http\Controllers;

use App\Repositories\AddressRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    protected $repository;

    public function __construct(AddressRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllProvinces()
    {
        $data = $this->repository->getAllProvinces();

        return jsonResponse(200, '', $data);
    }

    public function getAddress($idProvince)
    {
        $data = $this->repository->getAddress($idProvince);

        return jsonResponse(200, '', $data);
    }

}