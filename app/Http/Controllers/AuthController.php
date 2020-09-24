<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;

class AuthController extends ApiController
{
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->respondWithData(new UserResource(auth()->user()));
    }
}
