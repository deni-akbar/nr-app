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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:bridge,vendor', // Aturan validasi untuk role
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }
        
        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password')),
        ];

        if($request->role=='vendor'){
            $data = $this->vendorRepository->create($userData);
        }else{
            $data = $this->bridgeRepository->create($userData);
        }

        $token = JWTAuth::fromUser($data);

         return response()->json(['message' => 'Register Success'], 200);
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
                    return response()->json(['error' => 'User tidak ditemukan'], Response::HTTP_UNAUTHORIZED);
                }

                if (!$token = auth('vendor')->attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }

            }else{
                // Ambil user berdasarkan email yang diinputkan
                $user = $this->bridgeRepository->findByEmail($credentials['email']);

                // Jika user tidak ditemukan, berikan respon error
                if (!$user) {
                    return response()->json(['error' => 'User tidak ditemukan'], Response::HTTP_UNAUTHORIZED);
                }

                if (!$token = auth('bridge')->attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials1'], 400);
                }
            }
            
            $token = JWTAuth::fromUser($user);
            
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(compact('user', 'token'));
    }
}
