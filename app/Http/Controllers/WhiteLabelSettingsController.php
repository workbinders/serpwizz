<?php

namespace App\Http\Controllers;

use App\Http\Requests\WhiteLabelSettingsRequest;
use App\Http\Resources\WhiteLabelSettingsResource;
use App\Models\User;
use App\Models\whiteLabelSettings;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WhiteLabelSettingsController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $data = User::with('whiteLabelSettings')->find($request->user()->id);
            $response = new WhiteLabelSettingsResource($data);
            return $this->sendResponse('', $response);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WhiteLabelSettingsRequest $request)
    {
        try {
            $user = Auth::user();
            if ($user) {
                $input = $request->all();
                $input['user_id'] = $user->id;
                $updateOrCreate = whiteLabelSettings::updateOrCreate(
                    [
                        'user_id' => $input['user_id'],
                    ],
                    [
                        'domain_name' => $input['domain_name'],
                        'audit_report_title' => $input['audit_report_title'],
                        'header_big_logo' => $input['header_big_logo'] ?? null,
                        'header_small_logo' => $input['header_small_logo'] ?? null,
                        'favicon_icon' => $input['favicon_icon'] ?? null,
                    ]
                );
                if ($updateOrCreate) {
                    $message = __('message.white_label_settings_success');
                    return   $this->sendResponse($message);
                } else {
                    $message = __('message.white_label_settings_failed');
                    return $this->sendError($message);
                }
            }
        } catch (\Throwable $th) {
            return  $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
