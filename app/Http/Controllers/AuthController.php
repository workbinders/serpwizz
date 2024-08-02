<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\AuthResource;
use App\Mail\ForgetPasswordMail;
use App\Mail\UserRegisterMail;
use App\Models\ForgetPassword;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    use ApiResponse;
    public function register(RegisterRequest $request)
    {
        try {
            $input = $request->all();
            $user = User::create($input);
            $user['verification_token'] = Str::random(64);
            $user->save();
            $user->refresh();
            Mail::to($request->email)->send(new UserRegisterMail($user));
            $message = __('message.sign_up_success');
            return $this->sendResponse($message, []);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile() . $th->getLine(), $th);
        }
    }

    public function accountActive(Request $request)
    {
        try {
            if ($request->verification_token) {
                $user = User::where('verification_token', $request->verification_token)->first();
                if ($user) {
                    User::where('id', $user->id)->update(['status' => User::CONFORM]);
                    return redirect(config('serpwizz.account_active_fail_url'));
                }
            } else {
                return redirect(config('serpwizz.account_active_fail_url'));
            }
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $userData = $request->only('email', 'password');
            if (Auth::attempt($userData)) {
                $user = Auth::user();
                if ($user->role == User::USER && $user->status == User::CONFORM) {
                    $request->user()->tokens()->delete();
                    $token = $request->user()->createToken(config('app.name'))->plainTextToken;
                    User::loginUpdate($request);
                    $response = [
                        'user'  => new AuthResource($user),
                        'token' => $token,
                    ];
                    return $this->sendResponse('', $response);
                } else {
                    $message = __('message.login_without_confirm_status');
                    return $this->sendError($message, '', []);
                }
            } else {
                $message = __('message.password_incorrect');
                return $this->sendError($message, '', []);
            }
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    public function logOut(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user) {
                $tokenDelete =  $request->user()->tokens()->delete(); //token delete
                if ($tokenDelete) {
                    $message = __('message.logOut_success');
                    return $this->sendResponse($message, []);
                }
            }
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    public function profileUpdate(ProfileUpdateRequest $request)
    {
        try {
            $user = Auth::user();
            $input = $request->only('first_name', 'last_name', 'email', 'profile_image');
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

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                ForgetPassword::where('email', $request->email)->delete();
                $token = Str::random(64);
                $userData = [
                    User::EMAIL => $request->email,
                    User::TOKEN => $token,
                ];
                ForgetPassword::create($userData);
                $mailToken[User::TOKEN] = $token;
                Mail::to($request->email)->send(new ForgetPasswordMail($token));
                $message = __('message.forget_password_success');
                return $this->sendResponse($message, []);
            }
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $token = ForgetPassword::where('token', $request->token)->first();
            if ($token) {
                $password = bcrypt($request->password);
                User::where('email', $token->email)->update(['password' => $password]);
                $message = __('message.reset_password_success');
                $token->delete();
                return $this->sendResponse($message, []);
            } else {
                $message = __('message.reset_password_failed');
                return $this->sendError($message, '', []);
            }
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }
}
