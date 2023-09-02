<?php
namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    protected $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $data = $this->repository->all();

        return jsonResponse(200, '', $data);

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            // tambahkan validasi lainnya sesuai kebutuhan
        ]);

        $createdData = $this->repository->create($validatedData);

        return jsonResponse(Response::HTTP_CREATED, 'Success post data', $createdData);

    }

    public function show($id)
    {
        $data = $this->repository->find($id);
        
        return jsonResponse(200, '', $data);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            // tambahkan validasi lainnya sesuai kebutuhan
        ]);

        $updatedData = $this->repository->update($id, $validatedData);

        return jsonResponse(201, 'Update Data Success', $updatedData);
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        
        return jsonResponse(200, '',[]);
    }
}