<?php
namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $data = $this->repository->all();

        return jsonResponse(200, '', $data);
    }

    public function getRandom(Request $request)
    {
        $limit=$request->get('limit');
        $data = $this->repository->getRandomProduct($limit);
       
        return jsonResponse(200, '', $data);
    }

    public function getByVendor($id)
    {
        $data = $this->repository->getByVendor($id);

        return jsonResponse(200, '', $data);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'desc' => 'required',
            'vendor_id' => 'required', 
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $createdData = $this->repository->create($request->all());

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
        return jsonResponse(200, '', []);

    }
}