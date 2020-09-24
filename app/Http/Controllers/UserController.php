<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->respondWithData(new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User                $user
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (!$user) {
            return $this->respondWithError(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (auth()->user()->id !== $user->id) {
            return $this->respondWithError(Response::HTTP_FORBIDDEN);
        }

        $validation = Validator::make($request->all(), [
            'first_name' => ['required','max:255'],
            'last_name' => ['required','max:255'],
            'email' => ['required','max:255', 'email', 'unique:users,email,' . $user->id  ]
        ]);

        $validation->sometimes(
            'old_password',
            ['required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail('Old Password didn\'t match');
                    }
                }
            ],
            function ($input) {
                return $input->new_password || $input->new_password_confirmation;
            }
        );

        $validation->sometimes('new_password', ['required', 'min:6', 'confirmed'], function ($input) {
            return $input->old_password || $input->new_password_confirmation;
        });

        if ($validation->fails()) {
            return $this->respondWithError(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                "The given data was invalid.",
                $validation->errors()
            );
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->bio = $request->bio;

        if ($request->new_password) {
            $user->password = bcrypt($request->new_password);
        }

        $user->save();

        return $this->respondWithData(new UserResource($user));
    }
}
