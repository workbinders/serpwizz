<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\AuthResource;
use App\Models\User;

class AuthUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Update login user's profile details
     */
    public function store(ProfileUpdateRequest $request)
    {
        try {
            $input = $request->only('first_name', 'last_name', 'email', 'profile_image');

            $user = User::find(Auth::id());
            $user->update($input);
            $user->refresh();

            if ($request->profile_image) {
                $request->file('profile_image')->getClientOriginalName();
                $input['profile_image'] = $request->profile_image->move("image/users/profile_image", $user->slug . ".jpg");
                $user->update($input);
                $user->refresh();
            }

            $response = [
                User::SINGLE_NAME => new AuthResource($user),
            ];
            $message = __('message.profile_update_success');
            return $this->sendResponse($message, $response);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = Auth::user();
            $response = [
                'user'  => new AuthResource($user)
            ];
            return $this->sendResponse('', $response);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
