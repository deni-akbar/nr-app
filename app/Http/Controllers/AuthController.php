<?php
namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\BridgeRepository;
use App\Repositories\VendorRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository,BridgeRepository $bridgeRepository,VendorRepository $vendorRepository)
    {
        $this->userRepository = $userRepository;
        $this->bridgeRepository = $bridgeRepository;
        $this->vendorRepository = $vendorRepository;

    }

    public function register(Request $request)
    {
        $vld_email=($request->role=='vendor')?'vendors':'bridges';

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:'.$vld_email,
            'password' => 'required|min:6',
            'role' => 'required|in:bridge,vendor', 
            'province_id' => 'required',
            'city_id' => 'required',
            'village_id' => 'required',
            'district_id' => 'required',
            'photo' => 'file|mimes:jpeg,png,pdf|max:2048',
        ]);
    
        if ($validator->fails()) {
            return jsonResponse(Response::HTTP_BAD_REQUEST,'Error Validations',$validator->errors());
        }

        $file = $request->file('photo');
        if($file){
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('user_photo', $fileName);
        }


        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password')),
            'province_id' => $request->input('province_id'),
            'city_id' => $request->input('city_id'),
            'village_id' => $request->input('village_id'),
            'district_id' => $request->input('district_id'),
            'photo' => $fileName,
        ];

        if($request->role=='vendor'){
            $data = $this->vendorRepository->create($userData);
        }else{
            $data = $this->bridgeRepository->create($userData);
        }

        $token = JWTAuth::fromUser($data);

        return jsonResponse(200,'Register Success',$data);

    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if($request->role=='vendor'){
                // Ambil user berdasarkan email yang diinputkan
                $user = $this->vendorRepository->findByEmail($credentials['email']);

                // Jika user tidak ditemukan, berikan respon error
                if (!$user) {
                    return jsonResponse(Response::HTTP_UNAUTHORIZED,'User tidak ditemukan',[]);
                }

                if (!$token = auth('vendor')->attempt($credentials)) {
                    return jsonResponse(400,'Invalid credentials',[]);
                }

            }else{
                // Ambil user berdasarkan email yang diinputkan
                $user = $this->bridgeRepository->findByEmail($credentials['email']);

                // Jika user tidak ditemukan, berikan respon error
                if (!$user) {
                    return jsonResponse(Response::HTTP_UNAUTHORIZED,'User tidak ditemukan',[]);
                }

                if (!$token = auth('bridge')->attempt($credentials)) {
                    return jsonResponse(400,'Invalid credentials',[]);
                }
            }
            
            $token = JWTAuth::fromUser($user);
            $token = 'Bearer '.$token;
        } catch (JWTException $e) {
            return jsonResponse(Response::HTTP_INTERNAL_SERVER_ERROR,'Could not create token',[]);
        }

        return jsonResponse(200,'Login Success',compact('user', 'token'));

    }
}
