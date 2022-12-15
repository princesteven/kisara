<?php

namespace Modules\Users\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Hash;
use Modules\Users\Entities\User;
use Modules\Users\Transformers\UserResource;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends AppBaseController
{
    /**
     * Authenticate user
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
//        return phpinfo();
        if (!auth()->attempt($request->only('username', 'password'))) {
            return $this->sendError('Invalid credentials', Response::HTTP_UNAUTHORIZED);
        }
        //revoke all tokens
        $this->revoke($request);
        //generate new token
        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return $this->sendResponse(['user' => new UserResource(auth()->user()), 'access_token' => $accessToken], 'User logged In successfully');
    }

    /**
     * Terminate user session
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request): Response
    {
        $this->revoke($request);

        return $this->sendResponse([], 'Successful logout', Response::HTTP_ACCEPTED);
    }

    /**
     * Get logged in user
     * @param Request $request
     * @return Response
     */
    public function user(Request $request)
    {
        return $this->sendResponse(new UserResource($request->user()), 'User retrieved successfully');
    }

    /**
     * Revoke access tokens
     * @param Request $request
     * @return void
     */
    protected function revoke(Request $request): void
    {
        $request->user()->tokens()->each(fn($token) => $token->revoke());
    }
}
