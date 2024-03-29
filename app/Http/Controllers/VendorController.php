<?php
namespace App\Http\Controllers;

use App\Repositories\VendorRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VendorController extends Controller
{
    protected $repository;

    public function __construct(VendorRepository $repository)
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
        $data = $this->repository->getRandomVendor($limit);
        return jsonResponse(200, '', $data);

    }

    public function show()
    {
        
        $user = auth('vendor')->userOrFail();
        $data = $this->repository->find($user->id);
        return jsonResponse(200, '', $data);

    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'field1' => 'required',
            'field2' => 'required',
            // tambahkan validasi lainnya sesuai kebutuhan
        ]);

        $updatedData = $this->repository->update($id, $validatedData);
        return response()->json($updatedData);
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return jsonResponse(200, '', []);
    }
}