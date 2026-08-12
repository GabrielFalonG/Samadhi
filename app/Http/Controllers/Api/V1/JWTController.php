<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class JWTController extends Controller
{
    /**
     * Response with a valid JWT Token
     */
    public function index()
    {
        try {
            $payload = JWTFactory::customClaims([
                'user' => 'User1 Test',
                'iat' => time(),
                'exp' => time() + 3600, // 1 hora
            ])->make();

            throw new Exception('This is a test exception to check the error handling.');

            $token = JWTAuth::encode($payload)->get();
            $data  = [
                'jwt' => $token,
            ];

            return new Response($data, Response::HTTP_OK);
        } catch (Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
